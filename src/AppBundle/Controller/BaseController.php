<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class BaseController extends Controller
{
    /**
     * @param string $error
     *
     * @return JsonResponse
     */
    protected function createErrorResponse(string $error): JsonResponse
    {
        return new JsonResponse(
            [
                'success' => false,
                'error' => $error,
            ]
        );
    }

    /**
     * @param string $redirect
     *
     * @return JsonResponse
     */
    protected function createSuccessResponse(string $redirect = ''): JsonResponse
    {
        return new JsonResponse(
            [
                'success' => true,
                'redirect' => $redirect,
            ]
        );
    }
}
