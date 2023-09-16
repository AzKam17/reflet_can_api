<?php

namespace App\Helpers;

class SlugFromEmail
{
    public function __invoke($email)
    {
        return str_replace(['@', '.'], '_', $email);
    }
}
