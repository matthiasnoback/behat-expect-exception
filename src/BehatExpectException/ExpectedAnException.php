<?php

declare(strict_types=1);

namespace BehatExpectException;

use RuntimeException;

final class ExpectedAnException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Expected an exception');
    }
}
