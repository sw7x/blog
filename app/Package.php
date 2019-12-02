<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
     protected $table = 'packages';
     public $timestamps = false;
     //protected $fillable = ['title'];


     public function aaa()
     {
         //echo 'AAAA';
     }
}
