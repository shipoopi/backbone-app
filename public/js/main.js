// Author: Thomas Davis <thomasalwyndavis@gmail.com>
// Filename: main.js

// Require.js allows us to configure shortcut alias
require.config({
    paths: {
        jquery: 'libs/jquery/jquery-min',
        jqueryUi: 'libs/jquery/jquery-ui-min',
        bootstrap: 'libs/bootstrap/bootstrap-min',
        underscore: 'libs/underscore/underscore-min',
        backbone: 'libs/backbone/backbone-optamd3-min',
        text: 'libs/require/text',
        bootstrapModal: 'libs/bootstrap/bootstrap-min',
        jqueryForm: 'libs/jquery/plugins/jquery.form'
    }

});

require(['views/app'], function(AppView){
    var app_view = new AppView;
});
