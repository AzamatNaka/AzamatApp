<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'role_id',
        'is_active',
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

    public function posts(){ // юзердин создать еткен посттарга арналган
        return $this->hasMany(Post::class);
    }

    public function postsRated(){ // юзердын посттарга оценка бергени \еще + rating тен баска посттардын обектысын тож кайтарады
        return $this->belongsToMany(Post::class) // тек пост и юзер айдилармен жумыс ыстейды
            ->withPivot('rating') // withPivot rating деген столбецты косып тур
            ->withTimestamps(); // 'created_at', 'updated_at' осы екеуын косып тур
//        return $this->belongsToMany(Post::class, 'post_rate_user'); баска ат бергин келсе
    }

    public function postsBought(){ //сатып алган посттар
        return $this->belongsToMany(Post::class, 'cart')
            ->withTimestamps()
            ->withPivot('number', 'color', 'status');
    }

    public function postsWithStatus($status){
        return $this->belongsToMany(Post::class, 'cart')
            ->wherePivot('status', $status)
            ->withPivot('number', 'color', 'status')
            ->withTimestamps();
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }
}
