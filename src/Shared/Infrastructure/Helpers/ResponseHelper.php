<?php

namespace App\Shared\Infrastructure\Helpers;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ResponseHelper
{
    #[ArrayShape(['status' => "string", 'message' => "string"])]
    private function getErrorMessage(string $message, string $statusMessage = 'error'): array
    {
        return ['status' => $statusMessage, 'message' => $message];
    }

    #[ArrayShape(['status' => "string", 'data' => "array"])]
    private function successMessage(array $data, string $statusMessage = 'success'): array
    {
        return ['status' => $statusMessage, 'data' => $data];
    }

    public function errorBadRequest(string $message): JsonResponse
    {
        return new JsonResponse($this->getErrorMessage($message), Response::HTTP_BAD_REQUEST);
    }

    public function errorNotFound(string $message): JsonResponse
    {
        return new JsonResponse($this->getErrorMessage($message), Response::HTTP_NOT_FOUND);
    }

    public function successOk(array $data): JsonResponse
    {
        return new JsonResponse($this->successMessage($data), Response::HTTP_OK);
    }

    public function successCreated(array $data): JsonResponse
    {
        return new JsonResponse($this->successMessage($data), Response::HTTP_CREATED);
    }
}