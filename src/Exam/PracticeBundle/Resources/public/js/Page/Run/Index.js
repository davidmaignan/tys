define(
        'exampractice/js/Page/Run/Index',
        [
            'ember',
            'emberData',
            'bootstrap'
        ],
        function(Ember, emberData, bootstrap) {
            "use strict";

            var Page = function($document) {
                
                //http://stackoverflow.com/questions/15601118/how-to-render-hasmany-relationship-data
                
                window.App = Em.Application.create();
                
                App.Store = DS.Store.extend({
                    revision: 12,
                    adapter: 'DS.FixtureAdapter'
                });
                  
                //Router
                App.Router.map(function(){
                    this.resource('question');
                });
                
                App.QuestionRoute = Em.Route.extend({
                    model: function () {
                        return App.Question.find();
                    }
                });
                

                //Model
                App.Question = DS.Model.extend({
                   title: DS.attr('string'),
                   answers: DS.hasMany('App.Answer')
                });
        
                App.Answer = DS.Model.extend({
                    question: DS.belongsTo('App.Question'),
                    title: DS.attr('string')
                });
                
                //Fixtures
                App.Question.FIXTURES = [{
                        id: 1,
                        title: 'Which of the following is *not* a method in java.lang.String!',
                        answers: [1,2,3,4]
                }];
            
                App.Answer.FIXTURES = [
                    { id: 1, question_id: 1, title: 'boolean isNull()' }, 
                    { id: 2, question_id: 1, title: 'String toString()' }, 
                    { id: 3, question_id: 1, title: 'int compareTo(String anotherString)' },
                    { id: 4, question_id: 1, title: 'String valueOf(char[] data)' }];
                

            };

            return Page;
        }
);
