<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function user(){
        return $this->hasOne(User::class);
    }

    public function taskStatuses(){
        return $this->hasMany(TaskStatus::class);
    }

    public function adminDepartments(){
        return $this->hasMany(AdminDepartment::class);
    }

    public function departments(){
        return $this->belongsToMany(Department::class,'admin_department');
    }
}
