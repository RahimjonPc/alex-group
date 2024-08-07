<?php

namespace App\Services\Telegram\Commands;

use Illuminate\Support\Facades\Http;
use App\Models\User;

class BackCommand extends BaseCommand
{
    public function handle()
    {
        
        $response = Http::post($this->url . '/sendMessage',
        [
            'chat_id' => $this->callback_query_chat_id,
            'text' => $message,
            'parse_mode' => 'HTML',
        ]);
    }
}
