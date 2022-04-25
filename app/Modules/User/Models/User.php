<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
class User extends Model {

    protected $table = 'users';
    protected $fillable = [
        'id',
        'email',
        'password',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'remember_token'
    ];
}
