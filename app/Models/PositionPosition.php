<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PositionPosition extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'position_position';
    protected $fillable = ['position_id','positions_position_id'];
}
