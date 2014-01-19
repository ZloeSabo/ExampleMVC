<!DOCTYPE html>
<html>
    <head>
        <title><?php $title ?></title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/css/admin.css">


    </head>
    <body>
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading">Панель администрирования</div>
                <div class="panel-body">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
        <script src="//code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript">
            var routes = {
                'survey_delete': '<?php echo $helper['path']->path('survey_delete') ?>',
                'survey_status': '<?php echo $helper['path']->path('survey_status') ?>'
            };
        </script>
        <script src="/js/admin.js"></script>
    </body>
</html>
