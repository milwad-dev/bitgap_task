<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;

    /**
     * The relations to eager load on every query.
     *
     * @var string[]
     */
    protected $with = ['permissions'];
}
