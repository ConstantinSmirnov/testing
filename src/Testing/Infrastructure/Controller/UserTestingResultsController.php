<?php

namespace App\Testing\Infrastructure\Controller;

use App\Shared\Infrastructure\Controller\BaseController;
use App\Shared\Infrastructure\Helpers\ResponseHelper;
use App\Testing\Application\TestingSessionService;
use App\Testing\Application\UserResponseService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/result', name: 'testing_session_result', methods: ['POST'])]
class UserTestingResults extends BaseController
{
    use ResponseHelper;

    private array $requireParams = ['session', 'ulid'];
    private TestingSessionService $testingSessionService;
    private UserResponseService $userResponseService;

    public function __construct(TestingSessionService $testingSessionService,
                                UserResponseService $userResponseService
    )
    {
        $this->testingSessionService = $testingSessionService;
        $this->userResponseService = $userResponseService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        if ($this->isBodyEmpty($request)) {
            return $this->errorBadRequest('Empty request content');
//            return $this->json(
//                ['status' => 'error', 'error' => 'Empty request content'],
//                Response::HTTP_BAD_REQUEST
//            );
        };
//        $content = $request->getContent();
//        if (empty($content)) {
//            return $this->json(
//                ['status' => 'error', 'error' => 'Empty request content'],
//                Response::HTTP_BAD_REQUEST
//            );
//        }
        $content = [];
        $data = json_decode($content, true);
        foreach ($this->requireParams as $param) {
            if (!isset($data[$param])) {
                return $this->json(
                    ['status' => 'error', 'error' => "Missing parameter: $param"],
                    Response::HTTP_BAD_REQUEST
                );
            }
        }

        $session = $this->testingSessionService->findUserSession($data['session']);
        if (!$session) {
            return $this->json(
                ['status' => 'error', 'error' => "Session not found"],
                Response::HTTP_NOT_FOUND
            );
        }

        if (!$session->isEnd()) {
            return $this->json(
                ['status' => 'error', 'error' => "This session is not ended"],
                Response::HTTP_NOT_FOUND
            );
        }

        $userAnswers = $this->userResponseService->getAllUserAnswersBySessionId($session);
        foreach ($userAnswers as $userAnswer) {
            dd($userAnswer->getQuestion()->getId());
        }

        return $this->json([
            'status' => 'success'
        ]);
    }
}