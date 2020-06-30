<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Appointment extends EloquentModel 
{
    protected $table = 'appointments';
    public $timestamps = false;
}