<?php

namespace App\Testing\Infrastructure\Controller;

use App\Testing\Application\QuestionService;
use App\Testing\Application\TestingSessionService;
use App\Testing\Application\UserResponseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Testing\Application\AnswersService;

#[Route('/answer/save', name: 'user_response', methods: ['POST'])]
class UserResponseController extends AbstractController
{
    private array $requireParams = ['session', 'question', 'answers'];
    private TestingSessionService $testingSessionService;
    private QuestionService $questionService;
    private AnswersService $answersService;
    private UserResponseService $userResponseService;

    public function __construct(TestingSessionService $testingSessionService,
                                QuestionService $questionService,
                                AnswersService $answersService,
                                UserResponseService $userResponseService
    )
    {
        $this->testingSessionService = $testingSessionService;
        $this->questionService = $questionService;
        $this->answersService = $answersService;
        $this->userResponseService = $userResponseService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $content = $request->getContent();

        if (empty($content)) {
            return $this->json(
                ['status' => 'error', 'error' => 'Empty request content'],
                Response::HTTP_BAD_REQUEST
            );
        }

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

        $question = $this->questionService->findQuestionById($data['question']);
        if (!$question) {
            return $this->json(
                ['status' => 'error', 'error' => "Question not found"],
                Response::HTTP_NOT_FOUND
            );
        }

        $data['answers'] = array_unique($data['answers']);

        $errors = [];
        $answers = [];

        if (!empty($errors)) {
            return $this->json(
                ['status' => 'error', 'error' => "Answers not found: " . implode(', ', $errors)],
                Response::HTTP_NOT_FOUND
            );
        }

        foreach ($data['answers'] as $answerId) {
            $answer = $this->answersService->findAnswerById($answerId);
            if (!$answer) {
                $errors[] = $answerId;
            } else {
                $answers[] = $answer;
            }
        }

        foreach ($answers as $answer) {
            $this->userResponseService->handleRequest($question, $answer, $session->getUser(), $session);
        }

        return $this->json(
            ['status' => 'success', 'session' => $session->getId(), 'isEnd' => $session->isEnd()],
            Response::HTTP_CREATED
        );
    }
}