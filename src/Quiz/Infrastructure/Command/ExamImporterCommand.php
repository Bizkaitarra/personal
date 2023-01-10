<?php

namespace App\Quiz\Infrastructure\Command;

use App\Entity\Exam;
use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExamImporterCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct('import:exam');
        $this->entityManager = $entityManager;
    }


    protected static $defaultDescription = 'Imports exams in data folder';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $exam = new Exam();
        $exam->setState(true);
        $exam->setName('OSAKIDETZA');
        $exam->setType('OSAKIDETZA');
        $exam->setApplication(1);
        $exam->setDescription('Ope 2021 realizada en 2022');
        $exam->setOrdering(1000);
        $exam->setUrl('');
        $this->entityManager->persist($exam);


        $inputQuestions = file_get_contents(__DIR__ . '/../data/ope2022-preguntas.txt');
        $inputQuestions = explode("\n", $inputQuestions);
        $groupedInputQuestions = array_chunk($inputQuestions, 5);
        $answers = file_get_contents(__DIR__ . '/../data/ope2022-respuestas.txt');
        $answers = explode("\n", $answers);
        $currentAnswerNumber = 1;
        foreach ($groupedInputQuestions as $groupedInputQuestion) {
            $question = new Question();
            $questionText = $groupedInputQuestion[0];
            $questionNumber = intval(explode(' ', $questionText)[0]);
            if ($questionNumber !== $currentAnswerNumber) {
                $output->writeln(sprintf('%s question number should be %s', $questionNumber, $currentAnswerNumber));
                return Command::FAILURE;
            }
            $question->setQuestion($groupedInputQuestion[0]);
            $question->setOrdering($questionNumber);
            $question->setNumber($questionNumber);
            $question->setExam($exam);
            $question->setA(substr($groupedInputQuestion[1], strlen($questionNumber)));
            $question->setB(substr($groupedInputQuestion[2], strlen($questionNumber)));
            $question->setC(substr($groupedInputQuestion[3], strlen($questionNumber)));
            $question->setD(substr($groupedInputQuestion[4], strlen($questionNumber)));
            $question->setDetailedAnswer('');
            $answer = substr($answers[$currentAnswerNumber-1], 4);
            $answer = match ($answer) {
                'A' => 1,
                'B' => 2,
                'C' => 3,
                'D' => 4,
                default => -1,
            };
            $question->setAnswer($answer);
            $question->setState($answer !== -1);
            $currentAnswerNumber ++;

            $this->entityManager->persist($question);

        }
        $this->entityManager->flush();
        $output->writeln('All ok');
        return Command::SUCCESS;

    }
}