<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkWork extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'work_work';
    protected $fillable = ['work_id','works_work_id'];
 
    public function post()
    {
        return $this->belongsTo(Work::class);
    }
}
