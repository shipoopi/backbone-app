(function ($) {
    window.AppView = Backbone.View.extend({
        el: $("body")
    });
    var appview = new AppView;
    
    Todo = Backbone.Model.extend({
        defaults: {
            task: '',
            complete: false
        },
        initialize: function() {
            this.bind("change:task", function() {
                alert('Task changed');
            })
        }
    });
    
    
})(jQuery);