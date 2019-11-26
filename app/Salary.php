<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    public $incrementing=false;

    protected $primaryKey=null;

    protected $fillable=[
        'salary',
        'from_date'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee', 'emp_no', 'emp_no');
    }


}
