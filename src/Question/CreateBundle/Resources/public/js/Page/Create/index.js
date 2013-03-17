define(
    'questioncreate/js/Page/Create/Index',
    [
        
    ],

    function () {
        "use strict";
        
        /**
         * Constructor
         * 
         * @param {jQuery} $document
         */
        var Page = function ($document) {
            
            this.context = $document;
            var that = this;
                      
            var $collectionHolder = this.context.find('div.answers');

            // setup an "add a tag" link
            var $addAnswerLink = $('<div style="text-align: right;"><a href="#" class="add_answer_link btn btn-success btn-mini">Add another answer</a></div>');
            var $newLinkDiv = $('<div class="answer"></div>').append($addAnswerLink);

            // setup an "add a tag" link
            $collectionHolder.append($newLinkDiv);
            
            $addAnswerLink.on('click', function(e) {
                // prevent the link from creating a "#" on the URL
                e.preventDefault();

                // add a new tag form (see next code block)
                addAnswerForm($collectionHolder, $newLinkDiv);
            });
            
            //Remove button
            
            var btnsDanger = this.context.find('.btn-danger');
            
            if(btnsDanger.length > 0){
                $(btnsDanger).each(function () {
                    $(this).on('click', function (e) {
                        $(this).closest('.answer').remove();
                    });
                });
            }
        };
        
        function addAnswerForm(collectionHolder, $newLinkLi) {
            // Get the data-prototype we explained earlier
            var prototype = collectionHolder.attr('data-prototype');

            // Replace '$$name$$' in the prototype's HTML to
            // instead be a number based on the current collection's length.
            var newForm = prototype.replace(/__name__/g, collectionHolder.children().length-1);
    

            // Display the form in the page in an li, before the "Add a tag" link li
            var $newFormLi = $('<div class="answer"></div>').append(newForm);
            $newLinkLi.before($newFormLi);
    
            //
            // Add delete link to the new form
            addAnswerFormDeleteLink($newFormLi);
        }

        function addAnswerFormDeleteLink($tagFormLi) {
            var $removeFormA = $('<a href="#" class="btn btn-mini btn-danger">delete this answer</a>');
            $tagFormLi.append($removeFormA);

            $removeFormA.on('click', function(e) {
                // prevent the link from creating a "#" on the URL
                e.preventDefault();

                // remove the li for the tag form
                $tagFormLi.remove();
            });
        }

        return Page;
    }
);
