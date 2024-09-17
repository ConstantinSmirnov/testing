<?php

namespace App\Shared\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends AbstractController
{
    public function isRequestParamEmpty(Request $request, string $param): bool
    {
        return $request->get($param) === null;
    }

    public function isBodyEmpty(Request $request): bool
    {
        return empty($request->getContent());
    }

    public function isRequireParamsExists(array $data, array $requireParams): bool
    {
        foreach ($requireParams as $param) {
            if (!isset($data[$param])) {
                return false;
            }
        }
        return true;
    }
}