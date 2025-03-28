<?php
/* @var $this PostController */
/* @var $data Post */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
    <?php echo CHtml::encode($data->title); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
    <?php echo CHtml::encode($data->content); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('tags')); ?>:</b>
    <?php echo CHtml::encode($data->tags); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
    <?php echo CHtml::encode($data->status); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
    <?php echo CHtml::encode($data->create_time); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
    <?php echo CHtml::encode($data->update_time); ?>
    <br />

    <!-- Display the most recent comment -->
    <b>Recent Comment:</b>
    <?php if ($data->latestComment): ?>
        <p><?php echo CHtml::encode($data->latestComment->author); ?> - <?php echo CHtml::encode($data->latestComment->content); ?></p>
    <?php else: ?>
        <p>No comments yet.</p>
    <?php endif; ?>

</div>

