<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'business_id', 'price', 'discount', 'description'
    ];

    /**
     * Also expand
     */
    protected $with = ['images'];

    /**
     * Get associated Business
     * @return \App\Models\Business
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Get the images
     */
    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }
}