<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    public function render($view,$data=null,$return=false)
    {
        if($this->beforeRender($view))
        {
            $output=$this->renderPartial($view,$data,true);
            if(($layoutFile=$this->getLayoutFile($this->layout))!==false) {
                $data['content'] = $output;
                $output=$this->renderFile($layoutFile,$data,true);
            }
            
            $this->afterRender($view,$output);

            $output=$this->processOutput($output);

            if($return)
                return $output;
            else
                echo $output;
        }
    }

	public $title;
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	public $baseUrl;
	    
    public function init()
    {
    	$this->baseUrl = Y::config('baseUrl');
        Yii::app()->language = isset($_GET['lang']) ? $_GET['lang'] : "ru";
        
        return parent::init();
    }

	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
    
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	public function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']))
			Y::end(CActiveForm::validate($model));
	}
	
	/**
	 * set $model->$field in next value, using $values array
	 * @param string $query_id
	 * @param model $model
	 * @param string $field
	 * @param array $values
	 */
	protected function ajaxSetNextValue($query_id, $model, $field, $values) 
	{
		if (Y::isAjaxRequest() && isset($_GET[$query_id])) {
			$model->scenario = $query_id;
	    	$model = $model->find(array('condition'=>$model->idAttr.'='.(int)$_GET['model_id']));
	    	
	    	//cycle shift
	    	while ($model->$field != ($values[] = array_shift($values)));
	    	
	    	//set next vaalue
	    	$model->$field = array_shift($values);
	    	
	    	if ($model->save())
	    		echo $model->$field;
    		else 
    			print_r($model->getErrors());	
    			
	        Y::end();	
    	}
	}

    public function renderJson($data,$return=false) {
        $output = CJSON::encode($data);
        if($return)
            return $output;
        else {
            header("HTTP/2.0 200 OK");
            header('Content-type: text/json; charset='.Yii::app()->charset);
            header('Content-Length: '.strlen($output));
            header("Cache-Control: no-cache, must-revalidate");
            header("Pragma: no-cache");
            echo $output;
        }
    }

}