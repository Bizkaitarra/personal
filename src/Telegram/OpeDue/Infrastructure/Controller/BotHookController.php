<?php


namespace App\Telegram\OpeDue\Infrastructure\Controller;


use App\Telegram\OpeDue\Application\BotOptionChooser;
use Borsaco\TelegramBotApiBundle\Service\Bot;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

class BotHookController extends AbstractController
{

    private BotOptionChooser $botOptionChooser;

    public function __construct(BotOptionChooser $botOptionChooser)
    {
        $this->botOptionChooser = $botOptionChooser;
    }


    public function __invoke(Bot $bot)
    {
        $firstBot = $bot->getBot('opedue2_bot');

        $updateArray = $firstBot->getUpdates([0,1]);

        if (count($updateArray)=== 0) {
            return new JsonResponse([]);
        }

        if (!$updateArray[0] instanceof Update) {
            return new JsonResponse([]);
        }
        $update = $updateArray[0];
        $updateId = $update->updateId;
        $firstBot->getUpdates([$updateId, 1]);
        $update->getMessage()->from->get('id');
        $responses = $this->botOptionChooser->__invoke(
            $update->getMessage()->from->get('id'),
            $update->getMessage()->from->get('is_bot'),
            $update->getMessage()->from->get('first_name'),
            $update->getMessage()->from->get('username'),
            $update->getMessage()->text,
            $update->getMessage()->from->get('language_code'),
        );


        foreach ($responses as $response) {
            $firstBot->sendMessage(
                [
                    'chat_id' => $update->getMessage()->chat->get('id'),
                    'text' => $response
                ]
            );
        }

        return new JsonResponse([]);

    }
}