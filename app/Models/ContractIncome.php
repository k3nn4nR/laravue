<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractIncome extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'contract_income';
    protected $fillable = ['contract_id', 'wage', 'payment'];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
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
