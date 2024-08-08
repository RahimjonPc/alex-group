<?php

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;

class Telegram
{
    public function textHandler($data, $user_id) {
        $user = User::where('telegram_id', $user_id)->first();

        $text = explode(' ', $data);
        $command = $text[0];

        if(Str::startsWith($command, '/')) {
            $baseName = Str::ucfirst(Str::replace(array('/', '@' . config('services.telegram.bot_username')), '', $command));
            $className = 'App\\Services\\Telegram\\Commands\\' . $baseName . 'Command';
        } elseif ($user->registered == User::NOT_REGISTERED) {
            $className = 'App\\Services\\Telegram\\Commands\\RegisterCommand';
        } elseif ($user->registered == User::REGISTERED) {
            $className = 'App\\Services\\Telegram\\Commands\\PromoCodeCommand';
        }

        $class = new $className($data, $user_id);
        $class->handle();
    }

    public function callBackHandler($data, $user) {

        if($data == 'ru' || $data == 'en') {
            $className = 'App\\Services\\Telegram\\Commands\\LanguageCommand';
        } elseif ($data == 'change' || $data == 'right') {
            $className = 'App\\Services\\Telegram\\Commands\\RegisterCommand';
        } elseif ($data == 'contacts') {
            $className = 'App\\Services\\Telegram\\Commands\\ContactSectionCommand';
        } elseif ($data == 'main') {
            $className = 'App\\Services\\Telegram\\Commands\\MainCommand';
        } elseif ($data == 'promo') {
            $className = 'App\\Services\\Telegram\\Commands\\PromoCodeCommand';
        }

        $class = new $className($data, $user);
        $class->handle();
    }

    public function BackHandler($data, $user) {
        if(Str::endsWith($data, 'start')) {
            $className = 'App\\Services\\Telegram\\Commands\\StartCommand';
        }

        $class = new $className($data, $user);
        $class->handle();
    }

    public function contactHandler($data, $user) {
        $className = 'App\\Services\\Telegram\\Commands\\ContactCommand';

        $class = new $className($data, $user);
        $class->handle();
    }
}
