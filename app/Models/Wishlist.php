<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'articles',
        'code',
        'deleted',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     self::creating(function ($model) {
    //         $model->user_id = auth()->id();
    //     });

    //     self::deleting(function ($model) {
    //         $model->deleted = true;
    //         $model->save();
    //     });

    //     self::addGlobalScope(function (Builder $builder) {
    //         $builder->where('user_id', auth()->id());
    //     });
    // }
}
