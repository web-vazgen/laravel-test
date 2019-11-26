<?php

namespace App\Http\Controllers;

use App\Department;
use App\DepartmentToEmployee;
use App\Employee;
use App\Salary;
use App\Title;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        $data=[];
        $data['departments']=Department::orderBy('dept_name', 'asc')
            ->pluck('dept_name', 'dept_no')
            ->toArray();
        $data['titles']=Title::groupBy('title')
            ->orderBy('title', 'asc')
            ->pluck('title')
            ->toArray();
        $data['errors']=false;
        return view('employee.add-employee', $data);
    }

    public function saveEmployee(Request $request)
    {
        $rules=[
            'first_name'=>'required|alpha',
            'last_name'=>'required|alpha',
            'birth_date'=>'required|date',
            'hire_date'=>'required|date',
            'salary'=>'required|numeric',
        ];
        $validator=Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors=$validator->errors();
            $data=[];
            $data['departments']=Department::orderBy('dept_name', 'asc')
                ->pluck('dept_name', 'dept_no')
                ->toArray();
            $data['titles']=Title::groupBy('title')
                ->orderBy('title', 'asc')
                ->pluck('title')
                ->toArray();
            $data['errors']='';
            foreach ($errors->getMessages() as $message) {
                $data['errors'].=$message[0] . "\n";
            }
            return view('employee.add-employee', $data);
        }
        $data=$request->except('_token');
        $departmentId=$data['department'];
        $titleString=$data['title'];
        $fromDate=$data['hire_date'];
        $salaryValue=$data['salary'];
        unset($data['department'], $data['title'], $data['salary']);
        $employee=new Employee();
        $employee->fill($data);
        $employee->timestamps=false;
        $employee->emp_no=Employee::orderBy('emp_no', 'desc')->first()->emp_no + 1;
        if ($employee->save()) {
            $title=new Title();
            $title->title=$titleString;
            $title->from_date=$fromDate;
            $title->timestamps=false;
            $employee->titles()->save($title);
            $salary=new Salary();
            $salary->salary=$salaryValue;
            $salary->from_date=$fromDate;
            $salary->to_date=Carbon::now();
            $salary->timestamps=false;
            $employee->salaries()->save($salary);
            $department=Department::whereDeptNo($departmentId)->first();
            $deptEmp=new DepartmentToEmployee();
            $department->employees()->attach($employee->emp_no, [
                'from_date'=>$fromDate,
                'to_date'=>Carbon::now()
            ]);
        }
        return back();
    }
}
