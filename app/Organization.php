<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model {

    protected $fillable = ['type', 'unit'];
    protected $table = 'organization';

}