<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentType extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['document_type'];

    public function person_documents()
    {
        return $this->hasMany(PersonDocument::class);
    }

    public function tags()
    {
        return $this->morphMany(Tag::class, 'taggable');
    }
}
