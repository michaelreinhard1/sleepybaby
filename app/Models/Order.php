<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
