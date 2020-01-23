Feature:

  Scenario: The expected exception class with the expected message was thrown
    When a step runs some code that throws a RuntimeException with a message "The actual message"
    Then another step can confirm that the expected RuntimeException with a message containing "actual message" was thrown

  Scenario: Casing is irrelevant when comparing exception messages
    When a step runs some code that throws a RuntimeException with a message "The actual message"
    Then another step can confirm that the expected RuntimeException with a message containing "aCtUaL mEsSaGe" was thrown

  Scenario: The expected exception class was thrown (we ignore the message)
    When a step runs some code that throws a RuntimeException with a message "Irrelevant message"
    Then another step can confirm that the expected RuntimeException was thrown

  Scenario: A different exception with the same message was thrown
    When a step runs some code that throws a RuntimeException with a message "The same message"
    Then another step will fail to confirm that the expected LogicException with a message containing "The same message" was thrown

  Scenario: The same exception with a different message was thrown
    When a step runs some code that throws a RuntimeException with a message "The same message"
    Then another step will fail to confirm that the expected RuntimeException with a message containing "A different message" was thrown

  Scenario: A different exception with different message was thrown
    When a step runs some code that throws a RuntimeException with a message "The same message"
    Then another step will fail to confirm that the expected LogicException with a message containing "A different message" was thrown

  Scenario: The code does not even throw an exception
    When a step runs some code that is expected to fail but does not throw an exception
    Then that step will have thrown an ExpectedAnException

  Scenario: The code may throw an exception
    When a step runs some code that may throw an exception but does not throw it
    Then another step will fail to confirm that the expected RuntimeException with a message containing "actual message" was thrown
