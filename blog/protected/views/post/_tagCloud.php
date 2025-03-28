<div class="tag-cloud">
    <?php
    $tags = Post::getTagCloud(); // Get the tag counts
    foreach ($tags as $tag => $frequency) {
        $fontSize = 10 + ($frequency * 2); // Adjust the font size based on the frequency
        echo CHtml::link(
            CHtml::encode($tag), // Encode the tag name for display
            array('post/tag', 'tag' => CHtml::encode($tag)), // Make the tag clickable to show posts with this tag
            array('style' => "font-size:{$fontSize}px; margin-right:10px;") // Style each tag with variable font size
        );
    }
    ?>
</div>
