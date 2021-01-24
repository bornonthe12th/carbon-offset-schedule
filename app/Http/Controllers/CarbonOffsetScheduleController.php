<?php

namespace App\Http\Controllers;

use App\Impl\MonthlySchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CarbonOffsetScheduleController extends Controller
{

    /**
     * @param Request $request
     * @param MonthlySchedule $monthlySchedule
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function __invoke(Request $request, MonthlySchedule $monthlySchedule)
    {
        $validator = Validator::make($request->all(), [
            'subscriptionStartDate' => 'required|date_format:Y-m-d|before_or_equal:today',
            'scheduleInMonths' => 'required|integer|max:36',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        $subscriptionStartDate = new \DateTimeImmutable($request->get('subscriptionStartDate'));
        $scheduleInMonths = $request->get('scheduleInMonths');

        return response()->json(
            $monthlySchedule->calculate($subscriptionStartDate, $scheduleInMonths)
        );
    }
}
