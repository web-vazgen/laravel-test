<?php

namespace App\Http\Controllers;

use App\Department;
use App\Employee;
use App\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function getDepartments(Request $request)
    {
        $type=$request->header('accept');

        $departments=Department::all();
        $result=[];
        $result['departments']=[];
        foreach ($departments as $department) {
            $result['departments'][$department->dept_name]=[
                'employees_count'=>$department->employees_count,
                'managers_count'=>$department->managers_count,
            ];
        }
        if ($type === 'application/xml') {
            $contents=$this->getDepartmentsXml($result);
            $response=Response::make($contents, 200);
            $response->header('Content-Type', 'application/xml');
            return $response;
        } elseif ($type === 'application/json') {
            return response()->json($result);
        } else {
            return \response()->json(['Undefined format']);
        }
    }

    public function getTitles(Request $request)
    {
        $type=$request->header('accept');
        $titles=Title::groupBy('title')
            ->orderBy('title', 'asc')
            ->pluck('title')
            ->toArray();
        if ($type === 'application/xml') {
            $contents=$this->getTitlesXml(array_values($titles));
            $response=Response::make($contents, 200);
            $response->header('Content-Type', 'application/xml');
            return $response;
        } elseif ($type === 'application/json') {
            return response()->json(array_values($titles));
        } else {
            return \response()->json(['Undefined format']);
        }
    }

    public function getEmployees(Request $request)
    {
        $type=$request->header('accept');
        $offset=0;
        $count=100;
        $relation='departments';
        if ($request->user_type === 'manager') {
            $relation='managerDepartments';
        }
        if ($request->has('offset')) $offset=$request->offset;
        if ($request->has('count')) $offset=$request->count;
        $department=$request->department;
        $employees=Employee::where('hire_date', $request->hire_date)
            ->where('gender', $request->gender)
            ->whereHas($relation, function ($query) use ($department) {
                $query->where('dept_name', $department);
            })
            ->with('salaries')
            ->skip($offset)
            ->take($count)
            ->get();
        $result=[];
        foreach ($employees as $employee) {
            $result[]=[
                'First Name'=>$employee->first_name,
                'Last Name'=>$employee->last_name,
                'Gender'=>$employee->gender,
                'Salary'=>$employee->salaries()->first()->salary,
                'Type'=>$employee->type,
            ];
        }
        if ($type === 'application/xml') {
            $contents=$this->getEmployeesXml($result);
            $response=Response::make($contents, 200);
            $response->header('Content-Type', 'application/xml');
            return $response;
        } elseif ($type === 'application/json') {
            return response()->json($result);
        } else {
            return \response()->json(['Undefined format']);
        }
    }


    public function getDepartmentsXml($array=[])
    {
        $xml='<?xml version="1.0"?>';
        $xml.='<departments>';
        foreach ($array['departments'] as $key=>$value) {
            $xml.='<' . Str::slug($key) . '>';
            $xml.='<EmployeesCount>' . $value['employees_count'] . '</EmployeesCount>';
            $xml.='<ManagersCount>' . $value['managers_count'] . '</ManagersCount>';
            $xml.='</' . Str::slug($key) . '>';
        }
        $xml.='</departments>';
        return $xml;
    }

    public function getTitlesXml($array=[])
    {
        $xml='<?xml version="1.0"?>';
        $xml.='<titles>';
        foreach ($array as $value) {
            $xml.='<title>' . $value . '</title>';
        }
        $xml.='</titles>';
        return $xml;
    }

    public function getEmployeesXml($employees)
    {
        $xml='<?xml version="1.0"?>';
        $xml.='<employees>';
        foreach ($employees as $employee) {
            $xml.='<employee>';
            $xml.='<FirstName>' . $employee['First Name'] . '</FirstName>';
            $xml.='<LastName>' . $employee['Last Name'] . '</LastName>';
            $xml.='<Gender>' . $employee['Gender'] . '</Gender>';
            $xml.='<Salary>' . $employee['Salary'] . '</Salary>';
            $xml.='<Type>' . $employee['Type'] . '</Type>';
            $xml.='</employee>';
        }
        $xml.='</employees>';
        return $xml;
    }
}
