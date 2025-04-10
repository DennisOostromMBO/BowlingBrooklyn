<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $table = 'scores';

    protected $fillable = [
        'reservationid',
        'points',
        'round',
        'isactive',
        'note',
        'datecreated',
        'datemodified',
    ];

    public $timestamps = false;
}
