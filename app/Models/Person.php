<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $table = 'people';
    protected $fillable = ['first_surname','second_surname','name'];

    public function person_documents()
    {
        return $this->hasMany(PersonDocument::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function provider()
    {
        return $this->hasOneThrough(Provider::class, Company::class);
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
