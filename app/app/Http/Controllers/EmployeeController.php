<?php

namespace App\Http\Controllers;

use App\Entities\Department\DepartmentKey;
use App\Repository\Employee\EmployeeRepository;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request, EmployeeRepository $employeeRepository)
    {
        $departmentId = $request->input('department_id');
        if ($departmentId) {
            return response()->json($employeeRepository->fetchFromDepartment(new DepartmentKey((int) $departmentId)));
        } else {
            return response()->json($employeeRepository->fetchAll());
        }
    }
}
