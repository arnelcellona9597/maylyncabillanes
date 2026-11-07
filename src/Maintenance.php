<?php
declare(strict_types=1);

/**
 * Maintenance mode. Switched on by the presence of a `maintenance.flag` file:
 *  - live server: one level above the web root, next to .env (e.g. /maintenance.flag)
 *  - local / fallback: in the project root
 * No code change or redeploy is needed to toggle it: create or delete the file.
 */
final class Maintenance
{
    public static function active(): bool
    {
        $root = dirname(__DIR__);
        if (is_file($root . '/maintenance.flag')) {
            return true;
        }
        $parent = dirname($root);
        return is_file($parent . '/.env') && is_file($parent . '/maintenance.flag');
    }

    /** Send a 503 maintenance response for a page request and stop. */
    public static function renderPage(): never
    {
        http_response_code(503);
        header('Retry-After: 3600');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('X-Robots-Tag: noindex, nofollow');
        header('Content-Type: text/html; charset=utf-8');
        require __DIR__ . '/maintenance-page.php';
        exit;
    }

    /** Send a 503 JSON response for API requests and stop. */
    public static function renderJson(): never
    {
        http_response_code(503);
        header('Retry-After: 3600');
        header('Cache-Control: no-store');
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false, 'message' => 'The site is down for maintenance. Please try again later or email info@maylyncabillanes.com.']);
        exit;
    }
}
