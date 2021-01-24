<?php

namespace Tests\Feature;

use function PHPUnit\Framework\assertEquals;
use Tests\TestCase;

class CarbonMonthlyScheduleEndpointTest extends TestCase
{
    const URL = '/api/carbon-offset-schedule?subscriptionStartDate=%s&scheduleInMonths=%d';

    /**
     * @param $startDate
     * @param $scheduleInMonths
     * @param $expected
     * @dataProvider dataProvider
     */
    public function testItReturnsExpectedData($startDate, $scheduleInMonths, $expected)
    {
        $url = sprintf(self::URL, $startDate, $scheduleInMonths);
        $response = $this->get($url);
        assertEquals($expected, json_decode($response->getContent()));
        $response->assertStatus(200);
    }

    public function testItValidatesScheduleInMonths()
    {
        $response = $this->get(sprintf(self::URL, '2020-02-07', 100));
        assertEquals(
            ["scheduleInMonths" => ["The schedule in months may not be greater than 36."]],
            json_decode($response->getContent(), true)
        );
        $response->assertStatus(400);
    }

    public function testItValidatesInputTypes()
    {
        $response = $this->get(sprintf(self::URL, '2020-13-07', '4'));
        assertEquals(
            [
                "subscriptionStartDate" => ["The subscription start date does not match the format Y-m-d."]
            ],
            json_decode($response->getContent(), true)
        );
        $response->assertStatus(400);
    }

    public function testSubscriptionDateCannotBeInFuture()
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $future = new \DateTime("now");

        /** @noinspection PhpUnhandledExceptionInspection */
        $future->add(new \DateInterval('P2D'));

        $response = $this->get(sprintf(self::URL, $future->format('Y-m-d'), 1));

        assertEquals(
            [
                "subscriptionStartDate" => ["The subscription start date must be a date before or equal to today."],
            ],
            json_decode($response->getContent(), true)
        );
        $response->assertStatus(400);
    }

    public function dataProvider(): array
    {
        return [
            [
                '2020-02-07',
                5,
                ["2020-03-07", "2020-04-07", "2020-05-07", "2020-06-07", "2020-07-07"]
            ],
            [
                '2020-01-30',
                3,
                ["2020-02-29", "2020-03-30", "2020-04-30"]
            ],
            [
                '2020-01-31',
                3,
                ["2020-02-29", "2020-03-31", "2020-04-30"]
            ],
            [
                '2020-02-10',
                0,
                []
            ],
        ];
    }
}
