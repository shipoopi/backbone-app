Feature: Parameter Storage
In order to use a common key value store across the application
I need to be able to set and retrieve values from the store

Scenario: Parameter storage
Given a KeyValueStore
And I set parameter "name" with value "john"
When I get parameter "name" 
Then parameter is "john"

Scenario: Retrieving value that is not set
Given a KeyValueStore
When I get parameter "name" 
Then parameter is null

Scenario: Trying to retrieve a param without supplying a key
Given a KeyValueStore
When I get parameter with no key throws Exception 
