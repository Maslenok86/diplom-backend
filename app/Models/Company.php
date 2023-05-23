<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'address',
        'phone',
        'email',
        'description',
        'user_id',
    ];

    public $timestamps = false;

    public function departments(){
        return $this->hasMany(Department::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }
    
    // public function admins(){
    //     return $this->hasMany(Department::class);
    // }
}
