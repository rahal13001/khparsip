<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'slug'
    ];

    public function subcategories(){
        return $this->hasMany(Subcategory::class);
    }

    public function report(){
        return $this->hasMany(CategoryReport::class);
    }

    public function scopeCari($query, $term){
        $term = "%$term%";
        $query->where('nama','like', $term);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }
}
