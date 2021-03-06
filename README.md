[![Build Status](https://travis-ci.org/matthiasnoback/behat-expect-exception.svg?branch=master)](https://travis-ci.org/matthiasnoback/behat-expect-exception)

## Installation

```bash
composer require --dev matthiasnoback/behat-expect-exception
```

## Purpose

This library lets you run code in one step definition that is expected to thrown an exception, then in another step definition allows you to verify that the correct exception was caught. Just like with PHPUnit you can compare the type of the caught exception to the expected type, and you can check if the actual exception message contains a given string.

## Usage example

```php
use Behat\Behat\Context\Context;
use BehatExpectException\ExpectException;

final class FeatureContext implements Context
{
    // Use this trait in your feature context:
    use ExpectException;

    /**
     * @When I try to make a reservation for :numberOfSeats seats
     */
    public function iTryToMakeAReservation(int $numberOfSeats): void
    {
        /* 
         * Catch an exception using $this->shouldFail().
         * If the code in the callable doesn't throw an exception, shouldFail()
         * itself will throw an ExpectedAnException exception.
         */
        
        $this->shouldFail(
            function () use ($numberOfSeats) {
                // This will throw a CouldNotMakeReservation exception:
                $this->reservationService()->makeReservation($numberOfSeats);
            }
        );
    }

    /**
     * @Then I should see an error message saying: :message
     */
    public function confirmCaughtExceptionMatchesExpectedTypeAndMessage(string $message): void
    {
        $this->assertCaughtExceptionMatches(
            CouldNotMakeReservation::class,
            $message
        );
    }
    
    /**
     * @When I make a reservation for :numberOfSeats seats
     */
    public function iMakeAReservation(int $numberOfSeats): void
    {
        /*
         * Catch a possible exception using $this->mayFail().
         * If the code in the callable doesn't throw an exception,
         * then it's not a problem. mayFail() doesn't throw an
         * ExpectedAnException exception itself in that case.
         * You can still use assertCaughtExceptionMatches(), but
         * it will throw an ExpectedAnException if no exception was
         * caught. 
         */
        
        $this->mayFail(
            function () use ($numberOfSeats) {
                // This might throw a CouldNotMakeReservation exception:
                $this->reservationService()->makeReservation($numberOfSeats);
            }
        );
    }
}
```
