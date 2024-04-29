<?php

namespace App\Models;

use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user (){
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'user_courses');
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class,'course_id','id');
    }


}
