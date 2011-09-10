<div id="design-wrapper">
    <div style="display:block; clear:both; background: #d6dde7; width:100%; height: 500px; overflow: hidden;">
        <div style="width: 200px; float: left;">
            <?php $this->widget('ExtTabs',  array(
                'tabs'=>array(
                    'Виджеты'=>array(
                        'ajax'=>Admin::url('widgets/all', array('id'=>'all-widgets'))
                    ),
                    'Пакеты'=>array(
                        'ajax'=>Admin::url('packages/all', array('id'=>'all-packages'))
                    ),
                ),
                'options'=>array(
                    'collapsible'=>false,
                    'cache'=>true,
                ),
                'id'=>'block-tabs',
                'htmlOptions' =>array('style'=>'height:495px'),
                'extHeaderHtml'=>'<div id="trash"></div>'
            )) ?>
        </div>
        <div style="margin-left: 200px;">
            <div id="widget-details" style="overflow:hidden; height: 500px; border-left: 1px solid #AAA;">
            </div>
        </div>
    </div>

</div>
