<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Users extends EloquentModel 
{
    protected $table = 'users';
    public $timestamps = false;
}