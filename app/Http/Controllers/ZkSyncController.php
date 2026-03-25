<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\ZkAttendanceLog;
use Carbon\Carbon;

class ZkSyncController extends Controller
{
    public function sync(Request $request)
    {
        $ip   = $request->input('ip', '192.168.10.201');
        $port = (int) $request->input('port', 4370);

        // Validate IP
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return $this->errorResponse('عنوان IP غير صحيح', 422);
        }

        // Check device connectivity
        if (!$this->canConnect($ip, $port)) {
            return $this->errorResponse("لا يمكن الوصول للجهاز ({$ip}:{$port})", 503);
        }

        try {

            $exitCode = Artisan::call('zk:pull-all', [
                'ip'      => $ip,
                'port'    => $port,
                '--db'    => 1,
                '--files' => 0,
                '--clear' => 0,
            ]);

            $output = Artisan::output();

            $details = [
                'new_logs'   => $this->extractNumber($output, '/New logs inserted:\s*(\d+)/'),
                'new_users'  => $this->extractNumber($output, '/Users saved\/updated:\s*(\d+)/'),
                'total_logs' => $this->extractNumber($output, '/Attendance pulled:\s*(\d+)/'),
            ];

            if ($exitCode === 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'تمت المزامنة بنجاح',
                    'details' => $details
                ]);
            }

            return $this->errorResponse('فشلت المزامنة', 500, [
                'output' => $output
            ]);

        } catch (\Throwable $e) {
            return $this->errorResponse('خطأ أثناء المزامنة: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Device connection check
     */
    private function canConnect($ip, $port)
    {
        $socket = @fsockopen($ip, $port, $errno, $errstr, 5);

        if (!$socket) {
            return false;
        }

        fclose($socket);
        return true;
    }

    /**
     * Extract numbers from command output
     */
    private function extractNumber($text, $pattern)
    {
        preg_match($pattern, $text, $match);
        return $match[1] ?? 0;
    }

    /**
     * Unified error response
     */
    private function errorResponse($message, $code = 400, $extra = [])
    {
        return response()->json(array_merge([
            'success' => false,
            'message' => $message
        ], $extra), $code);
    }

    /**
     * Sync status
     */
    public function status()
    {
        try {

            $last = ZkAttendanceLog::latest('timestamp')->first();

            return response()->json([
                'last_log' => $last?->timestamp
                    ? Carbon::parse($last->timestamp)->format('Y-m-d H:i:s')
                    : null,

                'last_sync' => $last?->created_at
                    ? $last->created_at->diffForHumans()
                    : 'لا يوجد',

                'total' => ZkAttendanceLog::count(),
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'last_log'  => null,
                'last_sync' => '-',
                'total'     => 0
            ]);
        }
    }
}