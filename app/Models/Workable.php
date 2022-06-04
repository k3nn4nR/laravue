<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Workable extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['work_id', 'workable_type', 'workable_id'];
    
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
