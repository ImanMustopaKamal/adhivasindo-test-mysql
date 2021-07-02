<?php

namespace App;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupModel extends Model
{
    protected $table = 'group';
    protected $primaryKey = 'user_group_id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'user_group_id', 'nama', 'keterangan', 'created_at', 'updated_at'
    ];
}
