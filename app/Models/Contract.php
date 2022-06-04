<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['person_id', 'start_at', 'due_date', 'reason'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function incomes()
    {
        return $this->hasMany(ContractIncome::class);
    }

    public function positions()
    {
        return $this->hasMany(ContractPosition::class);
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
