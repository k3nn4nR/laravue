<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'statuses';
    protected $fillable = ['status'];

    public function people()
    {
        return $this->morphedByMany(Person::class, 'statusable');
    }

    public function works()
    {
        return $this->morphedByMany(Work::class, 'statusable');
    }
}