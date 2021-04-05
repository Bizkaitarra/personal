<?php


namespace App\Exam\Infrastructure;


use App\Exam\Application\RamdomQuestionFinder;
use App\Exam\Domain\ApplicationId;
use App\Exam\Domain\Exceptions\ExamsForApplicationIdNotFound;
use App\Exam\Domain\Exceptions\QuestionsForAplicationIdNotFound;
use App\Shared\Infrastructure\ApiController;
use Symfony\Component\HttpFoundation\Response;

class RandomQuestion extends ApiController
{
    private RamdomQuestionFinder $questionFinder;

    public function __construct(RamdomQuestionFinder $questionFinder)
    {
        $this->questionFinder = $questionFinder;
    }

    public function __invoke(string $applicationId)
    {
        try {
            $applicationIdVO = new ApplicationId($applicationId);
            $question = $this->questionFinder->__invoke($applicationIdVO);
        } catch (ExamsForApplicationIdNotFound | QuestionsForAplicationIdNotFound $exception) {
            return $this->serializeResponse(Response::HTTP_BAD_REQUEST,
                ['message' => $exception->getMessage()]);
        }

        return $this->serializeResponse(Response::HTTP_OK, $question);

    }

}