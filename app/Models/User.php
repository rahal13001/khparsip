<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    use HasRoles;

    use \Znck\Eloquent\Traits\BelongsToThrough;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'kelompok'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //relasi antara user dan kategori dengan tabel pivot
    public function category(){
        return $this->belongsToMany(Category::class);
    }

    public function scopeCari($query, $term){
        $term = "%$term%";
        $query->where('name','like', $term)->
        orWhereHas('category', function($category_nama) use ($term){
            $category_nama->where('nama', 'like', $term );
        })->orWhereHas('roles', function($role_name) use ($term){
            $role_name->where('name', 'like', $term);
        });
    }


}
