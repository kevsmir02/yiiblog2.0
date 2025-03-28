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

// Add custom CSS for enhanced styling
Yii::app()->clientScript->registerCss('admin-styles', '
    .admin-container {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .search-section {
        background-color: #ffffff;
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #e2e6ea;
    }
    .search-button {
        margin-bottom: 15px;
        display: inline-block;
        padding: 8px 15px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }
    .search-button:hover {
        background-color: #0056b3;
    }
    .grid-view table.items {
        border-radius: 8px;
        overflow: hidden;
    }
    .grid-view table.items th {
        background-color: #007bff;
        color: white;
        padding: 12px 15px;
    }
    .grid-view table.items tr:nth-child(even) {
        background-color: #f2f4f6;
    }
    .grid-view table.items tr:hover {
        background-color: #e9ecef;
    }
');
?>

<div class="admin-container">
    <h1 class="mb-4">Manage Posts</h1>

    <div class="search-section">
        <p class="mb-3">
            You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
            or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
        </p>

        <?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
        <div class="search-form" style="display:none">
            <?php $this->renderPartial('_search',array(
                'model'=>$model,
            )); ?>
        </div>
    </div>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'post-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'itemsCssClass' => 'table table-striped table-bordered',
        'columns' => array(
            array(
                'name' => 'id',
                'headerHtmlOptions' => array('style' => 'width: 60px;'),
            ),
            'title',
            array(
                'name' => 'content',
                'value' => 'substr($data->content, 0, 100) . "..."',
            ),
            'tags',
            array(
                'name' => 'status',
                'value' => '($data->status == 1) ? "Published" : (($data->status == 0) ? "Unpublished" : "Archived")',
                'filter' => array(
                    1 => 'Published',
                    0 => 'Unpublished',
                    2 => 'Archived'
                ),
                'htmlOptions' => array(
                    'style' => 'text-align: center;',
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
        'pager' => array(
            'header' => '',
            'cssFile' => false,
            'selectedPageCssClass' => 'active',
            'previousPageCssClass' => 'prev',
            'nextPageCssClass' => 'next',
            'hiddenPageCssClass' => 'disabled',
            'htmlOptions' => array(
                'class' => 'pagination',
            ),
        ),
    ));
    ?>
</div>