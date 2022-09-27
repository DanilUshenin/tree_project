<?php

namespace Controllers;

class ErrorPageController
{
    public function view()
    {
        $title = 'Page not found';
        http_response_code(404);
        require_once(ROOT . '/views/error_page/error_page.php');
    }
}