<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Termwind\renderUsing;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'category_id', 'user_id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function user(){ // осы постты создать еткен юзер
        return $this->belongsTo(User::class);
    }

    public function usersRated(){ // осы постка оценка берген юзерлер
        return $this->belongsToMany(User::class)
        ->withPivot('rating')
        ->withTimestamps();
    }

    public function usersBought(){
        return $this->belongsToMany(User::class, 'cart')
            ->withTimestamps()
            ->withPivot('number', 'color', 'status')
            ->using(Cart::class);
    }
}
