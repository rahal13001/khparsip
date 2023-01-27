<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;


class Subcategory_Report extends Pivot
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $table = 'subcategory_report';
    protected $guarded = ['created_at'];

    public function report(){
        return $this->belongsTo(Report::class);
    }

    public function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }

    public function user(){
        return $this->belongsToThrough(User::class, Report::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
