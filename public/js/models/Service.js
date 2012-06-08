define(['underscore', 'backbone'], function(_, Backbone) {
  var ServiceModel = Backbone.Model.extend({

    url: '/api/index',
    
    // Ensure that each todo created has `content`.
    initialize: function() {
        
    },

    // Remove this Todo from *localStorage*.
    clear: function() {
      this.destroy();
    }

  });
  return ServiceModel;
});
