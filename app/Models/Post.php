<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Termwind\renderUsing;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
