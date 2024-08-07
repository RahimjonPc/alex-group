<?php

namespace App\Services\Telegram\Commands;

use Illuminate\Support\Facades\Http;
use App\Models\User;

class StartCommand extends BaseCommand
{
    public function handle()
    {
        $message ="Здравствуйте! \nВыберите язык \n \nHi \nchoose language";

        $keyboards = json_encode([
            "inline_keyboard" => [
                [
                    [
                        "text" => "English",
                        "callback_data" => "en"
                    ],
                    [
                        "text" => "Русский язык",
                        "callback_data" => "ru"
                    ],
                ]
            ]
        ]);

        $response = Http::post($this->url . '/sendMessage',
        [
            'chat_id' => $this->chat_id,
            'text' => $message,
            'parse_mode' => 'HTML',
            'reply_markup' => $keyboards,
        ]);
    }
}
