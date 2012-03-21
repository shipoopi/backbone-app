(function($) {
    window.app = {}
    
    var app = window.app;
    app.cache = {}
    app.formToJson = function(form) {
        var data = form.serializeArray();
       
        var keyVals = [];
        $(data).each(function(index, input) {
            keyVals.push('"' + input.name + '"'  + ':' + '"' + input.value + '"'); 
        })
        
        var json = '{' + keyVals.join(',') + '}';
        return $.parseJSON(json);
    }
   
    app.StoryStatusController =  function (options) {
        var controller = {
            url: '/api/story-statuses',
            orderUrl: '/rpc/settings/order-story-statuses',
            view: {
                controller: null,
                noStatusMessage: $('div#div-product-settings fieldset span.alert-message'),
                listing: $('#table-story-status-list tbody'),
                form: $('#form-story-status'),
                deleteTrigger: $('.delete-story-status-trigger'),
                bindEvents: function() {
                    var controller = this.controller;
                    this.form.bind('submit', function(e) {
                        e.preventDefault();
                        var $this = $(this);  
                        controller.createStatus($this.serialize());
                    });
                
                    this.deleteTrigger.live('click', function(e){
                        e.preventDefault();
                        controller.deleteStatus($(this).data('status-id'));
                    });
                
                },
                enableOrdering: function () {
                    this.listing.find('tr').addClass('cursor-move');
                    var listing = this.listing;
                    var controller = this.controller;
                    sortable = this.listing.sortable({
                        items: 'tr',
                        cursor:'move',
                        helper:'clone',
                        opacity:0.9,
                        update: function(event, ui) {
                            
                            var order = [];
                            if (this === ui.item.parent()[0]) {
                                
                                listing.find('tr').each(function(index,status){
                                    order.push($(status).attr('id'))
                                })                                
                                
                                $.ajax(controller.orderUrl, {
                                    type : 'post',
                                    data :  {
                                        product: controller.data.product,
                                        order:order
                                    }
                                })
                            }
                    
                        }
                    });  
                },
                addStatus: function(storyStatus) {
                    this.noStatusMessage.hide();
                    // console.log(storyStatus);
                    $row = $('<tr id="'+ storyStatus.id +'"><td>' + storyStatus.value + '</td><td>' 
                        + storyStatus.type + '</td><td class="controls">'
                        + '<a data-status-id="' +  storyStatus.id + '" class="delete-story-status-trigger"'
                        + 'href="javascript:void(0)">'
                        + '<span class="ss_sprite ss_delete">&nbsp;</span>'
                        + '</a>'
                        + '</td></tr>');
                    this.listing.append($row);
                },
                removeStatus: function (id) {
                    this.listing.find('tr#' + id).remove();
                    if (this.listing.find('tr').length == 0) {
                        this.noStatusMessage.show();
                    }
                    
                }
            },
            responseCache: {},
            data: {
                statuses: [],
                product: null
            },
            init: function () {
                this.view.controller = this;
                this.view.bindEvents();
                this.view.enableOrdering();
            },
            createStatus: function (data) {
                var view = this.view;
                var statuses = this.data.statuses;
                $.ajax(this.url, {
                    type : 'post',
                    data : data,
                    error: function() {
                    },
                    success: function (response) {
                        statuses.push(response.storyStatus);
                        view.addStatus(response.storyStatus);
                    }
                })
            },
            deleteStatus: function(id) {
                var url = this.url + '/' + id;
                var statuses = this.data.statuses;
                var view = this.view;
                var controller = this;
                console.log(this.data.product);
                $.ajax(url, {
                    type : 'delete',
                    contentType: 'application/json',
                    data : JSON.stringify({
                        product: this.data.product
                    }),
                    error: function() {
                    },
                    success: function (response) {
                        
                        //remove the element @todo this is not working
                        this.data.statuses = $.grep(statuses, function(value) {
                            if (!value) return false;
                            return value.id != id;
                        });     
                        console.log(statuses);
                        view.removeStatus(id);
                    }
                })
            },
            updateStatus: function(id) {
            
            }
        }
        
        controller.data = $.extend({}, controller.data, options);
        
        return controller; 
    }
    
    
    
})(jQuery)
