<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use BehatExpectException\ExceptionExpectationFailed;
use BehatExpectException\ExpectException;
use BehatExpectException\ExpectedAnException;

final class FeatureContext implements Context
{
    use ExpectException;

    /**
     * @When a step runs some code that throws a :exceptionClass with a message :exceptionMessage
     */
    public function iRunSomeCodeThatThrowsAnException(string $exceptionClass, string $exceptionMessage): void
    {
        $this->shouldFail(
            function () use ($exceptionClass, $exceptionMessage) {
                throw new $exceptionClass($exceptionMessage);
            });
    }

    /**
     * @Then another step can confirm that the expected :exceptionClass with a message containing :messageContains was thrown
     */
    public function confirmCaughtExceptionMatchesExpectedTypeAndMessage(
        string $exceptionClass,
        string $messageContains
    ): void {
        $this->assertCaughtExceptionMatches(
            $exceptionClass,
            $messageContains
        );
    }

    /**
     * @Then another step can confirm that the expected :exceptionClass was thrown
     */
    public function confirmCaughtExceptionMatchesExpectedType(
        string $exceptionClass
    ): void {
        $this->assertCaughtExceptionMatches($exceptionClass);
    }

    /**
     * @Then another step will fail to confirm that the expected :exceptionClass with a message containing :messageContains was thrown
     */
    public function failToConfirmCaughtExceptionMatchesExpectedTypeAndMessage(
        string $exceptionClass,
        string $messageContains
    ): void {
        try {
            $this->assertCaughtExceptionMatches(
                $exceptionClass,
                $messageContains
            );

            throw new RuntimeException('The code above should have thrown an ExceptionExpectationFailed exception');
        } catch (ExceptionExpectationFailed $exception) {
            // this was supposed to happen
        }
    }

    /**
     * @When a step runs some code that is expected to fail but does not throw an exception
     */
    public function failToEvenFail(): void
    {
        try {
            $this->shouldFail(
                function () {
                    // does not fail, contrary to expectations
                });
        } catch (ExpectedAnException $exception) {
            // we catch this one now so we can verify that it has been thrown
            $this->caughtException = $exception;
        }
    }

    /**
     * @Then that step will have thrown an ExpectedAnException
     */
    public function confirmExceptionIsExpectedAnException(): void
    {
        $this->assertCaughtExceptionMatches(ExpectedAnException::class);
    }
}
