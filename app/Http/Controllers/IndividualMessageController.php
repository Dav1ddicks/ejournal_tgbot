<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use TelegramBot\Api\BotApi;

class IndividualMessageController extends Controller
{
    public function store(Request $request, Group $group, Student $student)
    {
        $data = $request->validate([
            'content' => 'nullable|string|max:255',
        ]);

        $message = $student->individualMessages()->create($data);

        TelegramService::sendMessage(new BotApi(env('TELEGRAM_BOT_TOKEN')), $student, $message);

        return redirect()->route('groups.show', compact('group'));
    }

    public function create(Group $group, Student $student)
    {
        return view('individual-messages.create', compact('student'));
    }
}
