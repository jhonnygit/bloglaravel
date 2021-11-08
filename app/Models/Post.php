<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    //relacion uno a muchos inverso
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(category::class);
    }

    //relacion muchos a muchos 
    public function tags(){
    	return $this->belongsToMany(Tag::class);
    }

    //relacion uno a uno polimorfica
    public function image(){
    	return $this->morphOne(Image::class,'imageable');
    }
}