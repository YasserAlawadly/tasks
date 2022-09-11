<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = ['user_id' , 'count'];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
}
