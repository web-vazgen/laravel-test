<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    public $incrementing=false;

    protected $primaryKey=null;

    protected $fillable=[
        'title',
        'from_date'
    ];

    public function emplyee()
    {
        return $this->belongsTo('App\Employee', 'emp_no', 'emp_no');
    }
}
