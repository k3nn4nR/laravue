<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    protected $fillable = ['company_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function person()
    {
        return $this->hasOneThrough(Person::class, Company::class,'person_id','id','company_id','person_id');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function status()
    {
        return $this->morphToMany(Status::class, 'statusable')->withTimestamps();
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
