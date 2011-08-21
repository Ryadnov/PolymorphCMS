<?php foreach ($existWidgets as $widget) { ?>
    <div><?php echo isset($widget->settings['title']) ? $widget->settings['title'] : $widget->title ?></div>
<?php } ?>

