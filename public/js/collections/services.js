define([
    'underscore', 
    'backbone', 
    'models/Service'
    ], function(_, Backbone, Service){
	  
        var ServicesCollection = Backbone.Collection.extend({
            url: '/api/index/services',
            // Reference to this collection's model.
            model: Service
        });
  
        return new ServicesCollection;
    });
