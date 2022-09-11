<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['title' , 'description' , 'assigned_to_id' , 'assigned_by_id'];


    public function admin()
    {
        return $this->belongsTo(User::class , 'assigned_by_id' , 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class , 'assigned_to_id' , 'id');
    }


}
