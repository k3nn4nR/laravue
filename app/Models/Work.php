<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;
    protected $fillable = ['work'];

    public function people()
    {
        return $this->morphedByMany(Person::class, 'workable');
    }

    public function status()
    {
        return $this->morphToMany(Status::class, 'statusable')->withTimestamps();
    }

    public function predecessors()
    {
        return $this->hasOneThrough(Work::class,WorkWork::class,'works_work_id','id','id','work_id');
    }

    public function successors()
    {
        return $this->hasManyThrough(Work::class,WorkWork::class,'work_id','id','id','works_work_id');
    }

    public function dates()
    {
        return $this->hasOne(WorkDate::class);
    }

    public function code()
    {
        return $this->morphOne(Code::class, 'codeable');
    }
}