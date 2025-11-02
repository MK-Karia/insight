<?php

declare(strict_types=1);

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;

trait TraitController 
{
    public function getRequest(Request $request): array 
    {
        $data = json_decode($request->getContent(), true);

        return $data;
    }
}