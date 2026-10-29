<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class HealthCheckController extends Controller
{
    /**
     * Production Health & Readiness Probe.
     */
    public function __invoke(): JsonResponse
    {
        $startTime = defined('LARAVEL_START') ? LARAVEL_START : microtime(true);
        $uptimeMs = round((microtime(true) - $startTime) * 1000, 2);

        // Check Database Connection
        $dbStatus = 'healthy';
        $dbLatencyMs = null;
        try {
            $dbStart = microtime(true);
            DB::connection()->getPdo();
            $dbLatencyMs = round((microtime(true) - $dbStart) * 1000, 2);
        } catch (\Throwable $e) {
            $dbStatus = 'unhealthy: ' . $e->getMessage();
        }

        // Check Disk Free Space
        $diskFreeBytes = disk_free_space(base_path());
        $diskFreeGb = round($diskFreeBytes / (1024 * 1024 * 1024), 2);

        $isHealthy = ($dbStatus === 'healthy');

        return response()->json([
            'status' => $isHealthy ? 'healthy' : 'degraded',
            'app' => 'Kashmir Sheeps Marketplace',
            'environment' => config('app.env'),
            'version' => '1.0.0',
            'timestamp' => now()->toIso8601String(),
            'checks' => [
                'database' => [
                    'status' => $dbStatus,
                    'driver' => config('database.default'),
                    'latency_ms' => $dbLatencyMs,
                ],
                'storage' => [
                    'status' => $diskFreeGb > 1 ? 'healthy' : 'warning_low_disk',
                    'free_disk_gb' => $diskFreeGb,
                ],
                'system' => [
                    'php_version' => PHP_VERSION,
                    'memory_usage_mb' => round(memory_get_usage(true) / 1024 / 1024, 2),
                    'uptime_latency_ms' => $uptimeMs,
                ]
            ]
        ], $isHealthy ? 200 : 503);
    }
}
