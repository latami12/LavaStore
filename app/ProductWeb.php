<?php

use Illuminate\Database\Eloquent\Model;

class ProductWeb extends Model
{
    protected $fillable = [
        'name', 'description', 'category_id', 'price', 'weight', 'image'
    ];
}