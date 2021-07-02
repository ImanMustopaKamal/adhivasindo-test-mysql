<?php

namespace App;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'user_id', 'nama', 'email', 'created_at', 'updated_at'
    ];
}
