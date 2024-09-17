<?php

namespace App\Testing\Infrastructure\Controller;

use App\Shared\Infrastructure\Controller\BaseController;
use App\Shared\Infrastructure\Helpers\ResponseHelper;
use App\Testing\Application\QuestionService;
use App\Testing\Application\TestingSessionService;
use App\Testing\Application\UserResponseService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Testing\Application\AnswersService;

#[Route('/answer/save', name: 'user_response', methods: ['POST'])]
class UserResponseController extends BaseController
{
    use ResponseHelper;

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
        if ($this->isBodyEmpty($request)) {
            return $this->errorBadRequest('Empty request content');
        }

        $data = json_decode($request->getContent(), true);
        if (!$this->isRequireParamsExists($data, $this->requireParams)) {
            return $this->errorBadRequest('Missing parameter');
        }

        $session = $this->testingSessionService->findUserSession($data['session']);
        if (!$session) {
            return $this->errorNotFound('Session not valid');
        }

        $question = $this->questionService->findQuestionById($data['question']);
        if (!$question) {
            return $this->errorNotFound('Question is not found');
        }

        $data['answers'] = array_unique($data['answers']);

        $errors = [];
        $answers = [];

        if (!empty($errors)) {
            return $this->errorNotFound('Answers not found');
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

        $returnedData = ['session' => $session->getId(), 'isEnd' => $session->isEnd()];

        return $this->successCreated($returnedData);
    }
}