<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonDocument extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['person_id','document_type_id','id_number'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class);
    }
    public function company()
    {
        return $this->hasOneThrough(Company::class, Person::class, 'id', 'person_id', 'person_id', 'id');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function tags()
    {
        return $this->morphMany(Tag::class, 'taggable');
    }
}
