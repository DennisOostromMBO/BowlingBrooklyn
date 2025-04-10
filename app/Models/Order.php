<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customerid',
        'totalamount',
        'status',
        'ispaid',
        'note',
        'datecreated',
        'datemodified',
        'product' // Added product to allow mass assignment
    ];
}
