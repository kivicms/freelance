<?php 
namespace app\helpers;

use app\modules\notify\models\Notify;
use yii\helpers\VarDumper;
use yii\web\HttpException;

class NotifyHelper {
    
    private static $templates = [
        'UserVerified' => [
            'title' => 'Подтверждение профиля',
            'description' => 'Поздравляем! Ваш профиль успешно подтвержден. Теперь Вы можете пользоваться сайтом в полном объеме!'
        ]  
    ];
    
    public static function sendTemplate($to_user_id, $template) {        
        if (isset(self::$templates[$template])) {
            self::send($to_user_id, 
                self::$templates[$template]['title'],
                self::$templates[$template]['description']
            );
        } else {
            throw new HttpException('Указанного шаблона ' . $template . 'не существует!');
        }
    }
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