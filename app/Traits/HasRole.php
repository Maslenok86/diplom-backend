<?php

namespace App\Traits;

trait HasRole {

    public function __construct(array $attributes = [])
    {
        $this->fillable[] = 'role_id';

        parent::__construct($attributes);
    }

    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class);
    }
}
