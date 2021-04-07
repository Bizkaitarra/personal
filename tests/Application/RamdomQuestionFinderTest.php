<?php


namespace App\Tests\Application;


use App\Entity\Exam;
use App\Exam\Application\RamdomQuestionFinder;
use App\Exam\Domain\ApplicationId;
use App\Exam\Domain\Exceptions\ExamsForApplicationIdNotFound;
use App\Exam\Domain\Exceptions\QuestionsForAplicationIdNotFound;
use App\Exam\Domain\Repository\ExamRepository;
use App\Exam\Domain\Repository\QuestionRepository;
use App\Tests\Domain\ExamMother;
use PHPUnit\Framework\TestCase;

class RamdomQuestionFinderTest extends TestCase
{
    public function testNoExamsFound() {
        $examRepositoryMock = $this->createMock(ExamRepository::class);
        $examRepositoryMock->method('findByApplication')->willReturn([]);
        $questionRepositoryMock = $this->createMock(QuestionRepository::class);
        $questionRepositoryMock->method('findRamdomQuestion')->willReturn(null);
        $questionFinder = new RamdomQuestionFinder($examRepositoryMock, $questionRepositoryMock);
        $this->expectException(ExamsForApplicationIdNotFound::class);
        $questionFinder->__invoke(new ApplicationId(2));
    }

    public function testNoQuestionsFound() {
        $examRepositoryMock = $this->createMock(ExamRepository::class);
        $examRepositoryMock->method('findByApplication')->willReturn([ExamMother::generateRandomExam()]);
        $questionRepositoryMock = $this->createMock(QuestionRepository::class);
        $questionRepositoryMock->method('findRamdomQuestion')->willReturn(null);
        $questionFinder = new RamdomQuestionFinder($examRepositoryMock, $questionRepositoryMock);
        $this->expectException(QuestionsForAplicationIdNotFound::class);
        $questionFinder->__invoke(new ApplicationId(2));
    }

    public function testMultipleExamsWithoutQuestionsFound() {
        $examRepositoryMock = $this->createMock(ExamRepository::class);
        $examRepositoryMock->method('findByApplication')->willReturn([ExamMother::generateRandomExam(),ExamMother::generateRandomExam()]);
        $questionRepositoryMock = $this->createMock(QuestionRepository::class);
        $questionRepositoryMock->method('findRamdomQuestion')->willReturn(null);
        $questionFinder = new RamdomQuestionFinder($examRepositoryMock, $questionRepositoryMock);
        $this->expectException(QuestionsForAplicationIdNotFound::class);
        $questionFinder->__invoke(new ApplicationId(2));
    }

    public function testOneExamWithoutQuestions() {
        $examRepositoryMock = $this->createMock(ExamRepository::class);
        $examRepositoryMock->method('findByApplication')->willReturn([ExamMother::generateRandomExam(),ExamMother::generateRandomExam()]);
        $questionRepositoryMock = $this->createMock(QuestionRepository::class);
        $questionRepositoryMock->method('findRamdomQuestion')->willReturn(null);
        $questionFinder = new RamdomQuestionFinder($examRepositoryMock, $questionRepositoryMock);
        $this->expectException(QuestionsForAplicationIdNotFound::class);
        $questionFinder->__invoke(new ApplicationId(2));
    }

}