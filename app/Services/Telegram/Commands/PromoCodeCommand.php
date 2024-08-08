<?php

namespace App\Services\Telegram\Commands;

use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\PromoCode;
use Illuminate\Support\Facades\Log;

class PromoCodeCommand extends BaseCommand
{
    public function handle()
    {
        if($this->data == 'promo') {
            $message = __('Отправьте промокод');

        } else {
            $promocode = PromoCode::where('code', $this->data)->first();

            if(!$promocode) {
                $message = __('Неверный промокод');
            } elseif($promocode->status == PromoCode::USED) {

                $message = __('Промокод уже использован');
            } else {
                $promocode->user_id = $this->user->id;
                $promocode->status = PromoCode::USED;
                $promocode->save();

                $message = __('Промокод сохранен');
            }
        }

        $response = Http::post($this->url . '/sendMessage',
        [
            'chat_id' => $this->chat_id,
            'text' => $message,
            'parse_mode' => 'HTML',
        ]);
    }
}
