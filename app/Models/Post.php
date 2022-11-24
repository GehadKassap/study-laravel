<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ["title" , "desc"];
    // protected $dates = ['deleted_at'];
    // one to one relationship
    public function user(){
        return $this->belongsTo(User::class);
    }
}
