<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestDepartment;
use App\Models\Department;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;

class DepartmentController extends Controller
{
    public function getAllDepartment(): JsonResponse
    {
        try {
            $department = Department::orderBy('id', 'desc')->get();

        } catch (Exception $exception) {
            return sendErrorResponse('Something went wrong: ' . $exception->getMessage());
        }
        return sendSuccessResponse('Department List found!!', '200', $department);

    }


    public function getDepartment(Department $department): JsonResponse
    {
        try {
            return sendSuccessResponse('Department Found Successfully!!', '200', $department);
        } catch (Exception $exception) {
            return sendErrorResponse('Something went wrong: ' . $exception->getMessage());
        }

    }

    public function storeDepartment(RequestDepartment $request): JsonResponse
    {
        try {
            Department::create([
                'name' => $request->name,
            ]);

        } catch (Exception $exception) {
            return sendErrorResponse('Something went wrong: ' . $exception->getMessage());
        }
        return sendSuccessResponse('Department create Successfully!!', '200');

    }

    public function updateDepartment(RequestDepartment $request, Department $department): JsonResponse
    {
        try {
            $department->update([
                'name' => $request->name,
            ]);
        } catch (Exception $exception) {
            return sendErrorResponse('Something went wrong: ' . $exception->getMessage());
        }
        return sendSuccessResponse('Department Update Successfully!!', '200');


    }

    public function deleteDepartment(Department $department): JsonResponse
    {
        try {
            $department->delete();

        } catch (Exception $exception) {
            return sendErrorResponse('Something went wrong: ' . $exception->getMessage());
        }
        return sendSuccessResponse(' Department Delete Successfully!!', '200');

    }
}
