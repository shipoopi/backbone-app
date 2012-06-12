define([
    'jquery',
    'underscore', 
    'backbone',
    'views/services-widget'
    ], function($, _, Backbone, ServicesWidget){
      

        var AppView = Backbone.View.extend({

            // Instead of generating a new element, bind to the existing skeleton of
            // the App already present in the HTML.
            el: $("#app-view"),

   

            // Delegated events for creating new items, and clearing completed ones.
            events: {
            },

            // At initialization we bind to the relevant events on the `Todos`
            // collection, when items are added or changed. Kick things off by
            // loading any preexisting todos that might be saved in *localStorage*.
            initialize: function() {
                _.bindAll(this, 'render');

                this.mainPane = this.$('#main-pane');
                this.serviceWidget = new ServicesWidget({
                    appendTo: this.mainPane
                    });
            },

            // Re-rendering the App just means refreshing the statistics -- the rest
            // of the app doesn't change.
            render: function() {
            //this.$el.find('#main-pane').html(this.serviceFormTemplate());
            }
        // Add a single todo item to the list by creating a view for it, and
        // appending its element to the `<ul>`.
   

        });
        return AppView;
    });
