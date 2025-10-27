<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMessage;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use TelegramBot\Api\BotApi;

class GroupMessageController extends Controller
{
    public function store(Request $request, Group $group)
    {
        $data = $request->validate([
            'content' => 'nullable|string|max:255',
        ]);

        $message = $group->groupMessages()->create($data);

        TelegramService::sendMessage(new BotApi(env('TELEGRAM_BOT_TOKEN')), $group, $message);

        return redirect()->route('groups.index');
    }

    public function create(Group $group)
    {
        return view('group-messages.create', compact('group'));
    }
}
