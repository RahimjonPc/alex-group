<?php

namespace App\Services\Telegram\Commands;

use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ContactCommand extends BaseCommand
{
    public function handle()
    {
        $this->user->phone = $this->data;
        $this->user->registered = User::REGISTERED;
        $this->user->save();

        $message = __('Выберите раздел');

        $keyboards = json_encode([
            "inline_keyboard" => [
                [
                    [
                        "text" => __('Ввести промокод'),
                        "callback_data" => "promo"
                    ],
                    [
                        "text" => __('Акции'),
                        "callback_data" => "sales"
                    ],
                    [
                        "text" => __('Настройки'),
                        "callback_data" => "settings"
                    ],
                    [
                        "text" => __('Контакты'),
                        "callback_data" => "contacts"
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
