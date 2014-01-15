<?php if(empty($active)): ?>
<div class="page-header">
  <h1>Нет доступного опроса</h1>
</div>
<?php else: ?>
<div class="page-header">
  <h1><?php echo $active['title'] ?></h1>
</div>
<?php endif ?>
