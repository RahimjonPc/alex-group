<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;

    const NEW_CODE = 0;
    const USED = 1;

    protected $fillable = ['user_id', 'code', 'status'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
