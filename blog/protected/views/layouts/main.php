<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="en">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

    <!-- Custom Navigation Styles -->
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        #page {
            width: 100%;
            margin: 0;
            padding: 0;
        }
        .navbar {
            width: 100%;
            background-color: #ffffff;
            border-bottom: 1px solid #e7e7e9;
            padding: 15px 0;
            box-sizing: border-box;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .navbar-content {
            width: 100%;
            max-width: 1200px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            margin: 0 auto;
        }
        .navbar-brand {
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
            text-decoration: none;
        }
        .navbar-nav {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            align-items: center;
        }
        .navbar-nav li {
            margin: 0 15px;
        }
        .navbar-nav a {
            color: #495057;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .navbar-nav a:hover {
            color: #007bff;
        }
        .navbar-nav .active a {
            font-weight: bold;
            color: #007bff;
        }
        .cta-button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .cta-button:hover {
            background-color: #0056b3;
        }
        .user-actions {
            display: flex;
            align-items: center;
        }
        .user-welcome {
            margin-right: 15px;
            color: #495057;
        }

		#content {
    max-width: 800px; /* Adjust as needed */
    margin: 0 auto;
    padding: 20px;
}

.post-container {
    max-width: 800px; /* Match content width */
    margin: 0 auto; /* Center it */
    padding: 15px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
}

    </style>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div id="page">
    <!-- Header -->
    <div id="header">
        <nav class="navbar">
            <div class="navbar-content">
                <div class="navbar-brand">
                    <?php echo CHtml::link(CHtml::encode(Yii::app()->name), Yii::app()->homeUrl); ?>
                </div>
                
                <?php $this->widget('zii.widgets.CMenu', array(
                    'items'=>array(
                        array(
                            'label'=>'Home', 
                            'url'=>array('/post/index'),
                            'active'=>Yii::app()->controller->id == 'post' && Yii::app()->controller->action->id == 'index'
                        ),
                        array(
                            'label'=>'Manage Posts', 
                            'url'=>array('/post/admin'), 
                            'visible'=>!Yii::app()->user->isGuest
                        ),
                        array(
                            'label'=>'Comments', 
                            'url'=>array('/comment/index'), 
                            'visible'=>!Yii::app()->user->isGuest
                        ),
                    ),
                    'htmlOptions' => array('class' => 'navbar-nav'),
                    'itemCssClass' => '', 
                    'activeCssClass' => 'active'
                )); ?>

                <div class="user-actions">
                    <?php if(!Yii::app()->user->isGuest): ?>
                        <span class="user-welcome">Welcome, <?php echo CHtml::encode(Yii::app()->user->name); ?></span>
                        <?php echo CHtml::link('Logout', array('/site/logout'), array('class' => 'cta-button')); ?>
                    <?php else: ?>
                        <?php echo CHtml::link('Login', array('/site/login'), array('class' => 'cta-button')); ?>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </div>

    <!-- Rest of the template remains the same -->
    <!-- Breadcrumbs -->
    <?php if(isset($this->breadcrumbs)): ?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links' => $this->breadcrumbs,
        )); ?>
    <?php endif ?>

    <!-- Page Content -->
    <div id="content">
        <?php echo $content; ?>
    </div>

    <div class="clear"></div>
</div>

</body>
</html>