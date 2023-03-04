<?php

namespace App\Quiz\Infrastructure\Command;

use App\Entity\Question;
use App\Quiz\Application\ExamGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BatteryAnswersCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private ExamGenerator $examGenerator;

    public function __construct(
        EntityManagerInterface $entityManager,
        ExamGenerator $examGenerator
    )
    {
        parent::__construct('battery:pdf');
        $this->entityManager = $entityManager;
        $this->examGenerator = $examGenerator;
    }


    protected static $defaultDescription = 'Adds openAI data to responses';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $query = $queryBuilder
            ->select('q')
            ->from(Question::class, 'q')
            ->join('q.exam', 'e')
            ->andWhere('e.application = :application')
            ->andWhere('e.id = 127')
            ->setParameter('application', 1)
            ->getQuery();

        $questions = $query->getResult();

        $html = $this->examGenerator->__invoke($questions, true);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents(__DIR__ . '/battery.pdf', $output);
        file_put_contents(__DIR__ . '/battery.html', $html);


        return Command::SUCCESS;

    }

}