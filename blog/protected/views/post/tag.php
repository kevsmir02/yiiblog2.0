<?php
/* @var $this PostController */
/* @var $dataProvider CActiveDataProvider */
/* @var $tag string */

$this->breadcrumbs=array(
    'Posts tagged with "'.CHtml::encode($tag).'"',
);

?>

<h1>Posts tagged with "<?php echo CHtml::encode($tag); ?>"</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view', // Reuse _view partial for listing posts
)); ?>
