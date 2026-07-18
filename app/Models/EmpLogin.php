<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpLogin extends Model
{
    protected $table = 'emp_login';
    protected $primaryKey = 'empid';
    public $timestamps = false;

    protected $fillable = ['Emp_Email', 'Emp_Password'];
}
