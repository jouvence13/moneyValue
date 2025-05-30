<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = ['code'];

    public function pairsFrom()
    {
        return $this->hasMany(Pair::class, 'devise_from_code', 'code');
    }

    public function pairsTo()
    {
        return $this->hasMany(Pair::class, 'devise_to_code', 'code');
    }
}
