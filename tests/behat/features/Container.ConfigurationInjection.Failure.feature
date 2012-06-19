Feature: Container configuration injection
In order to configure an object within the object context
I need to be able supply object specific configuration information

Scenario: Not configurable
Given container
And root configuration with configuration
When I get a non configurable dependency I get exception

Scenario: Injections present but configuration not supplied
Given container
And root configuration with no configuration
When I get dependency I get exception