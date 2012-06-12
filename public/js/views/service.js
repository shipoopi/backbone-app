define([
  'jquery', 
  'underscore', 
  'backbone',
  'text!templates/service.html'
  ], function($, _, Backbone, serviceTemplate){
  var ServiceView = Backbone.View.extend({

    //... is a list tag.
    tagName:  "tr",

    // Cache the template function for a single item.
    template: _.template(serviceTemplate),

    // The DOM events specific to an item.
    events: {
      "click .check"              : "toggleDone",
      "dblclick div.todo-content" : "edit",
      "click span.todo-destroy"   : "clear",
      "keypress .todo-input"      : "updateOnEnter",
      "blur .todo-input"          : "close"
    },

    // The TodoView listens for changes to its model, re-rendering. Since there's
    // a one-to-one correspondence between a **Todo** and a **TodoView** in this
    // app, we set a direct reference on the model for convenience.
    initialize: function() {
      _.bindAll(this, 'render');
      //this.model.bind('change', this.render);
      //this.model.bind('destroy', this.remove);
    },

    // Re-render the contents of the todo item.
    render: function() {
        
        $(this.el).html(this.template(this.model.toJSON()));
        $(this.el).find('.a-service-detailed-view').click(
            this.showServiceDetailedView);
            
      return this;
    },

    showServiceDetailedView: function() {
        
    },
    
    // Toggle the `"done"` state of the model.
    toggleDone: function() {
      this.model.toggle();
    },

    // Switch this view into `"editing"` mode, displaying the input field.
    edit: function() {
      $(this.el).addClass("editing");
      this.input.focus();
    },

    // Close the `"editing"` mode, saving changes to the todo.
    close: function() {
      this.model.save({content: this.input.val()});
      $(this.el).removeClass("editing");
    },

    // If you hit `enter`, we're through editing the item.
    updateOnEnter: function(e) {
      if (e.keyCode == 13) this.close();
    },

    // Remove the item, destroy the model.
    clear: function() {
      this.model.clear();
    }

  });
  return ServiceView;
});
