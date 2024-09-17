<?php

namespace App\Testing\Infrastructure\Controller;

use App\Shared\Infrastructure\Controller\BaseController;
use App\Shared\Infrastructure\Helpers\ResponseHelper;
use App\Testing\Application\TestingSessionService;
use App\Testing\Application\UserResponseService;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Testing\Application\CorrectAnswerService;

#[Route('/result', name: 'testing_session_result', methods: ['GET'])]
class UserTestingResultsController extends BaseController
{
    use ResponseHelper;

    private array $requireParams = ['session'];
    private TestingSessionService $testingSessionService;
    private UserResponseService $userResponseService;
    private CorrectAnswerService $correctAnswerService;

    public function __construct(TestingSessionService $testingSessionService,
                                UserResponseService $userResponseService,
                                CorrectAnswerService $correctAnswerService
    )
    {
        $this->testingSessionService = $testingSessionService;
        $this->userResponseService = $userResponseService;
        $this->correctAnswerService = $correctAnswerService;
    }

    #[ArrayShape(['rights' => "array", 'fails' => "array"])]
    private function getResults(array $sessionAnswers): array
    {
        $results = [
            'rights' => [],
            'fails' => []
        ];

        foreach ($sessionAnswers as $key => $value) {
            $correctAnswers = $this->correctAnswerService->getAllAnswers($key);
            $userAnswers = $value['answers'];
            sort($userAnswers);

            $isCorrect = false;

            foreach ($correctAnswers as $correctAnswer) {
                $correctArr = explode(',', $correctAnswer->getCombination());
                sort($correctArr);

                if ($userAnswers == $correctArr) {
                    $isCorrect = true;
                    break;
                }
            }

            if ($isCorrect) {
                $results['rights'][] = $value['question'];
            } else {
                $results['fails'][] = $value['question'];
            }
        }

        return $results;
    }

    public function __invoke(Request $request): JsonResponse
    {
        if ($this->isRequestParamEmpty($request, $this->requireParams[0])) {
            return $this->errorBadRequest('Empty request content');
        }

        $sessionId = (int)$request->get('session');
        $session = $this->testingSessionService->findUserSession($sessionId);
        if (!$session || !$session->isEnd()) {
            return $this->errorNotFound('Session not valid');
        }

        $userAnswers = $this->userResponseService->getAllUserAnswersBySessionId($session);
        $sessionAnswers = [];
        foreach ($userAnswers as $userAnswer) {
            if (!isset($sessionAnswers[$userAnswer->getQuestion()->getId()])) {
                $sessionAnswers[$userAnswer->getQuestion()->getId()]['question'] = $userAnswer->getQuestion()->getText();
                $sessionAnswers[$userAnswer->getQuestion()->getId()]['answers'] = [];
            }
            array_push(
                $sessionAnswers[$userAnswer->getQuestion()->getId()]['answers'],
                $userAnswer->getAnswer()->getId()
            );
        }

        return $this->successOk($this->getResults($sessionAnswers));
    }
}