<?php

namespace App\Quiz\Infrastructure\Command;

use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OpenAICommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct('complete:data');
        $this->entityManager = $entityManager;
    }


    protected static $defaultDescription = 'Adds openAI data to responses';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = \OpenAI::client('key');

        $queryBuilder = $this->entityManager->createQueryBuilder();
        $query = $queryBuilder
            ->select('q')
            ->from(Question::class, 'q')
            ->join('q.exam', 'e')
            ->andWhere('e.application = :application')
            ->andWhere('e.state = 1')
            ->andWhere('q.state = 1')
            ->setParameter('application', 1)
            ->getQuery();

        $questions = $query->getResult();

        /** @var Question $question */
        foreach ($questions as $question) {
            if (!empty($question->getDetailedAnswer())) {
                continue;
            }

            $prompt = sprintf('En la siguiente pregunta dime cual es la respuesta correcta y el motivo: \n\n %s \n\n a)%s \n\n b)%s \n\n c)%s \n\n d)%s',
                $question->getQuestion(),
                $question->getA(),
                $question->getB(),
                $question->getC(),
                $question->getD()
            );

            $output->writeln($prompt);

            $result = $client->completions()->create([
                'model' => 'text-davinci-003',
                'prompt' => $prompt,
                "max_tokens" => 3000
            ]);

            $detailedAnswer = $result['choices'][0]['text'];
            $output->writeln($detailedAnswer);
            $question->setDetailedAnswer($detailedAnswer);
            $this->entityManager->persist($question);
            $this->entityManager->flush();
        }

        return Command::SUCCESS;

    }
}