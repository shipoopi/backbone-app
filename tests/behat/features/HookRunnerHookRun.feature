Feature: Hooks Run
In order to perform various framework function
As a system I need to be able to run hooks

Scenario: Successful registration
Given a HookRunner
And a request generation hook
And I register the hook
When I run the hooks
Then result is controller bus object
And controller bus has the request object