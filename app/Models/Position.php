<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['position'];

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'position_position', 'position_id', 'positions_position_id')->withPivot('id')->withTimestamps()->wherePivot('deleted_at');
    }

    public function upper_position()
    {
        return $this->hasOneThrough(Position::class, PositionPosition::class,'positions_position_id','id','id','position_id');
    }

    public function allChildrenPositions()
    {
        return $this->positions()->with('allChildrenPositions');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function tags()
    {
        return $this->morphMany(Tag::class, 'taggable');
    }
}
