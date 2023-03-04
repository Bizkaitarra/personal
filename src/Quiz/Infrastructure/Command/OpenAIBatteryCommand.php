<?php

namespace App\Quiz\Infrastructure\Command;

use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OpenAIBatteryCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct('complete:data:battery');
        $this->entityManager = $entityManager;
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

        /** @var Question $question */
        foreach ($questions as $question) {
            try {
                $this->completeQuestion($question, $output);
            } catch (\Exception $exception) {
                $output->writeln('Ignoramos la excepción');
                $output->writeln($exception->getMessage());
            }
        }

        return Command::SUCCESS;

    }

    private function completeQuestion(Question $question, OutputInterface $output)
    {

        if ($question->getAnswer() != '-1') {
            $output->writeln('Ignoramos la siguiente pregunta por estar ya resuelta: ' . $question->getNumber());
            return;
        }
        /*if (in_array($question->getNumber(),
            [
                35,
                50,
                59,
                67,
                69,
                78,
                107,
                122,
                126,
                129,
                130,
                147,
                153,
                156,
                160,
                161,
                168,
                208,
                219,
                225,
                231,
                239,
                243
            ]
        )) {
            $output->writeln('Ignoramos la siguiente pregunta por que da error!: ' . $question->getNumber());
            return;
        }*/
        $client = \OpenAI::client('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');

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

        $detailedAnswer = trim($result['choices'][0]['text']);
        $output->writeln($detailedAnswer);
        $question->setDetailedAnswer($detailedAnswer);

        $prompt = sprintf('Responde con una única letra: a, b, c o d. No añadas más texto a tu respuesta: \n\n %s \n\n a)%s \n\n b)%s \n\n c)%s \n\n d)%s',
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
        $answer = strtoupper(trim(str_replace("\n", ' ', $result['choices'][0]['text'])));
        if ($answer)
            $output->writeln('Respuesta IA: ' . $answer);
        switch ($answer) {
            case 'A':
                $question->setAnswer(1);
                break;
            case 'B':
                $question->setAnswer(2);
                break;
            case 'C':
                $question->setAnswer(3);
                break;
            case 'D':
                $question->setAnswer(4);
                break;
            default:
                $question->setAnswer(-1);
        }
        $output->writeln('Guardaremos esta pregunta');
        $output->writeln('Pregunta: ' . $question->getQuestion());
        $output->writeln('Detailed: ' . $question->getDetailedAnswer());
        $output->writeln('Respuesta: ' . $question->getAnswer());

        $this->entityManager->persist($question);
        $this->entityManager->flush();
    }
}