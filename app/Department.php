<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'dept_no';

    protected $attributes = ['managers_count','employees_count'];

    public function employees(){
        return $this->belongsToMany('App\Employee', 'dept_emp', 'dept_no', 'emp_no');
    }

    public function managers(){
        return $this->belongsToMany('App\Employee', 'dept_manager', 'dept_no', 'emp_no');
    }

    public function getManagersCountAttribute(){
        return $this->managers()->count();
    }

    public function getEmployeesCountAttribute(){
        return $this->employees()->count();
    }
}
