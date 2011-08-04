<div class="index_content">
    <?if (!empty($posts)) {
        foreach ($posts as $key => $val) {
            $this->renderPartial('_list',array(
                'post'=>$val,
            )); 
         }
    }?>
</div>
<div class="refresh">
   <a href="<?=Yii::app()->request->url?>"><?=Yii::t('interface', 'refresh')?></a>
</div>
 
 
 <?php /*$this->widget('CLinkPager',array(
    'pages'=>$pages, 
    'maxButtonCount' => 10, // максимальное вол-ко кнопок <- 2..2..2..4..5 ->
    'header' => '<b>Перейти к странице:</b><br><br>', // заголовок над листалкой
)); 
*/?>

