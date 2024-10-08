<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class)->withPivot('achievement_date');
    }

}
