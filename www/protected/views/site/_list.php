<div class="vevent">
    <?=CHtml::link($post->getTitle(), array('news/view', 'id' => $post->news_id), array('class' => 'summary'))?>
    <abbr class="url" title="http://m.freenews.kz/news/<?=$post->news_id?>"></abbr>
    <abbr class="dtstart" title="<?=$post->created?>"></abbr>
    <br/>
</div>