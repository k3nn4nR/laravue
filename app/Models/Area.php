<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['area'];

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'area_area', 'area_id', 'areas_area_id')->withPivot('id')->withTimestamps()->wherePivot('deleted_at');
    }

    public function upper_area()
    {
        return $this->hasOneThrough(Area::class, AreaArea::class,'areas_area_id','id','id','area_id');
    }

    public function allChildrenAreas()
    {
        return $this->areas()->with('allChildrenAreas');
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

    public function positions()
    {
        return $this->belongsToMany(Position::class)->withPivot('id')->withTimestamps()->wherePivot('deleted_at');
    }
}
