<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description'
    ];

    public function isPublished(): bool
    {
        return (bool) $this->published_at;
    }

    public function scopePublished(Builder $query, ?User $threadAuthor): Builder
    {
        return $query->whereNotNull('published_at')
            ->when($threadAuthor, function($q) use ($threadAuthor) {
                $q->orWhere('user_id', $threadAuthor->id);
            });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'thread_tag');
    }
}
