<?php
/* @var $this PostController */
/* @var $data Post */
?>

<div class="post-container">
    <div class="view">
        <div class="post-header">
            <h2><?php echo CHtml::encode($data->title); ?></h2>
        </div>

        <div class="post-meta">
            <p><strong>ID:</strong> <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?></p>
            <p><strong>Created At:</strong> <?php echo CHtml::encode(date('M d, Y', strtotime($data->create_time))); ?></p>
            <p><strong>Updated At:</strong> <?php echo CHtml::encode(date('M d, Y', strtotime($data->update_time))); ?></p>
            <p><strong>Status:</strong> <?php echo $data->status == 1 ? 'Published' : 'Draft'; ?></p>
        </div>

        <div class="post-content">
            <p><?php echo CHtml::encode($data->content); ?></p>
        </div>

        <div class="post-tags">
            <strong>Tags:</strong>
            <?php
            $tags = explode(',', $data->tags);
            foreach ($tags as $tag) {
                $trimmedTag = trim($tag);
                echo CHtml::link(CHtml::encode($trimmedTag), array('post/index', 'tag' => $trimmedTag), array('class' => 'tag-pill')) . ' ';
            }
            ?>
        </div>

        <div class="post-comment">
            <strong>Recent Comment:</strong>
            <?php if ($data->latestComment): ?>
                <p><?php echo CHtml::encode($data->latestComment->author); ?> - <?php echo CHtml::encode($data->latestComment->content); ?></p>
            <?php else: ?>
                <p>No comments yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- CSS Styles for post card layout -->
<style>
    .post-container {
        display: flex;
        justify-content: center;
        width: 100%;
        padding: 20px 0;
    }

    .view {
        width: 100%;
        max-width: 800px;
        border: 1px solid #e9ecef;
        padding: 25px;
        margin-bottom: 25px;
        border-radius: 12px;
        background-color: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .view:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .post-header h2 {
        color: #333;
        margin-bottom: 15px;
        font-size: 1.8em;
        border-bottom: 2px solid #007BFF;
        padding-bottom: 10px;
        text-align: center;
    }

    .post-meta {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
        font-size: 0.9em;
        color: #6c757d;
        margin-bottom: 20px;
        border-left: 4px solid #007BFF;
        padding-left: 15px;
        text-align: center;
    }

    .post-meta p {
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .post-content {
        font-size: 1em;
        line-height: 1.6;
        color: #212529;
        margin-bottom: 20px;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
        text-align: center;
    }

    .post-tags {
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .post-tags strong {
        margin-bottom: 10px;
    }

    .tag-pill-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .tag-pill {
        display: inline-block;
        background-color: #e9ecef;
        color: #007BFF;
        padding: 5px 12px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 0.8em;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .tag-pill:hover {
        background-color: #007BFF;
        color: white;
    }

    .post-comment {
        font-size: 0.9em;
        background-color: #f1f3f5;
        padding: 15px;
        border-radius: 8px;
        border-left: 3px solid #6c757d;
        text-align: center;
    }

    .post-comment p {
        margin: 0;
        color: #495057;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .view {
            padding: 15px;
            margin: 0 15px;
        }

        .post-header h2 {
            font-size: 1.4em;
        }

        .post-meta {
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
    }
</style>