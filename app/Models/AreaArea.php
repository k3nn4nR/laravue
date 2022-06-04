<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaArea extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'area_area';
    protected $fillable = ['area_id','areas_area_id'];
}
