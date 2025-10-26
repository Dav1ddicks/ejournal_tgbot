<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use TelegramBot\Api\BotApi;
use Illuminate\Support\Facades\Log;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class TelegramController extends Controller
{
    public function __invoke(Request $request)
    {
        $telegram = new BotApi(env('TELEGRAM_BOT_TOKEN'));
        $update = $request->all();
        $message = $update['message'] ?? null;
        $callbackQuery = $update['callback_query'] ?? null;

        if ($message) 
        {
            $text   = $message["text"] ?? null;
            $chatId = $message['chat']['id'];
            $responcemessage = "";
            if($text=="/start")
            {
                $responcemessage = "Вітаю, оберіть клас!";
                $grades = Group::distinct()->pluck('grade')->sort()->toArray();
                $buttons =  [];
                $row = [];
                for ($i = 0; $i < count($grades); $i++) {
                    $row[] = ['text' => $grades[$i], 'callback_data' => 'select_class_' . $grades[$i]];

                    if ($i % 3 == 2) {
                        $buttons[] = $row;
                        $row = [];
                    }
                }

                if (count($row) > 0) {
                    $buttons[] = $row;
                }

                $keyboard = new InlineKeyboardMarkup($buttons);
                $telegram->sendMessage($chatId, $responcemessage, null, false, null, $keyboard, null, false);
            } else {
                $responcemessage = "Не знаю такої команди";
                $telegram->sendMessage($chatId, $responcemessage);
            }
        } elseif ($callbackQuery) {
            $chatId = $callbackQuery['message']['chat']['id'];
            $telegram->sendMessage($chatId, 'OK, ' . $callbackQuery['data']);
        }
    }

}
