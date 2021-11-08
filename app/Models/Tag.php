<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable=['name','slug','color'];

    //metodo que miestra slug de cueta el id en el link
    public function getRouteKeyName()
    {
        return "slug";
    }

    //relacion muchos a muchos
    public function post(){
    	return $this->belongsToMany(Post::class);
    }
}
