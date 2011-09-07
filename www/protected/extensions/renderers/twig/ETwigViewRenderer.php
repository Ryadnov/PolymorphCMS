<?php
/**
 * Twig views renderer
 *
 * @author Alexander Makarov <sam@rmcreative.ru>
 * @link http://code.google.com/p/yiiext/
 * @link http://www.twig-project.org/
 *
 * @version 0.9.2
 */
class ETwigViewRenderer extends CApplicationComponent implements IViewRenderer {
    public $fileExtension='.html';

    private $twig;

    /**
     * Component initialization
     */
    function init(){
        Yii::import('application.vendors.*');

        // need this since Yii autoload handler raises an error if class is not found
        spl_autoload_unregister(array('YiiBase','autoload'));

        // registering twig autoload handler
        require_once 'Twig/Autoloader.php';
        Twig_Autoloader::register();

        // adding back Yii autoload handler
        spl_autoload_register(array('YiiBase','autoload'));

        // setting cache path to application runtime directory
        $cache_path = Yii::app()->getRuntimePath().DIRECTORY_SEPARATOR.'views_twig'.DIRECTORY_SEPARATOR;

        // here we are using twig loader
        $loader = new Twig_Loader_Filesystem($this->getBasePath());
        $this->twig = new Twig_Environment($loader, array('cache'=>$cache_path, 'autoescape'=>false, 'auto_reload'=>true));

        Yii::import('ext.renderers.twig.*');
        $this->twig->addExtension(new Project_Twig_Extension());
    }

    /**
	 * Renders a views file.
	 * This method is required by {@link IViewRenderer}.
	 * @param CBaseController the controller or widget who is rendering the views file.
	 * @param string the views file path
	 * @param mixed the data to be passed to the views
	 * @param boolean whether the rendering result should be returned
	 * @return mixed the rendering result, or null if the rendering result is not needed.
	 */
	public function renderFile($context,$sourceFile,$data,$return)
    {
        // current controller properties will be accessible as {{this.property}}
        $data['this'] = $context;

        // check if views file exists
        if(!is_file($sourceFile) || ($file=realpath($sourceFile))===false)
            throw new CException(Yii::t('yiiext','View file "{file}" does not exist.', array('{file}'=>$sourceFile)));

		$sourceFile = substr($sourceFile, strlen($this->getBasePath()));
        $template = $this->twig->loadTemplate($sourceFile);

		if($return)
			return $template->render($data);
		else
			echo $template->render($data);
	}

	/**
	 * Theme-aware basepath
	 * @return string
	 */
	protected function getBasePath()
	{
		if(Yii::app()->theme == null)
			return Yii::app()->getBasePath();

		return Yii::app()->theme->getBasePath();
	}
}
