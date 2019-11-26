<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $incrementing=false;

    protected $fillable=[
        'first_name',
        'last_name',
        'gender',
        'birth_date',
        'hire_date',
    ];

    protected $attributes=['type'];

    protected $primaryKey='emp_no';

    public function departments()
    {
        return $this->belongsToMany('App\Department', 'dept_emp', 'emp_no', 'dept_no');
    }

    public function managerDepartments()
    {
        return $this->belongsToMany('App\Department', 'dept_manager', 'emp_no', 'dept_no');
    }

    public function getTypeAttribute()
    {
        if ($this->managerDepartments()->exists()) {
            return 'manager';
        }
        return 'employee';
    }

    public function salaries()
    {
        return $this->hasMany('App\Salary', 'emp_no', 'emp_no')->orderBy('from_date', 'desc');
    }

    public function titles()
    {
        return $this->hasMany('App\Title', 'emp_no', 'emp_no');
    }

}
