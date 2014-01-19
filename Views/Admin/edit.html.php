<div class="survey-container" >
    <form method="post" id="survey-form" role="form" data-id="<?php echo $survey['id'] ?>">
        <div class="form-group">
            <h4><label for="survey-title">Название опроса</label></h4>
            <input name="survey-title" 
                id="survey-title" 
                class="form-control" 
                placeholder="Введите название опроса" 
                required="required" 
                aria-required="true" 
                type="text" 
                value="<?php echo $survey['title'] ?>">
        </div>
        <hr/>
        <div class="form-group">
            <h4 for="survey-questions">Вопросы</h4>
        <hr/>

            <div class="form survey-questions-form">
                <?php foreach($questions as $question): ?>
                <div class="question" data-id="<?php echo $question['id'] ?>">
                    <input class="form-control question-title" placeholder="Описание вопроса" required="required" type="text" value="<?php echo $question['title'] ?>">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" <?php if($question['required'] == '1') echo 'checked="checked"'; ?>>Обязательный
                        </label>
                    </div>
                    <div class="radio">
                    <label>
                        <input type="radio" name="answercount<?php echo $question['id']; ?>" value="0" <?php if($question['type'] == '0') echo 'checked="checked"' ?>>
                        Один ответ
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                        <input type="radio" name="answercount<?php echo $question['id']; ?>" value="1" <?php if($question['type'] == '1') echo 'checked="checked"' ?>>
                        Несколько ответов
                        </label>
                    </div>
                    <label>
                        Ответы
                    </label>
                    <div class="survey-question-answers">
                        <?php foreach($question['answers'] as $answer): ?>
                        <input class="form-control" 
                            required="required" 
                            aria-required="true" 
                            type="text" 
                            placeholder="Введите ответ" 
                            value="<?php echo $answer['description'] ?>"
                            data-id="<?php echo $answer['id'] ?>">
                        <?php endforeach ?>
                        <label>
                            <span class="glyphicon glyphicon-plus question-answer-add"></span>
                        </label>
                    </div>
                    <hr/>
                </div>
                <?php endforeach ?>
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
            <input type="radio" name="answercount" value="0" checked>
            Один ответ
            </label>
        </div>
        <div class="radio">
            <label>
            <input type="radio" name="answercount" value="1">
            Несколько ответов
            </label>
        </div>
        <label>
            Ответы
        </label>
        <div class="survey-question-answers">
            <input class="form-control" required="required" aria-required="true" type="text" placeholder="Введите ответ">
            <input class="form-control" required="required" aria-required="true" type="text" placeholder="Введите ответ">
            <label>
                <span class="glyphicon glyphicon-plus question-answer-add"></span>
            </label>
        </div>
        <hr/>
    </div>
</div>

