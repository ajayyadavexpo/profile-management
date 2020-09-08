<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userdetail extends Model
{
    protected $fillable = ['user_id','father','mother','wife','child','address','city','country','state','zip_code'];
}
