define([
    'jquery', 
    'underscore', 
    'backbone',
    'text!templates/service-detailed-view.html'
    ], function($, _, Backbone, serviceDetailedTemplate){
        var ServiceDetailedView = Backbone.View.extend({

            //... is a list tag.
            mainPane: $('#main-pane'),
   
            // Cache the template function for a single item.
            template: _.template(serviceDetailedTemplate),

            initialize: function() {
                _.bindAll(this, 'render', 'showMethodCreateView',
                'showServicePane');
                this.el = this.template(this.model.toJSON());
                this.$el = $(this.el);
                this.mainPane.append(this.el);
                this.$el.modal({
                    keyboard: true, 
                    backdrop: true
                });
     
                this.$el.find('.add-method').click(this.showMethodCreateView)
                this.servicePane = this.$el.find('#service-pane');
                this.methodCreatePane = this.$el.find('#method-create-view-pane');
                this.methodCreatePane.find('.cancel-add-method').click(this.showServicePane)
            },

            // Re-render the contents of the todo item.
            render: function() {
                this.$el.modal('show');
                return this;
            },
            
            switchPane: function(pane) {
                this.$el.find('.subpane').hide()
                pane.show();
            },
            
            showMethodCreateView: function() {
                this.switchPane(this.methodCreatePane);
            },
            showServicePane: function() {
                this.switchPane(this.servicePane);
            }

        });
        return ServiceDetailedView;
    });
