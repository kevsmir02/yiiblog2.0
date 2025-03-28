<?php
/* @var $this PostController */
/* @var $dataProvider CActiveDataProvider */

// Register the external CSS file located in 'blog/css'
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/blog/css/custom.css');

// Display Tag Cloud
echo '<div class="tag-cloud">';
echo '<h3>Tags</h3>';
foreach (Tag::model()->findAll() as $tag) {
    echo CHtml::link(CHtml::encode($tag->name), array('/post/index', 'tag' => $tag->name)) . ' ';
}
echo '</div>';
?>

<h1 class="posts-header">Posts</h1>

<div class="post-grid-container">
    <div class="post-grid">
        <?php 
        // Render the list of posts in a two-column layout
        $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider,
            'itemView'=>'_view',  // This renders the _view.php for each post
            'pager'=>array(
                'header'=>'',
                'nextPageLabel'=>'Next',
                'prevPageLabel'=>'Previous',
            ),
            'summaryText' => 'Displaying {start}-{end} of {count} results.', // Optional: Show pagination info
        ));
        ?>
    </div>
</div>

<style>
    .post-grid-container {
        display: flex;
        justify-content: center;
        width: 100%;
        padding: 20px 0;
    }

    .post-grid {
        width: 100%;
        max-width: 1200px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .posts-header {
        text-align: center;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 10px;
    }

    .posts-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 3px;
        background-color: #007bff;
    }

    .tag-cloud {
        text-align: center;
        margin-bottom: 30px;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 10px;
    }

    .tag-cloud h3 {
        margin-bottom: 15px;
    }

    .tag-cloud a {
        display: inline-block;
        margin: 0 5px 10px;
        padding: 5px 10px;
        background-color: #e9ecef;
        color: #007bff;
        text-decoration: none;
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .tag-cloud a:hover {
        background-color: #007bff;
        color: white;
    }

    @media (max-width: 768px) {
        .post-grid {
            padding: 0 15px;
        }
    }
</style>