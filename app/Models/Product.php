<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'product_image',
    ];

    public function getProductImageUrlAttribute(){
        return $this->product_image ? Storage::url($this->product_image) : null;
    }
}
