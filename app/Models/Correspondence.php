<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correspondence extends Model
{
    protected $table = 'correspondences';
 
    protected $fillable = ['number', 'subject','private','status' ,'program_impact','cost_impact','description','distribution_member','recieved_from','recieved_date'];

    

}
