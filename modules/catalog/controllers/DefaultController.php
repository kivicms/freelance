<?php

namespace app\modules\catalog\controllers;

use yii\web\Controller;
use app\controllers\BaseController;

/**
 * Default controller for the `catalog` module
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
