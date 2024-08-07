<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Services\Telegram\Telegram;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HookController extends Controller
{
    public function setHook()
    {
        $response = Http::post(config('services.telegram.telegram_url').config('services.telegram.token').'/setWebhook',
        [
            'url' => config('services.telegram.hook_url'),
        ]);

        return 'success';
    }

    public function deleteHook()
    {
        $response = Http::post(config('services.telegram.telegram_url').config('services.telegram.token').'/deleteWebhook');

        return 'deleted';
    }

    public function hook()
    {

        if(request()->has(['message.text'])) {
            $data = request()->message['text'];
            $from = request()->message['from'];
            $user_id = $from['id'];
            $method = 'textHandler';
        }

        if(request()->has(['callback_query.data'])) {
            if(Str::startsWith(request()->callback_query['data'], 'back')) {
                $data =  request()->callback_query['data'];
                $from = request()->callback_query['from'];
                $user_id = $from['id'];
                $method = 'BackHandler';
            } else {
                $data =  request()->callback_query['data'];
                $from = request()->callback_query['from'];
                $user_id = $from['id'];
                $method = 'callBackHandler';
            }
        }

        if(request()->has(['message.contact'])) {
            $data = request()->message['contact']['phone_number'];
            $from = request()->message['from'];
            $user_id = $from['id'];
            $method = 'contactHandler';
        }

        // create user in app
        $exist_user = User::where('telegram_id', $from['id'])->first();

        if(!$exist_user) {
            $user = User::create([
                'telegram_id' => $from['id'],
                'first_name' => $from['first_name'],
                'username' => $from['username'] ?? '',
                'language' => $from['language_code'],
                'email' => rand(111, 999) . '@gmail.com',
                'password' => Hash::make(rand(111111, 999999)),
            ]);
        }

        $telegram = new Telegram();
        $telegram->$method($data, $user_id);

    }
}
