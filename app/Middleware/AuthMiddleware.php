<?php
/**
 * Auth Middleware
 * 
 * Ensures the user is authenticated before accessing protected routes.
 * Redirects unauthenticated users to the login page.
 *
 * @package App\Middleware
 */

namespace App\Middleware;

use App\Helpers\Session;

class AuthMiddleware
{
    /**
     * Handle the middleware check
     */
    public function handle(): void
    {
        if (!Session::has('user')) {
            Session::flash('warning', 'Please login to access this page.');
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? APP_URL;
            header('Location: ' . APP_URL . '/login');
            exit;
        }
    }
}
