<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Subcategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;



    protected $guarded = [
        'id', 'created_at', 'deleted_at'
    ];

    public function categories(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function scopeCari($query, $term){
        $term = "%$term%";
        $query->whereHas('categories', function($query) use ($term){
            $query->where('nama', 'like', $term);
        })->orWhere('nama','like', $term);
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
