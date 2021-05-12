<?php

namespace App\Http\Controllers;

use App\Repository\Department\DepartmentRepository;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request, DepartmentRepository $departmentRepository)
    {
        $minSalary = $request->input('min_salary');
        $minNoOfEmployeesHavingMinSalary = $request->input('min_no_of_employees_min_salary');
        if ($minSalary !== null && $minNoOfEmployeesHavingMinSalary !== null) {
            return response()->json(
                $departmentRepository->fetchWithEmployeeSalariesHigherCondition(
                    (int) $minNoOfEmployeesHavingMinSalary,
                    (float) $minSalary
                )
            );
        }

        return response()->json($departmentRepository->fetchAllWithMaxSalaries());
    }
}
