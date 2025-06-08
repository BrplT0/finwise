<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'amount', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
