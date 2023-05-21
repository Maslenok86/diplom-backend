<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'company_id',
        'parent_id',
    ];

    public $timestamps = false;

    public function parent()
    {
        return $this->hasOne(Department::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Department::class, 'id', 'parent_id');
    }

    public function company(){
        return $this->hasOne(Company::class);
    }

    public function admins(){
        return $this->belongsToMany(Admin::class,'admin_department');
    }
}
