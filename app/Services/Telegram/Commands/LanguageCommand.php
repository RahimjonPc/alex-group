<?php

namespace App\Services\Telegram\Commands;

use Illuminate\Support\Facades\Http;
use App\Models\User;

class LanguageCommand extends BaseCommand
{
    public function handle()
    {
        // updating user language
        $this->user->language = $this->data;
        $this->user->save();

        // set locale
        app()->setLocale($this->data);

        $message = __('Здравствуйте напишите имя');

        $keyboards = json_encode([
            "inline_keyboard" => [
                [
                    [
                        "text" => __('Назад к выбору языка'),
                        "callback_data" => "back start"
                    ],
                ],
            ],
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
