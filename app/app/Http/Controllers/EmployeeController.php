<?php

namespace App\Http\Controllers;

use App\Entities\Department\DepartmentKey;
use App\Repository\Department\DepartmentRepository;
use App\Repository\Employee\EmployeeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    public function index(Request $request, EmployeeRepository $employeeRepository, DepartmentRepository $departmentRepository)
    {
        $departmentId = $request->input('department_id');
        if ($departmentId) {
            if (!$departmentRepository->fetch((int) $departmentId)) {
                return response()->json(['errors' => ['department_id' => ['Department not found.']]], 405);
            }

            return response()->json($employeeRepository->fetchFromDepartment(new DepartmentKey((int) $departmentId)));
        } else {
            return response()->json($employeeRepository->fetchAll());
        }
    }

    public function store(
        Request $request,
        DepartmentRepository $departmentRepository,
        EmployeeRepository $employeeRepository
    ): JsonResponse {
        try {
            $this->validate(
                $request,
                [
                    'first_name' => 'required|string|min:2|max:255',
                    'last_name' => 'required|string|min:2|max:255',
                    'salary' => 'required|numeric',
                    'department_id' => 'required|integer',
                ]
            );
        } catch (ValidationException $validationException) {
            return response()->json(['errors' => $validationException->errors()], 405);
        }

        $department = $departmentRepository->fetch($request->input('department_id'));
        if (!$department) {
            return response()->json(['errors' => ['department_id' => ['Department not found.']]], 405);
        }

        $data = $request->only(['first_name', 'last_name', 'salary', 'department_id']);

        return response()->json($employeeRepository->create($data));
    }
}
