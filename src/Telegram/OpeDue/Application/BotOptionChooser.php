<?php


namespace App\Telegram\OpeDue\Application;


use App\Entity\OpeDueChatStatus;
use App\Entity\Question;
use App\Exam\Domain\ApplicationId;
use App\Exam\Domain\Exceptions\ExamsForApplicationIdNotFound;
use App\Exam\Domain\Exceptions\QuestionsForAplicationIdNotFound;
use App\OpeDue\Application\RandomQuestionFinder;
use App\Telegram\OpeDue\Domain\Repository\OpeDueStatusRepository;
use App\Telegram\OpeDue\Domain\Repository\TelegramUserRepository;

class BotOptionChooser
{

    private TelegramUserRepository $telegramUserRepository;
    private RandomQuestionFinder $randomQuestionFinder;
    private OpeDueStatusRepository $opeDueStatusRepository;

    public function __construct(
        TelegramUserRepository $telegramUserRepository,
        RandomQuestionFinder $randomQuestionFinder,
        OpeDueStatusRepository $opeDueStatusRepository
    )
    {
        $this->telegramUserRepository = $telegramUserRepository;
        $this->randomQuestionFinder = $randomQuestionFinder;
        $this->opeDueStatusRepository = $opeDueStatusRepository;
    }


    public function __invoke(
        int $userId,
        bool $isBot,
        ?string $firstName,
        ?string $username,
        string $text,
        string $languageCode = 'es'
    ):array
    {
        $telegramUser = $this->telegramUserRepository->getTelegramUser(
            $userId,
            $isBot,
            $firstName,
            $username,
            $languageCode
        );

        $opeDueChatStatus = $telegramUser->getChatStatus();

        if ($opeDueChatStatus === null) {
            $opeDueChatStatus = new OpeDueChatStatus($telegramUser);
            return $this->getQuestion($opeDueChatStatus);
        }

        $currentQuestion = $opeDueChatStatus->getCurrentQuestion();

        if ($currentQuestion === null) {
            //It should not happen
            return $this->getQuestion($opeDueChatStatus);
        }

        if ($this->isAnswer($text)) {

            $response = '¡Respuesta correcta!';
            if ($currentQuestion->isCorrectAnswer($text)) {

                $opeDueChatStatus->addCorrectQuestion($currentQuestion);
            } else {
                $response = '¡La resepuesta NO es correcta! La respuesta correcta es ' . $currentQuestion->getTextAnswer();
                $opeDueChatStatus->addFailQuestion($currentQuestion);

            }
            return [$response,$this->getQuestion($opeDueChatStatus)];
        }

        return ['Por favor, responde una opción correcta'];

    }

    private function getQuestion(OpeDueChatStatus $opeDueChatStatus): array
    {
        try {
            $question = $this->randomQuestionFinder->__invoke(new ApplicationId(1));

        } catch (ExamsForApplicationIdNotFound|QuestionsForAplicationIdNotFound $exception) {
            return 'Esto es dificil de decir para mi...  no he conseguido encontrar ninguna pregunta.';
        }

        $opeDueChatStatus->setCurrentQuestion($question);
        $this->opeDueStatusRepository->save($opeDueChatStatus);

        return [sprintf(
          '%s - %s : %s',
          $question->getExam()->getName(), $question->getNumber(), $question->getQuestion()
        )];


    }

    private function isAnswer(string $text):bool
    {
        return in_array(strtoupper($text), ['A', 'B', 'C', 'D']);
    }

    private function isCorrectAnswer(string $text, Question $currentQuestion)
    {

    }


}