<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $table = 'tbl_inquiry';
    public $timestamps = [ "created_at" ]; // enable only to created_at


}
