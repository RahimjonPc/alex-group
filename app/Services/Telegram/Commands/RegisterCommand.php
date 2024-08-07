<?php

namespace App\Services\Telegram\Commands;

use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RegisterCommand extends BaseCommand
{
    public function handle()
    {
        if($this->data == 'change' && $this->user->name != null) {
            $this->user->name = null;
            $this->user->save();
            $message = __('Напишите имя еще раз');
        } elseif ($this->data == 'right' && $this->user->phone == null) {
            $message = __('Отправить контакт');

            $keyboards = [
                "keyboard" => [
                    [
                        [
                            "text" => __('Отправить контакт'),
                            "request_contact" => true,
                        ],
                    ]
                ],
                "one_time_keyboard" => true,
            ];
        } else {
            $this->user->name = $this->data;
            $this->user->save();

            $message = $this->user->name . ', ' . __('все верно');

            $keyboards = json_encode([
                "inline_keyboard" => [
                    [
                        [
                            "text" => __('Верно'),
                            "callback_data" => "right"
                        ],
                        [
                            "text" => __('Изменить'),
                            "callback_data" => "change"
                        ],
                    ],
                ],
            ]);
        }

        $response = Http::post($this->url . '/sendMessage',
        [
            'chat_id' => $this->chat_id,
            'text' => $message,
            'parse_mode' => 'HTML',
            'reply_markup' => $keyboards ?? '',
        ]);
    }
}
