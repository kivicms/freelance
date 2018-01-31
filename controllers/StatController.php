<?php 
namespace app\controllers;

class StatController extends BaseController {
    
    
    public function actionIndex($start = null, $end = null) {
        if (! $start && ! $end) {
            $startTime = strtotime(date('Y-m-d 00:00:00'));
            $endTime = time();
        }
        $newUsers = \Yii::$app->db->createCommand('
            select count(*) 
            from user
            where created_at between :start AND :end
        ',[
            ':start' => $startTime,
            ':end' => $endTime
        ])->queryScalar();
        return $this->render('index',[
            'newUsers' => $newUsers
        ]);
    }
}