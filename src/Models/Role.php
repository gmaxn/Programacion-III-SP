<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Role extends EloquentModel 
{
    protected $table = 'roles';
    public $timestamps = false;
}