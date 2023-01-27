<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;

    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $guarded = ['id', 'created_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function subcategories(){
        return $this->hasMany(Report_Subcategory::class,'report_id');
    }

    public function categories(){
        return $this->hasMany(CategoryReport::class, 'report_id');
    }


    public function subcategory(){
        return $this->belongsToMany(Subcategory_Report::class, 'subcategory_report', 'report_id', 'subcategory_id')
        ->withTimestamps();
    }

    public function category(){
        return $this->belongsToMany(CategoryReport::class, 'category_report', 'report_id', 'category_id')
        ->withTimestamps();
    }

    public function pengikut(){
        return $this->hasMany(Report_User::class);
    }

    public function dokumentasi(){
        return $this->hasOne(Documentation::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'what'
            ]
        ];
    }

    public function scopeCari($query, $term){
        $term = "%$term%";
        $query->whereHas('user', function($query) use ($term){
            $query->where('name', 'like', $term);
        })->orWhere('when','like', $term)
        ->orWhere('where', 'like', $term)
        ->orWhere('what', 'like', $term);
    }
}
