<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Pet extends EloquentModel 
{
    protected $table = 'pets';
    public $timestamps = false;
}