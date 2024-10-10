<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Penerima;
use Illuminate\Support\Facades\DB;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function periksas()
    {
        return $this->hasMany(Periksa::class);
    }    

    public function posts()
    {
        return $this->hasMany(Post::class);
    }    

    public function likes()
    {
        return $this->hasMany(Like::class);
    }    

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }   

    public function penerimas()
    {
        // $penerimas = DB::table('penerimas')->get();
        // return $penerimas;
        return $this->hasMany(Penerima::class);
    }    
}
