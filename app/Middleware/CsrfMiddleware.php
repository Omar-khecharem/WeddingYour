<?php
/**
 * CSRF Middleware
 * 
 * Validates CSRF tokens on all state-changing POST/PUT/DELETE requests.
 * Protects against Cross-Site Request Forgery attacks.
 *
 * @package App\Middleware
 */

namespace App\Middleware;

use App\Helpers\Session;

class CsrfMiddleware
{
    /**
     * Handle the middleware check
     */
    public function handle(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        // Only check state-changing methods
        if (!in_array(strtoupper($method), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return;
        }

        // Skip CSRF check for API requests with proper auth
        if (strpos($_SERVER['REQUEST_URI'] ?? '', '/api/') === 0) {
            return;
        }

        $token = $_POST[CSRF_TOKEN_NAME] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

        if (empty($token) || !Session::verifyCsrf($token)) {
            http_response_code(419);
            $isAjax = strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest'
                   || strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false;
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'CSRF token mismatch', 'message' => 'Security token expired. Please refresh the page and try again.']);
            } else {
                Session::flash('error', 'Security token expired. Please refresh the page and try again.');
                header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? APP_URL), true, 302);
            }
            exit;
        }
    }
}
