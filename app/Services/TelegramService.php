<?php

namespace App\Services;

use App\Models\Group;
use App\Models\GroupMessage;
use App\Models\IndividualMessage;
use App\Models\Student;
use TelegramBot\Api\BotApi;

class TelegramService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function sendMessage(BotApi $tg, Student|Group $item, GroupMessage|IndividualMessage $message): void
    {
        $subscriptions = $item->subscriptions;
        
        foreach ($subscriptions as $subscription) {
            $tg->sendMessage($subscription->chat->telegram_id, $message->tg_message);
        }
    }
}
