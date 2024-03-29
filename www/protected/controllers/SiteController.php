<?php
class SiteController extends FrontBaseController
{
    public $layout = 'main';

    public $model;
    public $category;

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {

        $i = 0;
        //check last category segment
        while (isset($_GET['cat' . ++$i])) {}

        $alias = isset($_GET['cat' . --$i]) ? $_GET['cat' . $i] : 'index';

        //find category by alias
        $this->category = Category::model()->published()->findByAttributes(array('alias' => $alias));

        if ($this->category == NULL) {
            //if $alias is no category alias, may be it's model alias and $prev_alias it's category alias
            $prev_alias = isset($_GET['cat' . --$i]) ? $_GET['cat' . $i] : false;

            if ($prev_alias == false)
                $this->redirect('/errors/not_found');
            
            $this->category = Category::model()->published()->findByAttributes(array('alias' => $prev_alias));

            if ($this->category == NULL)
                $this->redirect('/errors/not_found');

            $_GET['alias'] = $alias;
        }

        $this->model = ModelFactory::getModel($this->category);

        if ($this->model == NULL)
            $this->redirect('/errors/not_found');

        //see parent render function
        $this->render('index');

        //simple speed demonstration :-)
        echo Y::stats();
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error){
            if (Y::isAjaxRequest()){
                echo $error['message'];
            }
            else {
                echo CHtml::tag('h2', array(), 'Error ' . $error['code']);
                echo CHtml::tag('div', array(), CHtml::encode($error['message']));
            }
        }
    }

/*
    public function accessRules()
    {
        return array( // если используется проверка прав, не забывайте разрешить доступ к
            // действию, отвечающему за генерацию изображения
            array('allow', 'actions' => array('captcha'), 'users' => array('*'),),);
    }

    public function actions()
    {
        $sitemapConfig = array(array('baseModel' => 'Post', 'route' => 'posts/view', 'params' => array('id' => 'post_id')), array('baseModel' => 'Blog', 'route' => 'blogs/view', 'params' => array('id' => 'blog_id')),);

        return array( // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array('class' => 'CaptchaAction', 'backColor' => 0xFFFFFF, 'minLength' => 4, 'maxLength' => 6, 'transparent' => true, 'testLimit' => 3,), 'upload' => array('class' => 'ext.xupload.EXUploadAction'), 'sitemap' => array('class' => 'ext.sitemap.ESitemapAction', 'importListMethod' => 'getBaseSitePageList', 'classConfig' => $sitemapConfig), 'sitemapxml' => array('class' => 'ext.sitemap.ESitemapXMLAction', 'classConfig' => $sitemapConfig, //'bypassLogs'=>true, // if using yii debug toolbar enable this line
                                                                                                                                                                                                                                                                                                                                                                                                'importListMethod' => 'getBaseSitePageList',));
    }

    //special to ext.sitemap
    public function getBaseSitePageList()
    {
        $list = array(array('loc' => $this->absoluteUrl('blogs'), 'frequency' => 'weekly', 'priority' => '2',),);
        return $list;
    }

    public function actionRss()
    {
        Yii::import('ext.feed.*');

        // RSS 2.0 is the default type
        $feed = new EFeed();

        $feed->title = Y::config('rssTitle');
        $feed->description = Y::config('rssDescription');

        //$feed->setImage(Yii::app()->config->get('siteTitle'), Yii::app()->baseUrl,
        //				$this->baseUrl.Yii::app()->config->get('rssImgUrl'));

        $feed->addChannelTag('language', Yii::app()->language);
        $feed->addChannelTag('pubDate', date(DATE_RSS, time()));

        if (isset($_GET['blog_id'])){
            $blog = Blog::model()->findByPk($_GET['blog_id']);
            if (!$blog)
                Yii::app()->redirect('');
            foreach ($blog->recently(20)->posts as $post) {
                $item = $feed->createNewItem();
                $item->title = $post->fullTitle;

                $item->link = $this->absoluteUrl('posts/view', array('id' => $post->id));
                $item->date = strtotime($post->created);

                $item->description = $post->fullDescr;
                // this is just a test!!
                //$item->setEncloser('http://www.tester.com', '1283629', 'audio/mpeg');

                //$item->addTag('author', 'thisisnot@myemail.com (Antonio Ramirez)');
                $item->addTag('guid', $post->id, array('isPermaLink' => 'true'));
                $feed->addItem($item);
            }
        }

        $feed->generateFeed();
    }

    public function actionAtom()
    {
        Yii::import('ext.feed.*');

        $feed = new EFeed(EFeed::ATOM);

        // IMPORTANT : No need to add id for feed or channel. It will be automatically created from link.
        $feed->title = Y::config('rssTitle');
        $feed->link = $this->absoluteUrl('');

        $feed->addChannelTag('updated', date(DATE_ATOM, time()));
        //$feed->addChannelTag('author', array('name'=>'Antonio Ramirez Cobos'));

        if (isset($_GET['blog_id'])){
            $blog = Blog::model()->findByPk($_GET['blog_id']);
            if (!$blog)
                Yii::app()->redirect('');
            foreach ($blog->recently(20)->posts as $post) {
                $item = $feed->createNewItem();

                $item->title = $post->fullTitle;

                $item->link = $this->absoluteUrl('posts/view', array('id' => $post->id));
                // we can also insert well formatted date strings
                $item->date = date(DATE_ATOM, strtotime($post->created));

                $item->description = $post->fullDescr;
                $feed->addItem($item);
            }
        }
        $feed->generateFeed();
    }
//*/
}