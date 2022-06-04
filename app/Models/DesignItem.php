<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignItem extends Model
{
    use HasFactory;
    protected $table = 'design_item';
    protected $fillable = ['item_id','design_id'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function design()
    {
        return $this->belongsTo(Design::class);
    }

    public function code()
    {
        return $this->morphOne(Code::class, 'codeable');
    }
}
