<?php

namespace App\Testing\Infrastructure\Controller;

use App\Shared\Infrastructure\Controller\BaseController;
use App\Shared\Infrastructure\Helpers\ResponseHelper;
use App\Testing\Application\QuestionService;
use App\Testing\Application\TestingSessionService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/start', name: 'testing_session', methods: ['POST'])]
class TestingSessionController extends BaseController
{
    use ResponseHelper;

    private array $requireParams = ['name'];
    private TestingSessionService $testingSessionService;
    private QuestionService $questionService;

    public function __construct(TestingSessionService $testingSessionService, QuestionService $questionService)
    {
        $this->testingSessionService = $testingSessionService;
        $this->questionService = $questionService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        if ($this->isBodyEmpty($request)) {
            return $this->errorBadRequest('Empty request content');
        }

        $data = json_decode($request->getContent(), true);
        if (!$this->isRequireParamsExists($data, $this->requireParams)) {
            return $this->errorBadRequest('Missing parameter');
        }

        $session = $this->testingSessionService->handleRequest($data['name']);
        $questions = $this->questionService->getQuestionsWithAnswers($session);

        return $this->json([
            'status' => 'success',
            'data' => $questions,
            'session' => [
                'id' => $session->getId(),
                'isEnd' => $session->isEnd()
            ],
        ]);
    }
}