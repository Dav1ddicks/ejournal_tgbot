<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TelegramBot\Api\BotApi;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function __invoke(Request $request)
    {
        $telegram = new BotApi(env('TELEGRAM_BOT_TOKEN'));
        $update = $request->all();
        $message = $update['message'] ?? null;

        if ($message) 
        {
            $text   = $message["text"] ?? null;
            $chatId = $message['chat']['id'];
            $responcemessage = "";
            if($text=="/start")
            {
                $responcemessage = "Привіт, це стартове повідомлення";

            } else {
                $responcemessage = "Не знаю такої команди";
            }
            $telegram->sendMessage($chatId, $responcemessage);
        }
    }

}
