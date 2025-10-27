<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Group;
use App\Models\Student;
use App\Models\Subscription;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use TelegramBot\Api\BotApi;
use Illuminate\Support\Facades\Log;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

use function Laravel\Prompts\select;

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
            if ($text == "/subscribe")
            {
                $responcemessage = "Вітаю, оберіть клас!";
                $grades = Group::distinct()->pluck('grade')->sort()->toArray();
                $buttons =  [];
                $row = [];
                for ($i = 0; $i < count($grades); $i++) {
                    $row[] = ['text' => $grades[$i], 'callback_data' => json_encode(['type' => 'select_grade', 'grade' => $grades[$i]])];

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
            } elseif ($text == "/start") {
                $telegram->sendMessage($chatId, "Вітаю. Ви можете підписатись на всі оновлення, які стосуються вашої дитини, або класу, де вона вчиться. Оберіть в Меню пункт Підписатись і слідкуйте за оновленнями!");
            } else {
                $responcemessage = "Не знаю такої команди";
                $telegram->sendMessage($chatId, $responcemessage);
            }
        } elseif ($callbackQuery) {
            $chat = Chat::firstOrCreate(['telegram_id' => $callbackQuery['message']['chat']['id']]);
            $messageId = $callbackQuery['message']['message_id'];
            $data = json_decode($callbackQuery['data']);

            if ($data->type == 'select_grade') {
                $classes = Group::where('grade',$data->grade)->get();
                $buttons = [];
                foreach ($classes as $class) {
                    $buttons[] = ['text' => $class->sign, 'callback_data' => json_encode(['type' => 'select_class', 'class_id' => $class->id])];
                }
                $keyboard = new InlineKeyboardMarkup([$buttons]);
                $telegram->editMessageText($chat->telegram_id, $messageId, "Оберіть клас", null, false, $keyboard, null);
            }
            
            if ($data->type == 'select_class') {
                $class = Group::find($data->class_id);
                $buttons = [];
                foreach ($class->students as $student) {
                    $buttons[] = [['text' => $student->full_name_shortened, 'callback_data' => json_encode(['type' => 'select_student', 'student_id' => $student->id])]];
                }
                $keyboard = new InlineKeyboardMarkup($buttons);
                $telegram->editMessageText($chat->telegram_id, $messageId, "Оберіть учня", null, false, $keyboard, null);
            }

            if ($data->type == 'select_student') {
                $student = Student::find($data->student_id);
                if ($student) {
                    try {
                        $student->subscriptions()->create(['chat_id' => $chat->id]);
                        $telegram->editMessageText($chat->telegram_id, $messageId, "Вітаю. Ви підписались на " . $student->full_name);
                    } catch (QueryException $e) {
                        if ($e->getCode() == 23000) { // Код помилки для унікальності
                            $telegram->editMessageText($chat->telegram_id, $messageId, "Ви вже підписані на " . $student->full_name);
                            
                        }
                    }
                }
            }
            // $telegram->sendMessage($chatId, 'OK, ' . $callbackQuery['data']);
        }
    }

}
