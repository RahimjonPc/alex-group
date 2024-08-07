<?php

namespace App\Services\Telegram\Commands;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class BaseCommand
{
    public $user;
    public $data;
    public $url;

    public function __construct($data, $user)
    {
        $this->user = User::where('telegram_id', $user)->first();
        $this->data = $data;
        $this->url = config('services.telegram.telegram_url').config('services.telegram.token');
        $this->message_chat_id = request()->message['chat']['id'] ?? '';
        $this->chat_id = request()->callback_query['message']['chat']['id'] ?? request()->message['chat']['id'];
    }

    public function handle()
    {
        //
    }
}
