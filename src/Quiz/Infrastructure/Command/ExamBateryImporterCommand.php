<?php

namespace App\Quiz\Infrastructure\Command;

use App\Entity\Exam;
use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class ExamBateryImporterCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct('import:battery');
        $this->entityManager = $entityManager;
    }


    protected static $defaultDescription = 'Imports exams in data folder';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $inputQuestions = file_get_contents(__DIR__ . '/../data/ope2023bateria.txt');

        $exam = new Exam();
        $exam->setState(false);
        $exam->setName('OSAKIDETZA');
        $exam->setType('OSAKIDETZA - Bateria');
        $exam->setApplication(1);
        $exam->setDescription('Ope 2023 batería temario común');
        $exam->setOrdering(1000);
        $exam->setUrl('');
        $this->entityManager->persist($exam);

        $questions = $this->parseQuestions($inputQuestions, $exam);
        foreach($questions as $question) {
            $this->entityManager->persist($question);
        }
        $this->entityManager->flush();
        return Command::SUCCESS;

    }

    private function parseQuestions(string $text, Exam $exam): array
    {
        preg_match_all('/(\d+\.- .+?(?=\n{2,}|\z))/s', $text, $matches);

        $result = array();
        foreach ($matches[0] as $match) {
            $question = $this->parseQuestion($match, $exam);
            $result[] = $question;
        }

        return $result;
    }
    private function parseQuestion(string $text, Exam $exam): Question
    {
        $regex = '/^(\d+\.-)\s+(.+?)\s+(a\).+?)(b\).+?)(c\).+?)(d\).+?)$/s';
        preg_match($regex, $text, $matches);

        $question = new Question();
        $question->setQuestion($this->trimEnters($matches[2]));
        $question->setOrdering(str_replace('.-','',$matches[1]));
        $question->setNumber(str_replace('.-','',$matches[1]));
        $question->setExam($exam);
        $question->setA($this->trimEnters($matches[3]));
        $question->setB($this->trimEnters($matches[4]));
        $question->setC($this->trimEnters($matches[5]));
        $question->setD($this->trimEnters($matches[6]));
        $question->setDetailedAnswer('');
        $question->setAnswer(-1);
        $question->setState(false);
        return $question;
    }

    private function trimEnters(string $string) {
        return trim(str_replace("\n", ' ', $string));
    }



}