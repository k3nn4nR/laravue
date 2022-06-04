<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['item'];

    public function code()
    {
        return $this->morphOne(Code::class, 'codeable');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }

    public function designs()
    {
        return $this->belongsToMany(Design::class);
    }
}
