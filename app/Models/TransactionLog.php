<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount_sent',
        'previous_amount',
        'actual_amount',
        'payee_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
