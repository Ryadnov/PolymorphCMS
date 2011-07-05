<?php
class ListAction extends CAction {
    /**
    * @var string Атрибут модели для фильтра поиска записей.
    */
	public $findAttr = NULL;
    /**
    * @var string Имя параметра $_GET для фильтра поиска записей.
    */
    public $findParam = NULL;
    /**
    * @var int Количество записей на странице.
    */
    public $postsPerPage = 10;
    /**
	* @var string Имя представления.
    */
    public $view = 'list';
    /**
    * @var CDBCriteria Критерий поиска.
    */
    public $criteria = NULL;
    /**
    * @var array Параметры представления.
    * Индекс элемента массива будет использован как имя переменной передаваемой в представление,
    * а сам элемент либо имя метода, либо callback-функция возвращающая значение переменной.
    */
    public $data = array();
    /**
    * @var CActiveRecord.
    */
	public $model = NULL;

    /**
    * Рендер представления.
    */
	public function run() {
        // Проверяем обязательный параметр
		if (is_null($this->model)) {
            throw new CException(Yii::t('yii', 'Property "{class}.{property}" is not defined.',
        	array('{class}' => get_class($this), '{property}' => 'model')));
        }
        $data = array();
        // Обходим массив параметров представления и получаем значения параметра
		foreach ($this->data as $key => $var) {
            // Если элемент массива является валидной callback-функцией выполняем функция, получая значение.
			if (is_string($key) && is_callable($var)) {
            	$data[$key] = call_user_func($var, $this);
            }
            // Если элемент строка, проверяем наличие метода в данном классе.
			elseif (is_string($var) && method_exists($this, 'get' . ucfirst($var))) {
				$data[is_string($key) ? $key : $var] = call_user_func(array(
                    $this,
                	'get' . ucfirst($var)
            	));
        	}
        }
    	$this->getController()->render($this->view, $data);
    }
    /**
    * Устанавливаем параметры представления.
    *
    * @param array $data
    */
	public function setData(array $data) {
    	$this->data = is_array($data) ? $data : array();
    }
	/**
    * Установка имени атрибута модели.
    *
    * @param string $findAttr
    */
	protected function setFindAttr(string $findAttr) {
        $findAttr = trim($findAttr);
    	$this->findAttr = empty($findAttr) ? NULL : $findAttr;
	}
    /**
    * Установка параметра.
    *
    * @param string $findParam
    */
	protected function setFindParam(string $findParam) {
        $findParam = trim($findParam);
    	$this->findParam = empty($findParam) ? NULL : $findParam;
	}
    /**
    * Получаем значение для фильтра записей.
    *
    * @return string
    */
	public function getFindString() {
    	return Yii::app()->request->getParam($this->findParam, NULL);
    }
    /**
    * Возвращает критерий поиска.
    *
    * @return CDbCriteria
    */
	public function getCriteria() {
        if (is_null($this->criteria)) $this->criteria = new CDbCriteria;
    	return $this->criteria;
    }
	/**
    * Получаем модели.
    *
    * @return CActiveRecord
    */
	/*public function getModel() {
    	return is_object($this->model) ? $this->model : NULL;
    }*/
    /**
    * Добавляет условие поиска.
    */
	public function addCondition() {
        $findString = $this->getFindString();
		if (!is_null($this->findAttr) && !empty($findString)) {
        	$this->getCriteria()->addColumnCondition(array($this->findAttr => $findString));
    	}
    }
    /**
    * Возвращает массив записей.
    *
    * @return array
    */
	public function getRecords() {
        $this->addCondition();
    	return $this->model->findAll($this->getCriteria());
    }
    /**
    * Возвращает искомую запись.
    *
    * @return CActiveRecord
    */
	public function getRecord() {
        $this->addCondition();
    	return $this->model->find($this->getCriteria());
    }
    /**
    * Возвращает количество записей.
    *
    * @return int
    */
	public function getCount() {
    	return $this->model->count($this->getCriteria());
    }
    /**
    * Возвращает CPagination для списка.
    *
	* @return CPagination
    */
	public function getPages() {
    	$pages = new CPagination($this->getCount());
        $pages->pageSize = $this->postsPerPage;
        $pages->applyLimit($this->getCriteria());
        return $pages;
	}
} 