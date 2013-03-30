define(
    'exampractice/js/Page/Run/Index',
    [
        'ember',
        'bootstrap'
    ],

    function (Ember, bootstrap) {
        "use strict";

        var Page = function ($document) {
           window.App = Em.Application.create();
           console.log('Exam run js');
        };

        return Page;
    }
);
