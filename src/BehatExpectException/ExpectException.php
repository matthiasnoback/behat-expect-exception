<?php
declare(strict_types=1);

namespace BehatExpectException;

use Exception;
use LogicException;
use Test\Acceptance\ExpectedAnException;

trait ExpectException
{
    /**
     * @var Exception|null
     */
    private $caughtException;

    private function shouldFail(callable $function): void
    {
        try {
            $function();

            throw new ExpectedAnException();
        } catch (Exception $exception) {
            if ($exception instanceof ExpectedAnException) {
                throw $exception;
            }

            $this->caughtException = $exception;
        }
    }

    private function assertCaughtExceptionMatches(
        string $expectedExceptionClass,
        ?string $messageShouldContain = null
    ) {
        if (!$this->caughtException instanceof Exception) {
            throw new LogicException('To catch an exception, call $this->shouldFail() first');
        }

        if (!$this->caughtException instanceof $expectedExceptionClass) {
            throw new ExceptionExpectationFailed(
                sprintf(
                    'Expected the caught exception to be of type %s, caught an exception of type %s instead',
                    $expectedExceptionClass,
                    get_class($this->caughtException)
                )
            );
        }

        if ($messageShouldContain !== null
            && stripos($this->caughtException->getMessage(), $messageShouldContain) === false) {
            throw new ExceptionExpectationFailed(
                sprintf(
                    'Expected the message of the caught exception to contain %s. The actual message was: %s',
                    $messageShouldContain,
                    $this->caughtException->getMessage()
                )
            );
        }
    }
}