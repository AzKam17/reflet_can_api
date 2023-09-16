<?php

namespace App\Service\Request;

use Symfony\Component\HttpFoundation\Request;

class JsonRequestService
{
    public function __invoke(Request $request)
    {
        return json_decode($request->getContent(), true);
    }
}
