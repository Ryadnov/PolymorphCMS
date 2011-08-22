<?php
class BlocksController extends AdminBaseController
{
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($pk = null, $scenario = '')
	{
        $m = new TemplateBlock($scenario);
		return $m->findByPk($pk);
	}
	
	public function actionAdd()
	{
        if (isset($_POST['alias']) && isset($_POST['catPk'])) {
            $model = $this->loadModel();
            $model->category_id = $_POST['catPk'];
            $model->alias = $_POST['alias'];
            $model->save();

            $this->renderPartial('item', array('model'=>$model));
            
        } else {
            echo CHtml::beginForm();
            echo CHtml::hiddenField('catPk', $_GET['catPk']);
            echo '<p>Название</p>';
            echo CHtml::textField('alias');
            echo CHtml::submitButton('Готово');
            echo CHtml::endForm();
        }
	}
	
	public function actionSaveWidgetsPosition()
	{
		Y::dump($_POST);
	}

	public function actionDetails($pk)
	{
		$block = $this->loadModel($pk);
		
		$res = '';
		foreach($block->widgets as $widget)
            $res .= $this->renderPartial('/widgets/item', array('model'=>$widget), true);
		
        echo CHtml::tag('ul', array(), $res);
        echo Admin::link('Добавить виджеты', 'blocks/addWidgets', array('blockPk'=>$block->pk), array('class'=>'add-widegts'));
	}

    public function actionAddWidgets($blockPk)
    {
        if (isset($_POST['newWidgets'])) {
            $widgets = array();
            foreach ($_POST['newWidgets'] as $pk) {
                $widgets[] = TemplateWidget::model()->findByPk($pk);
            }
            $block = TemplateBlock::model()->findByPk($blockPk);
            $block->widgets = CMap::mergeArray($block->widgets, $widgets);
            
            $this->renderPartial('item', array('models'=>$widgets));
        } else {
            //make list of widgets
            $widgets = TemplateWidget::model()->notInBlock($blockPk)->findAll();
            $list = CHtml::listData($widgets, 'pk', 'title');

            $this->renderPartial("/widgets/widgetChangeForm", array('widgets'=>$list), false, true);
        }
    }

    public function actionAll($catPk)
    {
        $cat = Category::model()->findByPk($catPk);

        $res = array();
        foreach ($cat->allBlocks as $item) {
            $children = array();
            $block = $item['block'];
            foreach ($block->widgets as $widget) {
                $children[] = array(
                    'text'=>$widget->detailsLink,
                    'htmlOptions'=>array(
                        'id'=>"widgets_".$widget->pk,
                        'class'=>'widget-link'
                    )
                );
            }

            $res[] = array(
                'text'=>'<span>'.$block->alias.'</span>'.$this->renderPartial('block_btns', array('item'=>$item, 'cat'=>$cat), true),
                'children'=>$children,
                'htmlOptions'=>array(
                    'id'=>"blocks_".$block->pk,
                    'class'=> $item['isOwn'] ? 'own' : 'parents'
                )
            );
        }
        
        $this->renderPartial('all', array('blocks'=> $res, 'cat'=> $cat), false, true);
    }

    public function actionMakeOwn($catPk, $blockPk)
    {
        $cat = Category::model()->findByPk($catPk);
        $block = TemplateBlock::model()->findByPk($blockPk);
        $newBlock = $block->copy();

        $db = Yii::app()->db;
        $transaction = $db->beginTransaction();
        try {
            //create new Block
            $newBlock->category_id = null;
            $cat->blocks = array($newBlock);
            $cat->save();

            //Create copies of components
            $widgets = $block->widgets;
            foreach ($widgets as $widget) {
                $widget->pk = null;
                $widget->block_id = null;
            }
            //save components
            $newBlock->widgets = $widgets;

            $newBlock->save();

            $transaction->commit();
            echo 'ok';
        } catch(CException $e) {
            $transaction->rollBack();
            echo $e->__toString();
        }
    }
}