<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Statusable extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['status_id', 'statusable_type', 'statusable_id'];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
