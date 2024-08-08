<?php

namespace App\Services\Telegram\Commands;

use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class MainCommand extends BaseCommand
{
    public function handle()
    {
        $message = __('Главное меню');

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
