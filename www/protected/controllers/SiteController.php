<?php
class SiteController extends RenderController
{
    public function accessRules() {
        return array(
            // если используется проверка прав, не забывайте разрешить доступ к
            // действию, отвечающему за генерацию изображения
            array('allow',
                'actions'=>array('captcha'),
                'users'=>array('*'),
            ),
        );
    }

    /**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		$sitemapConfig = array(
			array('baseModel'=>'Post',
            	'route'=>'posts/view',
				'params'=>array('id'=>'post_id')),
			array('baseModel'=>'Blog',
                'route'=>'blogs/view',
                'params'=>array('id'=>'blog_id')),
		);
		
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
	        'captcha'=>array(
	            'class'=>'CaptchaAction',
	            'backColor'=>0xFFFFFF,
	            'minLength'=>4,
	            'maxLength'=>6,
	            'transparent'=>true,
	            'testLimit'=>3,
			),
			'upload'=>array(
				'class'=>'ext.xupload.EXUploadAction'
			),
			'sitemap'=>array(
                'class'=>'ext.sitemap.ESitemapAction',
                'importListMethod'=>'getBaseSitePageList',
                'classConfig'=>$sitemapConfig
			),
            'sitemapxml'=>array(
                'class'=>'ext.sitemap.ESitemapXMLAction',
                'classConfig'=>$sitemapConfig,
                //'bypassLogs'=>true, // if using yii debug toolbar enable this line
                'importListMethod'=>'getBaseSitePageList',
            )
		);
	}
	
	//special to ext.sitemap
	public function getBaseSitePageList()
	{
        $list = array(
			array(
            	'loc'=>$this->absoluteUrl('blogs'),
				'frequency'=>'weekly',
                'priority'=>'1',
			),
		);
        return $list;
	}
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		//Y::dump(Y::file('css')->contents);
		Y::clientScript()->registerCoreScript('jquery')
						->registerCssFile('/css/style.css');
		
		$alias = 'index';
		$i = 0;
		while (isset($_GET['cat'.++$i])) 
			$alias = $_GET['cat'.$i];
		
		$category = Category::model()->published()->findByAttributes(array('alias'=>$alias));
		
		if ($category == NULL)
			$this->redirect('/errors/not_found');
		
		$this->category = $category;

		$model = ModelFactory::getModel($category);

		if (isset($_GET['alias']) || isset($_GET['id'])) {
			$value = isset($_GET['alias']) ? $_GET['alias'] : $_GET['id'];
			$attr = isset($_GET['alias']) ? 'alias' : $model->pkAttr;
			
			$model = $model->published()->findByAttributes(array($attr=>$value));
		
			if ($model == NULL)
				$this->redirect('/errors/not_found');
		}
		
		$this->model = $model;

        $this->render('main', array(
			'menu'=>new Menu,
			'header'=>new BlockViewer('header', $category),
			'footer'=>new BlockViewer('footer', $category),
			'content'=>new BlockViewer('content', $category),
			'block'=>new BlockViewer(null, $category),
			'meta'=>new MetaViewer($category),
			'item'=>$model,
			'breadcrumbs'=>new BreadCrumb,
			'category'=>$category,
		));
    }
    
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Y::isAjaxRequest())
	    		echo $error['message'];
	    	else {
				echo CHtml::tag('h2',array(),'Error '.$error['code']);
				echo CHtml::tag('div',array(),CHtml::encode($error['message']));
			}
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Y::flash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	public function actionRss() {
		Yii::import('ext.feed.*');
 
		// RSS 2.0 is the default type
		$feed = new EFeed();
		 
		$feed->title = Y::config('rssTitle');
		$feed->description = Y::config('rssDescription');
		
		//$feed->setImage(Yii::app()->config->get('siteTitle'), Yii::app()->baseUrl,
			//				$this->baseUrl.Yii::app()->config->get('rssImgUrl'));
		
		$feed->addChannelTag('language', Yii::app()->language);
		$feed->addChannelTag('pubDate', date(DATE_RSS, time()));
		
		if(isset($_GET['blog_id'])) {
			$blog = Blog::model()->findByPk($_GET['blog_id']);
			if(!$blog) Yii::app()->redirect('');
			foreach($blog->recently(20)->posts as $post) {
				$item = $feed->createNewItem();		
				$item->title = $post->fullTitle;
				
				$item->link = $this->absoluteUrl('posts/view',array('id'=>$post->id));
				$item->date = strtotime($post->created);
				
				$item->description = $post->fullDescr;
				// this is just a test!!
				//$item->setEncloser('http://www.tester.com', '1283629', 'audio/mpeg');
				 
				//$item->addTag('author', 'thisisnot@myemail.com (Antonio Ramirez)');
				$item->addTag('guid', $post->id,array('isPermaLink'=>'true'));
				$feed->addItem($item);
			}
		}
		  
		$feed->generateFeed();
	}
	
	public function actionAtom() {
		Yii::import('ext.feed.*');
 		 
		$feed = new EFeed(EFeed::ATOM);
		 
		// IMPORTANT : No need to add id for feed or channel. It will be automatically created from link.
		$feed->title = Y::config('rssTitle');
		$feed->link = $this->absoluteUrl('');
		 
		$feed->addChannelTag('updated', date(DATE_ATOM, time()));
		//$feed->addChannelTag('author', array('name'=>'Antonio Ramirez Cobos'));
		 
		if (isset($_GET['blog_id'])) {
			$blog = Blog::model()->findByPk($_GET['blog_id']);
			if(!$blog) Yii::app()->redirect('');
			foreach ($blog->recently(20)->posts as $post) {
				$item = $feed->createNewItem();
				 
				$item->title = $post->fullTitle;
				
				$item->link = $this->absoluteUrl('posts/view',array('id'=>$post->id));
				// we can also insert well formatted date strings
				$item->date = date(DATE_ATOM,strtotime($post->created));
				
				$item->description = $post->fullDescr;
				$feed->addItem($item);		
			}
		}
		$feed->generateFeed();
	}

}