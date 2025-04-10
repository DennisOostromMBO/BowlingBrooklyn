<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'persons'; // Explicitly define the table name

    protected $fillable = [
        'first_name',
        'infix',
        'last_name',
        'date_of_birth',
        'is_active',
        'note',
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'persons_id');
    }
}
