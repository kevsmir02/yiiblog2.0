<?php
/* @var $this PostController */
/* @var $model Post */
/* @var $comment Comment */  // Add this to pass the Comment model

$this->breadcrumbs=array(
    'Posts'=>array('index'),
    $model->title,
);

$this->menu=array(
    array('label'=>'List Post', 'url'=>array('index')),
    array('label'=>'Create Post', 'url'=>array('create')),
    array('label'=>'Update Post', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Delete Post', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Manage Post', 'url'=>array('admin')),
    // Buttons for publish, unpublish, and archive actions
    array('label'=>'Publish Post', 'url'=>array('publish', 'id'=>$model->id), 'visible'=>$model->status != 1),
    array('label'=>'Unpublish Post', 'url'=>array('unpublish', 'id'=>$model->id), 'visible'=>$model->status == 1),
    array('label'=>'Archive Post', 'url'=>array('archive', 'id'=>$model->id), 'visible'=>$model->status != 2),
);
?>

<h1>View Post #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'title',
        'content',
        'tags',
        'status',
        'create_time',
        'update_time',
        'author_id',
    ),
)); ?>

<!-- List of existing comments -->
<h2>Comments</h2>

<?php if($model->comments): ?>
    <ul>
        <?php foreach($model->comments as $comment): ?>
            <li>
                <strong><?php echo CHtml::encode($comment->author); ?>:</strong>
                <?php echo CHtml::encode($comment->content); ?>
                <br /><small>Posted on <?php echo CHtml::encode($comment->create_time); ?></small>
                
                <!-- Admin buttons for approving or deleting comments -->
<?php if(Yii::app()->user->isAdmin()): ?>
    <?php if($comment->status == 0): // Comment is pending approval ?>
        <?php echo CHtml::link('Approve', array('comment/approve', 'id'=>$comment->id)); ?> | 
    <?php endif; ?>
    
    <!-- Use linkButton to submit via POST -->
    <?php echo CHtml::linkButton('Delete', array(
        'submit' => array('comment/delete', 'id'=>$comment->id),
        'confirm' => 'Are you sure you want to delete this comment?',
    )); ?>
<?php endif; ?>

            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No comments yet.</p>
<?php endif; ?>

<!-- Add a comment form -->
<h3>Leave a Comment</h3>

<?php if(Yii::app()->user->isGuest): ?>
    <p>You need to <a href="<?php echo Yii::app()->createUrl('site/login'); ?>">log in</a> to leave a comment.</p>
<?php else: ?>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'comment-form',
        'enableAjaxValidation'=>true,
    )); ?>

    <div class="row">
        <?php echo $form->labelEx($comment,'content'); ?>
        <?php echo $form->textArea($comment,'content',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($comment,'content'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit Comment'); ?>
    </div>

    <?php $this->endWidget(); ?>
<?php endif; ?>
