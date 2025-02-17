<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loans extends Model
{
    protected $fillable = [
        'book_id',
        'user_id',
        'loans_date',
        'return_date',
        'status'
    ];
}
