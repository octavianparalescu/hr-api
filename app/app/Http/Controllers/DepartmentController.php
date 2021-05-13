<?php

namespace App\Http\Controllers;

use App\Repository\Department\DepartmentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DepartmentController extends Controller
{
    public function index(Request $request, DepartmentRepository $departmentRepository): JsonResponse
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

        $includeMaxSalaries = $request->input('include_max_salary');
        if ($includeMaxSalaries) {
            return response()->json($departmentRepository->fetchAllWithMaxSalaries());
        }

        return response()->json($departmentRepository->fetchAll());
    }

    public function store(Request $request, DepartmentRepository $departmentRepository): JsonResponse
    {
        try {
            $this->validate(
                $request,
                [
                    'name' => 'required|string|min:6|max:255',
                ]
            );
        } catch (ValidationException $validationException) {
            return response()->json(['errors' => $validationException->errors()], 405);
        }

        $data = $request->only(['name']);

        $department = $departmentRepository->create($data);

        return response()->json($department);
    }
}
