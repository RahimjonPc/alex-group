<?php

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;
use App\Services\Telegram\Commands\BackCommand;

class Telegram
{
    public function textHandler($data, $user_id)
    {
        $user = User::where('telegram_id', $user_id)->first();

        $text = explode(' ', $data);
        $command = $text[0];

        if(Str::startsWith($command, '/')) {
            $baseName = Str::ucfirst(Str::replace(array('/', '@' . config('services.telegram.bot_username')), '', $command));
            $className = 'App\\Services\\Telegram\\Commands\\' . $baseName . 'Command';
        }

        $class = new $className($data, $user_id);
        $class->handle();
    }

    public function callBackHandler($data, $user)
    {
        if($data == 'ru' || $data == 'en') {
            $className = 'App\\Services\\Telegram\\Commands\\LanguageCommand';
        } elseif ($data == 0 || $data == 1) {
            $className = 'App\\Services\\Telegram\\Commands\\RegisterCommand';
        } elseif ($data == '/information') {
            $className = 'App\\Services\\Telegram\\Commands\\InformationCommand';
        } elseif ($data == '/installment') {
            $className = 'App\\Services\\Telegram\\Commands\\InstallmentCommand';
        } elseif ($data == '/address') {
            $className = 'App\\Services\\Telegram\\Commands\\AddressCommand';
        } elseif ($data == '/map') {
            $className = 'App\\Services\\Telegram\\Commands\\MapCommand';
        } elseif ($data == '/back') {
            $className = 'App\\Services\\Telegram\\Commands\\BackCommand';
        }
        $class = new $className($data, $user);
        $class->handle();
    }

    public function BackHandler($data, $user)
    {
        if(Str::endsWith($data, 'start')) {
            $className = 'App\\Services\\Telegram\\Commands\\StartCommand';
        }

        $class = new $className($data, $user);
        $class->handle();
    }
}
