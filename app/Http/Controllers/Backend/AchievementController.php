<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestAchievement;
use App\Models\Achievement;
use App\Models\AchievementEmployee;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;

class AchievementController extends Controller
{
    public function getAllAchievement(): JsonResponse
    {
        try {
            $achievement = Achievement::orderBy('id', 'desc')->get();

        } catch (Exception $exception) {
            return sendErrorResponse('Something went wrong: ' . $exception->getMessage());
        }
        return sendSuccessResponse('Achievement List found!!', '200', $achievement);

    }


    public function getAchievement(Achievement $achievement): JsonResponse
    {
        try {
            return sendSuccessResponse('Achievement Found Successfully!!', '200', $achievement);
        } catch (Exception $exception) {
            return sendErrorResponse('Something went wrong: ' . $exception->getMessage());
        }

    }

    public function storeAchievement(RequestAchievement $request): JsonResponse
    {
        try {
            $achievement = Achievement::create([
                'name' => $request->name,
            ]);
            AchievementEmployee::create([
                'achievement_id' => $achievement->id,
                'employee_id' => $request->employee_id,
                'achievement_date' => $request->achievement_date,
            ]);

        } catch (Exception $exception) {
            return sendErrorResponse('Something went wrong: ' . $exception->getMessage());
        }
        return sendSuccessResponse('Achievement create Successfully!!', '200');

    }

    public function updateAchievement(RequestAchievement $request, Achievement $achievement): JsonResponse
    {
        try {
            $achievement->update([
                'name' => $request->name,
            ]);

            // Find the AchievementEmployee record by its achievement_id or other unique identifier
            $achievementEmployee = AchievementEmployee::where('achievement_id', $achievement->id)->firstOrFail();
            $achievementEmployee->update([
                'achievement_id' => $achievement->id,
                'employee_id' => $request->employee_id,
                'achievement_date' => $request->achievement_date,
            ]);
        } catch (Exception $exception) {
            return sendErrorResponse('Something went wrong: ' . $exception->getMessage());
        }
        return sendSuccessResponse('Achievement Update Successfully!!', '200');

    }

    public function deleteAchievement(Achievement $achievement): JsonResponse
    {
        try {
            $achievement->delete();

        } catch (Exception $exception) {
            return sendErrorResponse('Something went wrong: ' . $exception->getMessage());
        }
        return sendSuccessResponse(' Achievement Delete Successfully!!', '200');

    }

}
