<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestEmployee;
use App\Models\Employee;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    public function getAllEmployee(): JsonResponse
    {
        try {
            $employee = Employee::with('department')->get();

        } catch (Exception $exception) {
            return sendErrorResponse('Something went wrong: ' . $exception->getMessage());
        }
        return sendSuccessResponse('Employee List found!!', '200', $employee);

    }



    public function getEmployee(Employee $employee): JsonResponse
    {
        try {

            return sendSuccessResponse('Employee Found Successfully!!', '200', $employee);
        } catch (Exception $exception) {

            return sendErrorResponse('Something went wrong: ' . $exception->getMessage());
        }

    }



    public function storeEmployee(RequestEmployee $request): JsonResponse
    {

        try {
            Employee::create([
                'department_id'     => $request->department_id,
                'name'              => $request->name,
                'email'             => $request->email,
                'phone'             => $request->phone,
                'address'           => $request->address,
            ]);


        } catch (Exception $exception) {
            return sendErrorResponse('Something went wrong: ' . $exception->getMessage());
        }
        return sendSuccessResponse('Employee created Successfully!!', '200');

    }

    public function updateEmployee(RequestEmployee $request, Employee $employee): JsonResponse
    {
        try {
            $employee->update([
                'department_id'     => $request->department_id,
                'name'              => $request->name,
                'email'             => $request->email,
                'phone'             => $request->phone,
                'address'           => $request->address,
            ]);
        } catch (Exception $exception) {
            return sendErrorResponse('Something went wrong: ' . $exception->getMessage());
        }
        return sendSuccessResponse('Employee Update Successfully!!', 200);
    }

    public function deleteEmployee(Employee $employee): JsonResponse
    {
        try {
            $employee->delete();
        } catch (Exception $exception) {
            return sendErrorResponse('Something went wrong: ' . $exception->getMessage());
        }
        return sendSuccessResponse('Employee Delete Successfully!!', '200');

    }
}
