<?php

namespace App\Models;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $guarded = [] ;

    public function user () {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function links (){
        return $this->hasMany(Resource::class);
    }
}
