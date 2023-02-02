<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'content'
    ];
    
    protected $with = [
        'user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
