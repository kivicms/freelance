<?php 
namespace app\helpers;

use app\modules\notify\models\Notify;
use yii\helpers\VarDumper;

class NotifyHelper {
    
    public static function send($to_user_id, $title, $description) {
        if (is_array($to_user_id)) {
            foreach ($to_user_id as $uid) {
                self::makeNotify($uid, $title, $description);
            }
        } else {
            self::makeNotify($to_user_id, $title, $description);
        }
    }
    
    private function makeNotify($to_user_id, $title, $description) {
        $n = new Notify();
        $n->to_user_id = $to_user_id;
        $n->title = $title;
        $n->status = 0;
        $n->readed_time = 0;
        $n->description = $description;
        if (! $n->save(false)) {
            VarDumper::dump($n->getErrors());
            die;
        }
    }
}