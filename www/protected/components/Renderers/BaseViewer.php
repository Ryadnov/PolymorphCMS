<?php
/**
 * Singleton class
 * @author Alex
 *
 */
class BaseViewer extends CComponent
{
	protected static $instances = array();  // object instance
    
    /**
     * Защищаем от создания через клонирование
     *
     * @return Singleton
     */
    private function __clone() { /* ... */ }
 
    /**
     * Возвращает единственный экземпляр класса для заданного алиаса
     *
     * @return Singleton
     */
    public static function getInstance($category) 
    {
        if (!isset(self::$instances[$category->pk])) {
            self::$instances[$category->pk] = new BaseViewer($category);
        }
        return self::$instances[$category->pk];
    }
 
	private $_category;
	private $_settings;
	
	public function __construct($category)
	{
		$this->_category = $category;
		$this->_settings = $category->settings;
	}
	
	public function getMenu()
	{
		return new Menu;
	}
	
	public function getHeader()
	{
		$opts = array(
			'category'=>$this->_category,
		);

		return Y::renderPartial('header', $opts, true);
	}
	
	public function getFooter()
	{
		$res = '';
		return $res;
	}
	
}
