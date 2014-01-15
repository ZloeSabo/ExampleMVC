$(function() {
    var $questionTemplate = $('.template-question');
    var $questionsForm = $('.survey-questions-form');

    var prepareData = function() {

    };

    $('#survey-form')
        .on('click', '#btn-question-add', function(ev) {
            ev.preventDefault();
            // var containerDiv = $(document.createElement('div'));
            var questionCount = $(this).parents('#survey-form').find('.question');

            $questionTemplate
                .clone()
                .attr('class', 'question')
                .appendTo($questionsForm)
                .find('input[type="radio"]').attr('name', 'answercount' + (questionCount ? questionCount.length + 1 : 1))
            ;
        })
        .on('submit', function(ev) {
            ev.preventDefault();
            var $surveyForm = $('#survey-form');
            var surveyData = {
                'id' : $surveyForm.data('id'),
                'title' : $surveyForm.find('#survey-title').val(),
                'questions' : []
            };
            $surveyForm.find('.survey-questions-form .question').each(function() {
                var question = {
                    'id': $(this).data('id'),
                    'title': $(this).find('.question-title').val(),
                    'required': $(this).find('input[type="checkbox"]').attr('checked') == 'checked' ? true : false,
                    'type' : $(this).find('input[type="radio"]:checked').val(),
                    'answers' : []
                };

                $(this).find('.survey-question-answers input').each(function() {
                    var answer = {
                        'id' : $(this).data('id'),
                        'description' : $(this).val()
                    };

                    question['answers'].push(answer);
                });

                surveyData['questions'].push(question);
            });

            console.log(surveyData);

            $.ajax({
                'url' : window.location.pathname,
                'data': surveyData,
                'type': 'POST',
                'dataType': 'json'
            })
            .done(function(data) {
                console.log('success', data);
            })
            .fail(function(data) {
                console.log('fail', data);
            })
            ;
        })
        .find('.survey-questions-form')
            .on('click', '.question-answer-add', function(ev) {
                ev.preventDefault();
                var $parent = $(this).parents('.survey-question-answers:first')
                var inputs = $parent.find('input.form-control');
                $(inputs[inputs.length-1])
                    .clone()
                    .attr('name', 'answer' + inputs.length + 1)
                    .insertAfter(inputs[inputs.length-1]);
            })
        .end()

    ;
});
