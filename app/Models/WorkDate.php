<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkDate extends Model
{
    use HasFactory;
    protected $fillable = ['work_id','started_at','due_date'];

    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}
