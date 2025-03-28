<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Posts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Post', 'url'=>array('index')),
	array('label'=>'Create Post', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#post-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Posts</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'post-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        'title',
        'content',
        'tags',
        array(
            'name' => 'status',
            'value' => '($data->status == 1) ? "Published" : (($data->status == 0) ? "Unpublished" : "Archived")',
            'filter' => array(
                1 => 'Published',
                0 => 'Unpublished',
                2 => 'Archived'
            ),
        ),
        'create_time',
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}{update}{delete}{publish}{unpublish}{archive}', // Custom buttons
            'buttons' => array(
                'publish' => array(
                    'label' => 'Publish',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/publish.png',
                    'url' => 'Yii::app()->createUrl("post/publish", array("id"=>$data->id))',
                    'visible' => '$data->status != 1',
                ),
                'unpublish' => array(
                    'label' => 'Unpublish',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/unpublish.png',
                    'url' => 'Yii::app()->createUrl("post/unpublish", array("id"=>$data->id))',
                    'visible' => '$data->status == 1',
                ),
                'archive' => array(
                    'label' => 'Archive',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/archive.png',
                    'url' => 'Yii::app()->createUrl("post/archive", array("id"=>$data->id))',
                    'visible' => '$data->status != 2',
                ),
            ),
        ),
    ),
));
?>

