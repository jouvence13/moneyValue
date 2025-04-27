<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pair extends Model
{
    use HasFactory;

    protected $fillable = ['devise_from_id', 'devise_to_id', 'rate', 'conversion_count'];

    public function deviseFrom()
    {
        return $this->belongsTo(Currency::class, 'devise_from_id');
    }

    public function deviseTo()
    {
        return $this->belongsTo(Currency::class, 'devise_to_id');
    }
}
