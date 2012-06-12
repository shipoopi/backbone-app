/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

define([
    'jquery', 
    'underscore', 
    'backbone',
    'bootstrapModal',
    'jqueryForm',
    'collections/services',
    'models/service',
    'views/service',
    'text!templates/services-widget.html'
    ], function($, _, Backbone, bootstrapModal, jqueryForm, Services, ServiceModel, ServiceView, WidgetHtml){
        var ServicesWidget = Backbone.View.extend({
            
            appendTo: $('body'),

            // Cache the template function for a single item.
            template: _.template(WidgetHtml),

            // The DOM events specific to an item.
            events: {
              'click .add-service': 'showServiceForm'
            },

            // The TodoView listens for changes to its model, re-rendering. Since there's
            // a one-to-one correspondence between a **Todo** and a **TodoView** in this
            // app, we set a direct reference on the model for convenience.
            initialize: function(options) {
                _.bindAll(this, 'addService', 'addAllServices',
                    'render', 'showServiceForm', 'createService');
                
                if (options.appendTo) {
                    this.appendTo = options.appendTo;
                }
                
                this.el = $(WidgetHtml);
                this.appendTo.append(this.el);
                this.modal =  $('#modal-service');
                console.log(this.modal);
                
                Services.bind('add',     this.addService);
                Services.bind('all',     this.render);
                Services.bind('reset',   this.addAllServices);
                Services.fetch();
                
                this.el.find('.add-service').click(this.showServiceForm);
                this.modal.find('form').ajaxForm({success: this.createService});
            },

            showServiceForm: function() {
                this.modal.modal({keyboard: true, backdrop: true});
                this.modal.modal('show');
            },
            createService: function(response) {
                this.modal.modal('hide');
                var service = new ServiceModel($.parseJSON(response));
                Services.add(service);
            },
            
            addService: function(service) {
                var view = new ServiceView({
                    model: service
                });
                
                this.el.find('.services').append(view.render().el);
            },
    
            addAllServices: function() {
                Services.each(this.addService)
            }
        });
        return ServicesWidget;
    });

