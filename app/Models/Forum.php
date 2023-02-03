<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
