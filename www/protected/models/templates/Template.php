<?php
class Template extends CModel
{
	private $_category;
	private $_template;
	private $_alias;

	public $ext = '.twig';
	
	private $_isNewRecord;
	
	const TMPL_PATH = 'application.views.templates';
	const TMPL_FOLDER = '/templates';
	
	public function __construct($cat, $alias, $scenario = '')
	{
		$this->_category = $cat;
		$this->_alias = $alias;
		$this->_isNewRecord = $this->template ? false : true;
		$this->scenario = $scenario;
		return $this;
	}
	
	public function rules()
	{
		return array(
			array('alias, template, category_id', 'safe', 'on'=>'create'),
			array('alias, template', 'safe', 'on'=>array('search', 'update')),
			array('alias', 'required'),
			array('alias', 'length', 'max'=>255)
		);
	}
	
	public function getAlias() 
	{
		return $this->_alias;	
	}
	
	public function getCat()
	{
		return $this->_category;	
	}
	
	public function getIsNewRecord() 
	{
		return $this->_isNewRecord;	
	}
	
	public function getTemplate()
	{

		if ($this->_template === null) {
			$path = $this->filePath;
			$files = FileSystem::dirFileInfo($path);
            $fileName = $this->alias.$this->ext;
			if (isset($files[$fileName]))
				$this->_template = FileSystem::read($path.$fileName);
		}

		return $this->_template;
	}
	
	public function save($runValidation=true,$attributes=null)
	{
		if(!$runValidation || $this->validate($attributes))
			return $this->isNewRecord ? $this->create() : $this->update();
		else
			return false;
	}
	
	public function create()
	{
		$path = $this->filePath;
		if (!is_dir($path)) {
			mkdir($path, '0755');
		}
		return FileSystem::write($path.'/'.$this->alias.$this->ext, $this->template, 'x');	
	}

	public function update()
	{
		return FileSystem::write($this->filePath.'/'.$this->alias.$this->ext, $this->template, 'w');
	}
	
	public function getFilePath($catId = false) 
	{
		if (!$catId && $this->cat) 
			$catId = $this->cat->pk;
		
		if ($catId) 
			return Yii::getPathOfAlias(self::TMPL_PATH).'/'.$catId.'/';
		else 
			return Yii::getPathOfAlias(self::TMPL_PATH);
	} 
	
	public function getViewPath()
	{
		return self::TMPL_FOLDER.'/'.$this->cat->pk.'/'.$this->alias;
	}
	
	public function attributeNames() 
	{
		return array(
			'template',
			'alias',
			'cat'
		);		
	}
	
	public function attributeLabels()
	{
		return array(
			'template' => 'Шаблон',
			'alias' =>'Алиас',
			'cat' => 'Категория'
		);		
	}
	
	public function getUpdateUrl()
	{
		return Admin::url('fileTemplates/update', array('catId' => $this->cat->pk, 'alias' => $this->alias));
	}
	
	public function getDeleteUrl()
	{
		return Admin::url('fileTemplates/delete', array('catId' => $this->cat->pk, 'alias' => $this->alias));
	}
	
	public function getAdminUrl()
	{
		return Admin::url('fileTemplates/admin', array('catId'=>$this->cat->pk));
	}
	
	public function getUpdateLink()
	{
		return CHtml::link($this->alias, $this->updateUrl);
	}
	
	public function getAdminLink()
	{
		return CHtml::link($this->alias, $this->adminUrl);
	}

	
}