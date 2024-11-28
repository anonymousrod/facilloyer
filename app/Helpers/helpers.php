<?php

use App\Models\Role;

function getRoles($except = 1)
{
    $roles = Role::where('id', '!=', $except)->get();
    return $roles;
}
