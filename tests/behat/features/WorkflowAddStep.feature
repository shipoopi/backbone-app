Feature: Hooks
In order to perform front controller function 
As a system I need to be able to register hooks

Scenario: Successful registration
Given a HookRunner
And a request generation hook
When I register the hook
Then hookRunner has the hook in the cache