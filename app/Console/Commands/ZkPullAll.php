<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Rats\Zkteco\Lib\ZKTeco;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use App\Models\ZkDeviceUser;
use App\Models\ZkAttendanceLog;

class ZkPullAll extends Command
{
    protected $signature   = 'zk:pull-all {ip} {port=4370} {--db=1} {--files=0} {--clear=0}';
    protected $description = 'Pull ZKTeco data (users + attendance). Save to DB and/or files.';

    public function handle()
    {
        // ── رفع الـ timeout قبل أي شيء ───────────────────────
        set_time_limit(0);                        // بلا حد — الجهاز قد يكون بطيئاً
        ini_set('memory_limit', '256M');
        ini_set('default_socket_timeout', '120'); // 2 دقيقة لكل socket read

        $ip         = $this->argument('ip');
        $port       = (int) $this->argument('port');
        $saveToDb   = (bool) ((int) $this->option('db'));
        $saveFiles  = (bool) ((int) $this->option('files'));
        $clearAfter = (bool) ((int) $this->option('clear'));
        $startTime  = microtime(true);

        $this->line('');
        $this->logInfo("═══════════════════════════════════════════");
        $this->logInfo("  بدء المزامنة");
        $this->logInfo("  IP: {$ip} | Port: {$port}");
        $this->logInfo("  PHP timeout: " . (ini_get('max_execution_time') ?: 'unlimited'));
        $this->logInfo("  Memory: " . ini_get('memory_limit'));
        $this->logInfo("═══════════════════════════════════════════");
        $this->line('');

        // ════════════════════════════════════════════
        // [1] فحص الشبكة
        // ════════════════════════════════════════════
        $this->logStep(1, 5, "فحص الاتصال بالشبكة");
        $socket = @fsockopen($ip, $port, $errno, $errstr, 5);
        if (!$socket) {
            $this->logError("فشل الشبكة | {$errstr} (كود: {$errno})");
            return self::FAILURE;
        }
        fclose($socket);
        $this->logOk("الشبكة متاحة");

        // ════════════════════════════════════════════
        // [2] الاتصال بالجهاز
        // ════════════════════════════════════════════
        $this->logStep(2, 5, "الاتصال بجهاز ZKTeco");
        $zk = new ZKTeco($ip, $port);

        try {
            $t         = microtime(true);
            $connected = $zk->connect();
            $this->logInfo("connect() → " . ($connected ? 'نجح' : 'فشل') . " | " . $this->elapsed($t));

            if (!$connected) {
                $this->logError("تعذر الاتصال — تحقق من IP/Port وأن الجهاز مشغّل");
                return self::FAILURE;
            }
            $this->logOk("تم الاتصال بالجهاز");

            // إيقاف الجهاز مؤقتاً
            try {
                $zk->disableDevice();
                $this->logInfo("الجهاز موقوف مؤقتاً أثناء السحب");
            } catch (\Throwable $e) {
                $this->logWarn("تعذر إيقاف الجهاز (غير حرج): " . $e->getMessage());
            }

            // ════════════════════════════════════════════
            // [3] معلومات الجهاز
            // ════════════════════════════════════════════
            $this->logStep(3, 5, "جلب معلومات الجهاز");
            $deviceInfo = ['ip' => $ip, 'port' => $port];
            foreach (['serialNumber', 'platform', 'deviceName', 'fmVersion'] as $method) {
                try {
                    if (method_exists($zk, $method)) {
                        $val                 = $zk->$method();
                        $deviceInfo[$method] = $val;
                        $this->logInfo("  {$method} = " . json_encode($val, JSON_UNESCAPED_UNICODE));
                    }
                } catch (\Throwable $e) {
                    $this->logWarn("  {$method}() فشل: " . $e->getMessage());
                }
            }

            // ════════════════════════════════════════════
            // [4] سحب المستخدمين
            // ════════════════════════════════════════════
            $this->logStep(4, 5, "جلب المستخدمين من الجهاز");
            $users = $this->fetchUsers($zk);

            // ════════════════════════════════════════════
            // [5] سحب الحضور
            // ════════════════════════════════════════════
            $this->logStep(5, 5, "جلب سجلات الحضور من الجهاز");
            $this->logWarn("هذه الخطوة قد تأخذ دقيقة أو أكثر حسب حجم سجلات الجهاز...");
            $attendance = $this->fetchAttendance($zk);

            // ════════════════════════════════════════════
            // حفظ في DB
            // ════════════════════════════════════════════
            if ($saveToDb) {
                $this->line('');
                $this->logInfo("══════════════ حفظ في قاعدة البيانات ══════════════");
                $this->saveUsers($ip, $users);
                $this->saveAttendance($ip, $attendance);
            }

            // ════════════════════════════════════════════
            // حفظ ملفات
            // ════════════════════════════════════════════
            if ($saveFiles && (count($users) > 0 || count($attendance) > 0)) {
                $folder = "zkteco/{$ip}/" . now()->format('Y-m-d_His');
                Storage::disk('local')->put(
                    "{$folder}/all.json",
                    json_encode(compact('deviceInfo', 'users', 'attendance'), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
                );
                $this->logOk("ملفات محفوظة في: storage/app/{$folder}");
            }

            // ════════════════════════════════════════════
            // مسح الجهاز (اختياري)
            // ════════════════════════════════════════════
            if ($clearAfter && count($attendance) > 0) {
                $this->logWarn("مسح سجلات الحضور من الجهاز...");
                try {
                    $zk->clearAttendance();
                    $this->logOk("تم مسح السجلات من الجهاز");
                } catch (\Throwable $e) {
                    $this->logError("فشل المسح: " . $e->getMessage());
                }
            }

            // إعادة تشغيل الجهاز
            try {
                $zk->enableDevice();
                $this->logInfo("الجهاز يعمل مجدداً");
            } catch (\Throwable $e) {
                $this->logWarn("تعذر إعادة تشغيل الجهاز: " . $e->getMessage());
            }

            $zk->disconnect();

            $total = round(microtime(true) - $startTime, 2);
            $this->line('');
            $this->logInfo("═══════════════════════════════════════════");
            $this->logOk("اكتملت المزامنة بنجاح");
            $this->logInfo("  مستخدمون : " . count($users));
            $this->logInfo("  حضور      : " . count($attendance));
            $this->logInfo("  الوقت الكلي: {$total}s");
            $this->logInfo("═══════════════════════════════════════════");
            $this->line('');

            return self::SUCCESS;

        } catch (\Throwable $e) {
            $this->line('');
            $this->logError("خطأ غير متوقع: " . $e->getMessage());
            $this->logError("النوع : " . get_class($e));
            $this->logError("الملف : " . $e->getFile() . " | السطر: " . $e->getLine());
            $this->logError("Stack :\n" . $e->getTraceAsString());

            try { $zk->enableDevice(); } catch (\Throwable $x) {}
            try { $zk->disconnect();   } catch (\Throwable $x) {}

            return self::FAILURE;
        }
    }

    // ════════════════════════════════════════════════════════
    // fetchUsers
    // ════════════════════════════════════════════════════════
    private function fetchUsers(ZKTeco $zk): array
    {
        $t = microtime(true);
        try {
            $this->logInfo("  استدعاء getUser()...");
            $raw = $zk->getUser() ?? [];

            $this->logInfo("  getUser() انتهى | " . $this->elapsed($t));
            $this->logInfo("  نوع: " . gettype($raw) . " | عدد: " . count($raw));

            if (empty($raw)) {
                $this->logWarn("  لا يوجد مستخدمون في الجهاز");
                return [];
            }

            $firstKey = array_key_first($raw);
            $this->logInfo("  أول مفتاح: " . json_encode($firstKey));
            $this->logInfo("  أول عنصر : " . json_encode($raw[$firstKey], JSON_UNESCAPED_UNICODE));

            // تطبيع آمن — يعمل سواء كانت مصفوفة عادية أو مصفوفة associative أو objects
            $users = array_values(array_filter(
                array_map(fn($u) => is_object($u) ? (array) $u : (is_array($u) ? $u : null), $raw),
                fn($u) => $u !== null
            ));

            if (!empty($users)) {
                $this->logInfo("  مفاتيح المستخدم: " . implode(', ', array_keys($users[0])));
                $this->logInfo("  نموذج: " . json_encode($users[0], JSON_UNESCAPED_UNICODE));
            }

            $this->logOk("تم جلب " . count($users) . " مستخدم");
            return $users;

        } catch (\Throwable $e) {
            $this->logError("  getUser() خطأ بعد " . $this->elapsed($t) . ": " . $e->getMessage());
            $this->logError("  في: " . $e->getFile() . ":" . $e->getLine());
            return [];
        }
    }

    // ════════════════════════════════════════════════════════
    // fetchAttendance
    // ════════════════════════════════════════════════════════
    private function fetchAttendance(ZKTeco $zk): array
    {
        $t = microtime(true);
        try {
            $this->logInfo("  استدعاء getAttendance()...");
            $raw = $zk->getAttendance() ?? [];

            $this->logInfo("  getAttendance() انتهى | " . $this->elapsed($t));
            $this->logInfo("  عدد السجلات: " . count($raw));

            if (empty($raw)) {
                $this->logWarn("  لا توجد سجلات حضور في الجهاز");
                return [];
            }

            $firstKey = array_key_first($raw);
            $first    = is_object($raw[$firstKey]) ? (array) $raw[$firstKey] : $raw[$firstKey];
            $this->logInfo("  مفاتيح السجل : " . implode(', ', array_keys($first)));
            $this->logInfo("  نموذج أول    : " . json_encode($first, JSON_UNESCAPED_UNICODE));
            $this->logInfo("  نموذج أخير   : " . json_encode(end($raw), JSON_UNESCAPED_UNICODE));

            $this->logOk("تم جلب " . count($raw) . " سجل حضور");
            return array_values($raw);

        } catch (\Throwable $e) {
            $this->logError("  getAttendance() فشل بعد " . $this->elapsed($t) . ": " . $e->getMessage());
            $this->logError("  النوع : " . get_class($e));
            $this->logError("  في    : " . $e->getFile() . ":" . $e->getLine());
            return [];
        }
    }

    // ════════════════════════════════════════════════════════
    // saveUsers
    // ════════════════════════════════════════════════════════
    private function saveUsers(string $ip, array $users): void
    {
        if (empty($users)) {
            $this->logWarn("  لا مستخدمين للحفظ");
            return;
        }

        $saved = $skipped = 0;
        $t     = microtime(true);

        foreach ($users as $u) {
            $uid    = $u['uid']      ?? $u['UID']                            ?? null;
            $userId = $u['userid']   ?? $u['user_id'] ?? $u['id'] ?? $u['ID'] ?? null;
            $name   = $u['name']     ?? $u['Name']                            ?? null;
            $role   = $u['role']     ?? $u['Role']                            ?? null;
            $pass   = $u['password'] ?? $u['Password']                        ?? null;

            if ($uid === null) { $skipped++; continue; }

            ZkDeviceUser::updateOrCreate(
                ['device_ip' => $ip, 'uid' => (string) $uid],
                [
                    'user_id'  => $userId !== null ? (string) $userId : null,
                    'name'     => $name,
                    'role'     => $role  !== null ? (string) $role    : null,
                    'password' => $pass,
                ]
            );
            $saved++;
        }

        $this->logOk("مستخدمون | محفوظ: {$saved} | متجاهل: {$skipped} | " . $this->elapsed($t));
    }

    // ════════════════════════════════════════════════════════
    // saveAttendance
    // ════════════════════════════════════════════════════════
    private function saveAttendance(string $ip, array $attendance): void
    {
        if (empty($attendance)) {
            $this->logWarn("  لا سجلات حضور للحفظ");
            return;
        }

        $toInsert = [];
        $invalid  = 0;
        $t        = microtime(true);

        foreach ($attendance as $idx => $row) {
            if (is_object($row)) $row = (array) $row;

            $uid    = $row['uid']       ?? $row['UID']                                       ?? null;
            $userId = $row['id']        ?? $row['ID']   ?? $row['user_id'] ?? $row['userid'] ?? null;
            $state  = $row['state']     ?? $row['State']                                     ?? null;
            $tsRaw  = $row['timestamp'] ?? $row['Timestamp'] ?? $row['time'] ?? $row['Time'] ?? null;

            if ($uid === null || $tsRaw === null) {
                $invalid++;
                if ($idx < 3) {
                    $this->logWarn("  سجل ناقص [{$idx}]: " . json_encode($row, JSON_UNESCAPED_UNICODE));
                }
                continue;
            }

            try {
                $ts = Carbon::parse($tsRaw);
            } catch (\Throwable $e) {
                $invalid++;
                continue;
            }

            $toInsert[] = [
                'device_ip'  => $ip,
                'uid'        => (string) $uid,
                'user_id'    => $userId !== null ? (string) $userId : null,
                'state'      => $state  !== null ? (string) $state  : null,
                'timestamp'  => $ts,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $this->logInfo("  جاهز للإدخال: " . count($toInsert) . " | غير صالح: {$invalid}");

        $inserted = $duplicate = 0;
        foreach (array_chunk($toInsert, 500) as $ci => $chunk) {
            $new       = ZkAttendanceLog::insertOrIgnore($chunk);
            $inserted += $new;
            $duplicate += count($chunk) - $new;
            $this->logInfo("  Chunk " . ($ci + 1) . " | " . count($chunk) . " سجل → جديد: {$new} | مكرر: " . (count($chunk) - $new));
        }

        $this->logOk("حضور | جديد: {$inserted} | مكرر: {$duplicate} | غير صالح: {$invalid} | " . $this->elapsed($t));
    }

    // ════════════════════════════════════════════════════════
    // أدوات مساعدة
    // ════════════════════════════════════════════════════════
    private function elapsed(float $start): string
    {
        return round(microtime(true) - $start, 2) . "s";
    }

    private function logStep(int $step, int $total, string $msg): void
    {
        $this->line('');
        $this->logInfo("── [{$step}/{$total}] {$msg}");
    }

    private function logOk(string $msg): void
    {
        $line = "✅ {$msg}";
        $this->info($line);
        Log::channel('daily')->info("[ZkPullAll] {$line}");
    }

    private function logInfo(string $msg): void
    {
        $this->info($msg);
        Log::channel('daily')->info("[ZkPullAll] {$msg}");
    }

    private function logWarn(string $msg): void
    {
        $line = "⚠️  {$msg}";
        $this->warn($line);
        Log::channel('daily')->warning("[ZkPullAll] {$line}");
    }

    private function logError(string $msg): void
    {
        $line = "❌ {$msg}";
        $this->error($line);
        Log::channel('daily')->error("[ZkPullAll] {$line}");
    }
}