<?php

namespace App\Models;

use App\Relations\HasPublishedThreads;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Forum extends Model
{
    use HasFactory, HasPublishedThreads;

    protected $fillable = [
        'name',
        'description'
    ];

    public function isPublished(): bool
    {
        return (bool) $this->published_at;
    }

    public function scopePublished(Builder $query): Builder
    {
        $forumAuthor = Auth::guard('sanctum')->user();

        return $query->whereNotNull('published_at')
            ->when($forumAuthor, function($q) use ($forumAuthor) {
                $q->orWhere('user_id', $forumAuthor->id);
            });
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'forum_user');
    }
}
