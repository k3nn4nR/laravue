<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandItem extends Model
{
    use HasFactory;
    protected $table = 'brand_item';
    protected $fillable = ['item_id','brand_id'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function code()
    {
        return $this->morphOne(Code::class, 'codeable');
    }
}
