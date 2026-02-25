<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class ZkTestController extends Controller
{
    // public function test(): JsonResponse
    // {
    //     // عدّل المسار حسب المكان الذي وضعت فيه المكتبة
    //     $libPath = app_path('Services/ZKTeco/zklib/ZKLib.php');

    //     if (! file_exists($libPath)) {
    //         return response()->json([
    //             'ok' => false,
    //             'error' => 'ZKLib.php not found',
    //             'expected_path' => $libPath,
    //         ], 500);
    //     }

    //     require_once $libPath;

    //     $ip = '192.168.10.60';
    //     $port = 4370;

    //     try {
    //         $zk = new \ZKLib($ip, $port);

    //         $connected = $zk->connect();

    //         if (! $connected) {
    //             return response()->json([
    //                 'ok' => false,
    //                 'message' => 'FAILED TO CONNECT',
    //                 'ip' => $ip,
    //                 'port' => $port,
    //             ], 500);
    //         }

    //         // لو المكتبة تدعم، خذ معلومات بسيطة
    //         // (بعض نسخ ZKLib فيها getPlatform/getDeviceName… وبعضها لا)
    //         $zk->disconnect();

    //         return response()->json([
    //             'ok' => true,
    //             'message' => 'CONNECTED OK',
    //             'ip' => $ip,
    //             'port' => $port,
    //         ]);
    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'ok' => false,
    //             'message' => 'ERROR',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }
    public function test()
{
    $libPath = app_path('Services/ZKTeco/zklib/ZKLib.php');

    require_once $libPath;

    // اعرض الكلاسات التي تم تحميلها
    $classes = get_declared_classes();

    // فلترة أسماء ممكن تكون خاصة بالمكتبة
    $filtered = array_values(array_filter($classes, function ($c) {
        return stripos($c, 'zk') !== false; // أي كلاس فيه zk
    }));

    return response()->json([
        'ok' => true,
        'zk_related_classes' => $filtered,
        'hint' => 'Tell me which class is the device client class',
    ]);
}

}
