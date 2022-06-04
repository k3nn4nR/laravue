<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Code extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['code'];
    protected $guarded = ['codeable_type', 'codeable_id'];

    public function codeable()
    {
        return $this->morphTo();
    }

    public function status()
    {
        return $this->morphToMany(Status::class, 'statusable')->withTimestamps();
    }
}
