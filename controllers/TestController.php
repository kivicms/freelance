<?php
/**
 * Created by PhpStorm.
 * User: Ivanov
 * Date: 23.03.2018
 * Time: 22:35
 */

namespace app\controllers;


use app\models\User;

class TestController
{
    public function actionIndex() {
        $m = $this->load();

    }

    private function load() : User {
        return new User();
    }
}