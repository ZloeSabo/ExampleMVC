<div class="survey-container" >
    <form method="post" id="survey-form" role="form" data-id="<?php echo $survey['id']; ?>">
        <div class="form-group">
            <h4><label for="survey-title">Название опроса</label></h4>
            <input name="survey-title" id="survey-title" class="form-control" placeholder="Введите название опроса" required="required" aria-required="true" type="text" value="<?php echo $survey['title']; ?>">
        </div>
        <hr/>
        <div class="form-group">
            <h4 for="survey-questions">Вопросы</h4>
        <hr/>

            <div class="form survey-questions-form">

            </div>

            <div class="form-group">
                <button type="button" class="btn btn-info" id="btn-question-add">Добавить вопрос</button>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default">Сохранить</button>
        </div>
    </form>

    <div class="template-question hidden">
        <input class="form-control question-title" placeholder="Описание вопроса" required="required" type="text">
        <div class="checkbox">
            <label>
                <input type="checkbox">Обязательный
            </label>
        </div>
        <div class="radio">
        <label>
            <input type="radio" name="answercount" value="single" checked>
            Один ответ
            </label>
        </div>
        <div class="radio">
            <label>
            <input type="radio" name="answercount" value="multiple">
            Несколько ответов
            </label>
        </div>
        <label>
            Ответы
        </label>
        <div class="survey-question-answers">
            <input name="answer1" class="form-control" required="required" aria-required="true" type="text" placeholder="Введите ответ">
            <input name="answer2" class="form-control" required="required" aria-required="true" type="text" placeholder="Введите ответ">
            <label>
                <span class="glyphicon glyphicon-plus question-answer-add"></span>
            </label>
        </div>
        <hr/>
    </div>
</div>

