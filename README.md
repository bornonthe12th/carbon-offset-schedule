## Technical Challenge
The average Brit produces 10.51 tonnes of carbon dioxide emissions
a year – what’s known as our carbon footprint. Tickr's carbon
offsetting membership lets you balance your carbon footprint by
supporting projects around the world that reduce carbon emissions
with a monthly subscription fee of £12.
Design an API endpoint that provides our mobile clients (iOS &
Android) a monthly payment schedule between the membership start
date and the next X months.
For example, if I subscribed to my carbon offset membership on Feb
7th 2021, my schedule for the next six months is:
Mar 7th, Apr 7th, May 7th, Jun 7th, Jul 7th and Aug 7th.

## Requirements
* the endpoint is exposed at GET /carbon-offset-schedule
* the endpoint returns a JSON response with an array of recurring dates
* the dates are sorted by ascending order
* the dates are in ISO 8601 format YYYY-MM-DD
* if a given month doesn't have enough days, use the last day of the month.
    For example, a subscription started on Jan 31st will have its next payment
    date on Feb 28th (Feb 29th for a leap year)
* return a 400 if the request has invalid parameters
     BONUS: return the validation error message

## The Input
* /carbon-offset-schedule?subscriptionStartDate=YYYY-MM-DD&scheduleInMonths
=INTEGER
* subscriptionStartDate is the date the user started the subscription - this will be your
base date, always in the past or current date
* scheduleInMonths is the number of months (an integer) in the future, 0<=X<=36
months
The Output
* a JSON response in this format:
["YYYY-MM-DD", "YYYY-MM-DD", "YYYY-MM-DD", "YYYY-MM-DD", ...]
* Example:
["2021-02-19", "2021-03-19", "2021-04-19", "2021-05-19"]

##### Install Requirements

* GNU make https://www.gnu.org/software/make/
* Docker https://docs.docker.com/engine/installation/
* Docker compose https://docs.docker.com/compose/install/


##### Install Dependencies

```$xslt
 docker run --rm -v ${PWD}:/app composer install

```

##### Run Tests

```$xslt
 docker-compose run --rm webapp make test-phpunit 

```

##### Run App

```$xslt
 docker-compose run

```

##### Example Request

```$xslt
curl --location --request GET 'localhost/api/carbon-offset-schedule?subscriptionStartDate=2020-12-31&scheduleInMonths=3' \
--header 'Content-Type: application/json'
```


