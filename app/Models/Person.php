<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons'; // Explicitly define the table name

    protected $fillable = [
        'first_name',
        'infix',
        'last_name',
        'date_of_birth',
        'is_active',
        'note',
    ];

    // Accessor for full name
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->infix} {$this->last_name}");
    }
}