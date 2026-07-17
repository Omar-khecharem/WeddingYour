<?php

namespace App\Controllers\Admin;

use App\Core\Controller;

abstract class BaseAdminController extends Controller
{
    protected function view(string $view, array $data = [], string $layout = 'admin'): string
    {
        return parent::view($view, $data, $layout);
    }

    protected function success(string $message, string $redirectUrl): void
    {
        clearSiteCache();
        $this->flash('success', $message);
        $this->redirect($redirectUrl);
    }
}
