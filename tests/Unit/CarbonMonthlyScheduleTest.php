<?php

namespace Tests\Unit;

use App\Http\Controllers\CarbonOffsetScheduleController;
use App\Impl\MonthlySchedule;
use Illuminate\Http\Request;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Tests\TestCase;

class CarbonMonthlyScheduleTest extends TestCase
{
    use MockeryPHPUnitIntegration;


    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @throws \Exception
     */
    public function testCalculateIsCalled()
    {
        $monthlySchedule = \Mockery::spy(MonthlySchedule::class);
        $request = \Mockery::mock(Request::class);

        $request->shouldReceive('all')
            ->times(1)
            ->andReturn([
                'subscriptionStartDate' => '2020-01-01',
                'scheduleInMonths' => 3
            ]);

        $request->shouldReceive('get')->with('subscriptionStartDate');
        $request->shouldReceive('get')->with('scheduleInMonths')->andReturn(3);

        $controller = new CarbonOffsetScheduleController();
        $controller->__invoke($request, $monthlySchedule);

        $monthlySchedule->shouldHaveReceived('calculate')->with(\DateTimeInterface::class, 3);
    }


    /**
     * @throws \Exception
     */
    public function testCalculateIsNotCalled()
    {
        $monthlySchedule = \Mockery::spy(MonthlySchedule::class);
        $request = \Mockery::mock(Request::class);

        $request->shouldReceive('all')
            ->times(1)
            ->andReturn([
                'subscriptionStartDate' => '2020-01-01',
                'scheduleInMonths' => 37
            ]);

        $request->shouldNotHaveReceived('get');

        $controller = new CarbonOffsetScheduleController();
        $controller->__invoke($request, $monthlySchedule);

        $monthlySchedule->shouldNotHaveReceived('calculate');
    }
}
