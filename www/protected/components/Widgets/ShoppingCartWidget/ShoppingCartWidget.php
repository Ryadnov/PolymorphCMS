<?php
class SoppingCartWidget extends Widget
{
    public $ajax;
    
	public function init()
    {
        parent::init();
    }
	
	public function renderContent()
	{
        if (Y::isAjaxRequest()) {
            $this->$_GET['do'];
            Y::end();
        }
        $route = isset($_GET['users']) ? urldecode($_GET['users']) : '';

        if (Y::isGuest()) {
            Yii::app()->runController('users/'.$route);
        } else {
            //cabinet
            $model = $this->module->user();
            $this->render('user-info',array(
                'model'=>$model,
                'profile'=>$model->profile,
            ));
        }
	}

    //Добавляет в корзину позицию товара в количестве $quantity. Если позиция товара уже была в корзине, то данные модели обновляются, а количество увеличивается на $quantity
    public function put()
    {
        Y::cart()->put($this->getModel(), $this->ajaxParams['quantity']);
    }

    //Обновляет в корзине позицию товара. Если позиция товара уже была в корзине, то данные модели обновляются, а количество установится в $quantity. Если позиции не было в корзине, то она добавляется в ней. Если установлено $quantity<1, то позиция удаляется из корзины
    public function updatePosition()
    {
        Y::cart()->update($this->getModel(), $this->ajaxParams['quantity']);
    }

    //Удаляет позицию из корзины
    public function removePosition()
    {
        Y::cart()->remove($this->getModel(), $this->ajaxParams['quantity']);
    }

    //Очищает корзину
    public function clear()
    {
        Y::cart()->clear();
    }

    //Возвращает позицию по ключу
    public function itemAt()
    {
        $position = Y::cart()->itemAt($this->ajaxParams('key'));
    }

    //Возвращает boolean: есть ли в корзине позиция с id=$key?
    public function contains()
    {
        $contains = Y::cart()->contains($this->ajaxParams('key'));
    }

    //Возвращает boolean: есть ли в корзине позиция с id=$key?
    public function isEmpty()
    {
        $isEmpty = Y::cart()->isEmpty();
    }
    
    //Возвращает количество позиций
    public function getCount()
    {
        $count = Y::cart()->getCount();
    }

    //Возвращает количество товаров
    public function getItemsCount()
    {
        $count = Y::cart()->getItemsCount();
    }

    //Возвращает стоимость всей корзины
    public function getCost()
    {
        $cost = Y::cart()->getCost($this->ajaxParams['withDiscount']);
    }

    //Возвращает массив позиций
    public function getPositions()
    {
        $positions = Y::cart()->getPositions();
    }

    //Возвращает стоимость позиции = стоимость одной единицы*кол-во
    public function getSumPrice()
    {
       $sumPrice = Y::cart()->itemAt($this->ajaxParams['id'])->getSumPrice();
    }

    //Возвращает кол-во единиц в позиции
    public function getQuantity()
    {
        $quantity = Y::cart()->itemAt($this->ajaxParams['id'])->getQuantity();
    }

    

    private function getModel()
    {
        list($className, $pk) = explode('_', $this->ajax['id']);
        return $className::model()->findByPk($pk);
    }

    public function update()
    {

    }
    
    public function remove()
    {
        
    }

}