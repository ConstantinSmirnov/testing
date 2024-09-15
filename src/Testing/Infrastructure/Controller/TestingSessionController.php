<?php

namespace App\Testing\Infrastructure\Controller;

use App\Testing\Application\QuestionService;
use App\Testing\Application\TestingSessionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/start-testing-session', name: 'testing_session', methods: ['POST'])]
class TestingSessionController extends AbstractController
{
    private TestingSessionService $testingSessionService;
    private QuestionService $questionService;

    public function __construct(TestingSessionService $testingSessionService, QuestionService $questionService)
    {
        $this->testingSessionService = $testingSessionService;
        $this->questionService = $questionService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $session = $this->testingSessionService->handleRequest($data['name']);
        $questions = $this->questionService->handleRequest($session);

        $result = [];
        foreach ($questions as $question) {
            $answers = $question->getAnswers();

            $answersArray = [];
            foreach ($answers as $answer) {
                $answersArray[] = [
                    'id' => $answer->getId(),
                    'text' => $answer->getText()
                ];
            }

            $result[] = [
                'question' => [
                    'id' => $question->getId(),
                    'text' => $question->getText()
                ],
                'answers' => $answersArray
            ];
        }

        return $this->json([
            'status' => 'success',
            'data' => $result,
            'session' => [
                'id' => $session->getId(),
                'isEnd' => $session->isEnd()
            ],
        ]);
    }
}