<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pair extends Model
{
    use HasFactory;

    protected $fillable = ['devise_from_code', 'devise_to_code', 'rate', 'conversion_count'];

    public function deviseFrom()
    {
        return $this->belongsTo(Currency::class, 'devise_from_code', 'code');
    }

    public function deviseTo()
    {
        return $this->belongsTo(Currency::class, 'devise_to_code', 'code');
    }
}
