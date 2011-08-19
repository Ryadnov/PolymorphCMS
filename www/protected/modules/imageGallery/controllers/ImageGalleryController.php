<?php
class ImageGalleryController extends Controller
{

    public function actionMovePosition()
    {
        $positions = array_flip($_GET['gellery-item']);
        $pks = array_keys($positions);
        $m = ImageGallery::model();
        $cond = $m->idAttr.'='.implode(' OR '.$m->idAttr.'=', $pks);
        $models = ImageGallery::model()->findAll(array('condition'=>$cond));
        foreach ($models as $model) {
            $model->sort = $positions[$model->pk];
            $model->save();
        }
    }

    public function actionAddToGallery($modelPk, $imageName)
	{
		$img = new ImageGallery('create');
		$img->image_name = $imageName;
		$img->{Portfolio::getIdAttr()} = $modelPk;
		$img->makeThumb();
		$img->save();

		echo CJSON::encode(array('pk'=>$img->pk));
	}

    public function actionUpdate()
    {
        
    }
    
    public function actionDelete()
    {

    }

    public function handlerAddGalleryTab($event)
    {
        Y::beginTab('Галлерея');
        $this->renderPartial('_adminTab', array('model'=>$event->model, 'form'=>$event->form));
        Y::endTab();
    }
    
}