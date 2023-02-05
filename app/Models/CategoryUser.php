<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryUser extends Pivot
{
    use HasFactory;

    protected $table = 'category_user';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user(){
        return $this->hasMany(User::class);
    }

    public function category(){
        return $this->hasMany(Category::class);
    }
    
}
