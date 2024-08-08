<?php

namespace App\Services\Telegram\Commands;

use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;
use TCG\Voyager\Facades\Voyager;

class ContactSectionCommand extends BaseCommand
{
    public function handle()
    {
        // getting contact info, admin can not delete contact object which has id = 1
        $contact = Contact::where('id', 1)->first();

        $message = view('contact', compact('contact'))->render();

        $keyboards = [
            "inline_keyboard" => [
                [
                    [
                        "text" => __('Главное меню'),
                        "callback_data" => 'main',
                    ],
                ]
            ]
        ];

        $response = Http::post($this->url . '/sendMessage',
        [
            'chat_id' => $this->chat_id,
            'text' => $message,
            'parse_mode' => 'HTML',
            'reply_markup' => $keyboards,
        ]);
    }
}
