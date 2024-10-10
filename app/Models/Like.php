<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Like extends Model
{
    use HasFactory;
    protected $fillable = ['like_count'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
