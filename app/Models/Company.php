<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';
    protected $fillable = ['person_id','company','acronym'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function provider()
    {
        return $this->hasOne(Provider::class);
    }

    public function contracts()
    {
        return $this->hasManyThrough(Contract::class, Person::class,'id','person_id','person_id','id');
    }

    public function id_number()
    {
        return $this->hasOneThrough(PersonDocument::class, Person::class,'id','person_id','person_id','id',);
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
