<?php

use Behat\Behat\Context\Context;
use BehatExpectException\ExceptionExpectationFailed;
use BehatExpectException\ExpectException;

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
}
