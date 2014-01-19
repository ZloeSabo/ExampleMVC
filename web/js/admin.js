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
                .data('id', -(questionCount ? questionCount.length + 1 : 1))
                .appendTo($questionsForm)
                .find('input[type="radio"]').attr('name', 'answercount-' + (questionCount ? questionCount.length + 1 : 1)).end()
                // .find('form-control')
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
                    'required': $(this).find('input[type="checkbox"]').attr('checked') == 'checked' ? 1 : 0,
                    'type' : $(this).find('input[type="radio"]:checked').val(),
                    'answers' : []
                };

                $(this).find('.survey-question-answers input').each(function() {
                    var id =  $(this).data('id');
                    var answer = {
                        'id' : id ? id : -(question['answers'].length + 1),
                        'description' : $(this).val()
                    };

                    question['answers'].push(answer);
                });

                surveyData['questions'].push(question);
            });

            $.ajax({
                'url' : window.location.pathname,
                'data': surveyData,
                'type': 'POST',
                'dataType': 'json'
            })
            .done(function(data) {
                window.location.pathname = data.redirect;
            })
            .fail(function(data) {
                $('#survey-form')
                    .find('.alert').remove().end()
                    .find('button[type="submit"]').after('<div class="alert alert-danger">' + data.responseJSON.msg + '</div>')
                ;
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
                    .attr('name', 'answer' + (inputs.length + 1))
                    .val('')
                    // .data('id', -(inputs.length + 1))
                    .insertAfter(inputs[inputs.length-1]);
            })
        .end()

    ;

    $(document)
        .on('click', '.survey-remove', function(ev) {
            ev.preventDefault();
            var $parent = $(this).parents('li.list-group-item:first');
            var id = $parent.data('id');
            $.ajax({
                'url': routes.survey_delete.replace('id', id),
                'data': {'id': id},
                'type': 'POST'
            })
            .done(function(data) {
                if(data.result) {
                    $parent.remove();
                }
            });
            ;
        })
        .on('click', '.survey-activate', function(ev) {
            ev.preventDefault();
            var $parent = $(this).parents('li.list-group-item:first');
            var id = $parent.data('id');
            $.ajax({
                'url': routes.survey_status.replace('id', id).replace('newstatus', 'active'),
                'data': {'id': id},
                'type': 'POST'
            })
            .done(function(data) {
                if(data.result) {
                    window.location.reload();
                }
            });
            ;
        })
        //TODO вынести в отдельную функцию
        .on('click', '.survey-close', function(ev) {
            ev.preventDefault();
            var $parent = $(this).parents('li.list-group-item:first');
            var id = $parent.data('id');
            $.ajax({
                'url': routes.survey_status.replace('id', id).replace('newstatus', 'closed'),
                'data': {'id': id},
                'type': 'POST'
            })
            .done(function(data) {
                if(data.result) {
                    window.location.reload();
                }
            });
            ;
        })
    ;
});
