<?php if(!empty($surveys['active'])): ?>
<div class="panel panel-primary">
    <div class="panel-heading">Активный опрос</div>
    <ul class="list-group">
        <li class="list-group-item" data-id="<?php echo $surveys['active'][0]['id'] ?>">
            <a href="#"><?php echo $surveys['active'][0]['title'] ?></a>
            <div class="pull-right">
                <a href="#">
                    <span class="glyphicon glyphicon-lock survey-close"></span>
                </a>
                <a href="#">
                    <span class="glyphicon glyphicon-remove survey-remove"></span>
                </a>
            </div>
        </li>
    </ul>
</div>  
<?php endif ?>

<?php if(!empty($surveys['drafts'])): ?>
<div class="panel panel-primary">
    <div class="panel-heading">Черновики</div>
    <ul class="list-group">
        <?php foreach($surveys['drafts'] as $draft): ?>
        <li class="list-group-item" data-id="<?php echo $draft['id'] ?>">
            <a href="<?php echo $helper['path']->path('survey_edit', array('id' => $draft['id'])) ?>"><?php echo $draft['title'] ?></a>
            <div class="pull-right">
                <?php if(empty($surveys['active'])): ?>
                <a href="#">
                    <span class="glyphicon glyphicon-ok survey-activate"></span>
                </a>
                <?php endif ?>
                <a href="#">
                    <span class="glyphicon glyphicon-remove survey-remove"></span>
                </a>
            </div>
        </li>
        <?php endforeach ?>
    </ul>
</div>
<?php endif ?> 

<?php if(!empty($surveys['closed'])): ?>
<div class="panel panel-primary">
    <div class="panel-heading">Закрытые</div>
    <ul class="list-group">
        <?php foreach($surveys['closed'] as $closed): ?>
        <li class="list-group-item" data-id="<?php echo $closed['id'] ?>">
            <a href="#"><?php echo $closed['title'] ?></a>
            <div class="pull-right">
                <?php if(empty($surveys['active'])): ?>
                <a href="#">
                    <span class="glyphicon glyphicon-ok survey-activate"></span>
                </a>
                <?php endif ?>
                <a href="#">
                    <span class="glyphicon glyphicon-remove survey-remove"></span>
                </a>
            </div>
        </li>
        <?php endforeach ?>
    </ul>
</div>
<?php endif ?> 
