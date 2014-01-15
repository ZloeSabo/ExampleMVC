<?php if(!empty($surveys['active'])): ?>
<div class="panel panel-primary">
    <div class="panel-heading">Активный опрос</div>
    <div class="panel-body">
        <a href="#"><?php echo $surveys['active'][0]['title'] ?></a>
    </div>
</div>  
<?php endif ?>

<?php if(!empty($surveys['drafts'])): ?>
<div class="panel panel-primary">
    <div class="panel-heading">Черновики</div>
    <ul class="list-group">
        <?php foreach($surveys['drafts'] as $draft): ?>
        <li class="list-group-item">
            <a href="#"><?php echo $draft['title'] ?></a>
            <div class="pull-right">
                <a href="<?php echo $helper['path']->path('survey_edit', array('id' => $draft['id'])) ?>">
                    <span class="glyphicon glyphicon-edit"></span>
                </a>
                <a href="#">
                    <span class="glyphicon glyphicon-ok"></span>
                </a>
                <a href="#">
                    <span class="glyphicon glyphicon-remove"></span>
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
        <li class="list-group-item">
            <a href="#"><?php echo $closed['title'] ?></a>
        </li>
        <?php endforeach ?>
    </ul>
</div>
<?php endif ?> 
