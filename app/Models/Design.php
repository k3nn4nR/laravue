<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;
    protected $fillable = ['design'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    
    public function codes()
    {
        return $this->morphMany(Code::class, 'codeable');
    }

    public function status()
    {
        return $this->morphToMany(Status::class, 'statusable')->withTimestamps();
    }
}
