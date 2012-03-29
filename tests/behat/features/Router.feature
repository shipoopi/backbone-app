Feature: routing  feature
In order to route the request to appropriate service controller
As a system I need to be able to resolve the appropriate controller

Scenario: No files
Given empty directory
And router
And a request
And I resolve the route
Then route is null

Scenario: Files but no files with php extension
Given a directory with no php files
And router
And a request
And I resolve the route
Then route is null

Scenario: Files but no classes with Route annotation
Given a directory having no classes with route annotation
And router
And a request
When I resolve the route
Then route is null

Scenario: when media type is not given
Given a directory having no media type with route annotation
And router
And a request
When I resolve the route
Then route is Route instance
And matches expected route

Scenario: when media type is given
Given a directory having media type with route annotation
And router
And a request
When I resolve the route
Then route is Route instance
And matches expected route

Scenario: when media type is given but no matching method found
Given a directory having no matching media type route annotation
And router
And a request
When I resolve the route
Then route is null

