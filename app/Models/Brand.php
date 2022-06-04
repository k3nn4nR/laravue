<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = ['brand'];

    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    public function status()
    {
        return $this->morphToMany(Status::class, 'statusable')->withTimestamps();
    }
}
