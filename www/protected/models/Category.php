<?php
/**
 * This is the model class for table "ru_lookup".
 *
 * The followings are the available columns in table 'ru_lookup':
 * @property integer $lookup_id
 * @property string $type
 * @property integer $code
 * @property string $name
 */
class Category extends ActiveRecord
{
	private $_templates = null;
	private $_children = null;
	
	public $parentId;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'categories';
	}
	
	public function relations()
	{
		return array(
            'records' => array(CActiveRecord::HAS_MANY, 'Record', 'category_id',
	        	'order'=>'records.sort DESC'
			),
			'page' => array(CActiveRecord::HAS_ONE, 'page', 'category_id'),
			'blocks'=>array(self::HAS_MANY, 'TemplateBlock', 'category_id'),
		);
	}
	
	public static function getPkAttr() 
	{
		return 'id';
	}
	
	public function rules()
	{
		return array(
			array('title, alias, type', 'required', 'on'=>'create'),
			array('alias', 'unique', 'on'=>array('create', 'update')),
			array('title, alias', 'required', 'on'=>'update'),
			array('title, alias,  meta_title', 'length', 'max'=>255),
			array('type, is_empty, published, meta_descr, meta_keywords', 'safe', 'on'=>array('search', 'create', 'update')),
		);
	}
	
	public function scopes()
	{
		return array(
			'published'=>array(
				'condition'=>'published='.BaseDataType::PUBLISHED
			)
		);	
	}
	
	public function root()
	{
        return Category::model()->roots()->find();
	}
	
	public function getBlock($alias)
	{	
		foreach ($this->blocks as $block) {
			if ($block->alias == $alias)
				return $block;
		}
		
		if ($this->isRoot() || !$this->inherit_templates)
			return null;
		else
			return $this->parent->getBlock($alias);
	}

    public function getAllBlocks($existsBlocks = array(), $isCurCat = true)
	{
        $res = array();
		foreach ($this->blocks as $block) {
			$res[] = array('block'=>$block, 'isOwn'=>$isCurCat);
		}

		if ($this->isRoot())
			return $res;
		else {
            foreach ($this->parent->getAllBlocks($res, false) as $parentBlock) {
                $f = true;
                foreach ($res as $block) {
                    if ($parentBlock['block']->alias == $block['block']->alias) {
                        $f = false;
                        break;
                    }
                }
                if ($f)
                    $res[] = $parentBlock;
            }
            return $res;
        }
	}
	
	public function menuRoot($tag)
	{
		$root = $this->root();

		$root->getDbCriteria()->mergeWith(array('condition'=>'alias="'.$tag.'"'));
        
		$children = $root->children()->find();
        
		return $children;
	}
	
	public function getChildren() 
	{
		if ($this->_children == null)
			$this->_children = $this->children()->findAll();
			
		return $this->_children;
	}

	public function isChildOf($node)
	{
		return $this->lft > $node->lft && $this->rgt < $node->rgt; 
	}
	
	public function isParentOf($node)
	{
		return $this->lft < $node->lft && $this->rgt > $node->rgt;
	}
	
	public function getMainParentLevel()
	{
		return 3;	
	}
	
	public function getMainParent()
	{
		if($this->level == $this->mainParentLevel)
			return $this;
		else
			return $this->find("$this->leftAttribute < $this->lft AND 
								$this->rightAttribute > $this->rgt AND 
								$this->levelAttribute = $this->mainParentLevel");
	}
	
	public function getUrlParams()
	{
		$params = array();
		$minLevel = $this->mainParentLevel;
		$cat = $this;
		$i = $cat->level - $minLevel + 1;
		
		while ($cat->level != $minLevel) {
			$params["cat".$i--] = $cat->alias;
			$cat = $cat->parent;
		}
		
		$params["cat".$i] = $cat->alias;
		return $params;
	}
		
	public function getUrl() 
	{ 
		$urlParmas = $this->is_empty ? $this->children[0]->urlParams : $this->urlParams;
		return Y::url('site', $urlParmas);
	}
	
	public function getLink()
	{ 
		return CHtml::link($this->title, $this->url);
	}
	
	public function makeMenu($curCat)
	{
		$curMainCat = $curCat->mainParent;
		$curMainCat = $curMainCat ? $curMainCat : Category::model()->findByAttributes(array('alias'=>'index'));
		$children = $this->children()->published()->findAll();

		$res = array();
		foreach ($children as $child) {
			if ($child->is_empty && count($child->children) == 0)
				continue;
			$tmp = array();
			$tmp['label'] = $child->title;
			$tmp['url'] = $child->url;
			$tmp['active'] = $curCat->pk == $child->pk;
			
			if ($curMainCat->isParentOf($child) || $curMainCat->pk == $child->pk)
				$tmp['items'] = $child->isLeaf() ? array() : $child->makeMenu($curCat);
			
			$res[] = $tmp;
		}
		
		return $res;
	}
	
	public function makeTreeHtml()
	{
		$children = $this->children()->published()->findAll();
		$content = '';
		foreach ($children as $child) {
			$content .= CHtml::tag('li', array(), $child->link);
			$content .= $child->makeTreeHtml();
		}

		return CHtml::tag('ul', array(), $content);
	}
	
 	public function behaviors()
 	{
        return array(
            'tree' => array(
                'class' => 'application.components.Behaviors.ENestedSetBehavior',
                // хранить ли множество деревьев в одной таблице
                'hasManyRoots' => false,
                // поле для хранения идентификатора дерева при $hasManyRoots=false; не используется
                'rootAttribute' => 'root',
                // обязательные поля для NS
                'leftAttribute' => 'lft',
                'rightAttribute' => 'rgt',
                'levelAttribute' => 'level',
            ),
            'EAdvancedArBehavior' => array(
	            'class' => 'application.components.Behaviors.EAdvancedArBehavior'
	      	),
	      	'JsonSettingsBehavior'=> array(
	            'class' => 'application.components.Behaviors.JsonSettingsBehavior'
	      	),
        );
    }

	public function getTemplate($alias, $onlyPath = false)
	{
		$tmpl = $this->getOwnTemplate($alias);
		
		if ($tmpl->template === null) {
			if ($this->isRoot() || !$this->inherit_templates)
				throw new CException("Не найден шаблон $alias для категории $this->alias");
			else 
				$tmpl = $this->parent->getTemplate($alias);
		} 
		
		return $onlyPath ? $tmpl->viewPath : $tmpl;		
	}
	
	public function getOwnTemplates() 
	{
		if ($this->_templates == null) {
	   		$path = Template::getFilePath($this->pk);
			$files = FileSystem::dirFileInfo($path);
			$res = array();
			
			foreach ($files as $file) 
				$res[] = $this->getOwnTemplate($file['name']);
		
			$this->_templates = $res;
		}
		
		return $this->_templates;
	}
	
   	public function getOwnTemplate($alias)
   	{
   		return new Template($this, $alias);
	}
	
	public function attributeLabels()
	{
		return array(
			'title' => 'Название',
			'alias' => 'Алиас',
			'type' => 'Тип',
			'published' => 'Опубликовано',
			'is_empty' => 'Является ли категория пустой(будет открываться первая дочерняя категория)',
		);
	}

	public function search()
	{
		$criteria = $this->getDbCriteria();
 		
		$criteria->order = $this->tree->hasManyRoots
							?$this->tree->rootAttribute . ', ' . $this->tree->leftAttribute
				            :$this->tree->leftAttribute;
                           
		return new EActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}


	public function getUpdateUrl()
	{
		return Admin::url('categories/update', array('pk' => $this->pk));
	}
	
	public function getDeleteUrl()
	{
		return Admin::url('categories/delete', array('id' => $this->pk));
	}
	
	public function getAdminUrl()
	{
		return Admin::url('categories/admin');
	}
	
	public function getAdminViewUrl()
	{
		return Admin::url('categories/view', array('catPk'=>$this->pk));
	}
	
	public function getAdminViewLink()
	{
		return CHtml::link($this->title, $this->adminViewUrl);
	}
	
	public function getUpdateLink()
	{
		return CHtml::link($this->title, $this->updateUrl);
	}
	
	public function getAdminLink()
	{
		return CHtml::link($this->title, $this->adminUrl);
	}
	
	public function getCopyDataLink($to)
	{
		return CHtml::link($to->title, Admin::url("categories/moveData?from=".$this->pk."&to=".$to->pk."&action=copy"));
	}

	public function getCutDataLink($to)
	{
		return CHtml::link($to->title, Admin::url("categories/moveData?from=".$this->pk."&to=".$to->pk."&action=cut"));
	}
	
	public function moveData($action, $toCat = null)
	{
		$transaction=$this->dbConnection->beginTransaction();
		try {
			if($action=='cut') ModelFactory::cutRelations($this, $toCat);
			if($action=='copy') ModelFactory::copyRelations($this, $toCat);
			if($action=='delete') ModelFactory::deleteRelations($this); 
			
			//copy templates
			$res = array();
			foreach ($this->templates as $tmpl) {
				$newTmpl = $tmpl;
				$doAssign = true;
				if ($action=='cut') {
					$doAssign = $toCat->getOwnTemplate($tmpl->alias) == null;
				} elseif ($action=='copy') {
					$doAssign = $toCat->getOwnTemplate($tmpl->alias) == null;
					$newTmpl->pk = null;
				}
				
				if($doAssign)
					$res[] = $newTmpl;
			}
			if ($action=='cut' || $action=='copy') {
				$to->templates = $res;
				$to->save();
			}
			if ($action=='cut' || $action=='delete')
				$this->templates = array();
			
			$transaction->commit();
			$result = true;
		} catch(Exception $e) {
		    $transaction->rollBack();
			$result = false;	
		}
		
		return $result;
	}
	
	public function moveAndDelete($action, $to = null) 
	{
		if($this->moveData($action, $to)) {
			return $this->deleteNode();
		}
		
		return false;
	} 

	public function afterSave()
	{
		parent::afterSave();
		if ($this->isNewRecord && $this->type == 'page' && $this->page == null) {
			$page = new Page;
			$page->text = 'Пока здесь ничего не написано';
			$page->category_id = $this->pk;
			if(!$page->save())
				throw new Exception('Не получилось создать страницу. Повторите действие еще раз.');
		}
	}

}
