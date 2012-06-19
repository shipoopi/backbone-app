Feature: Container configuration injection
In order to configure an object within the object context
I need to be able supply object specific configuration information

Scenario: Configurable and normal value
Given container
And root configuration with scalar configuration
When I get dependency
Then value is changed for the dependency

Scenario: Configurable and services
Given container
And root configuration with configuration having service reference
When I get dependency
Then the value is a service