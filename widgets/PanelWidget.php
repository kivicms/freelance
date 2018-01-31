<?php
namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class PanelWidget extends Widget
{

    public $title = 'Заголовок';

    public $type = 'primary';
    
    public $solid = false;

    public $icon = 'icon-profile';

    public $buttons = [];

    public $template = [];

    private $_buttons = [];

    public function init()
    {
        $solid = ($this->solid) ? ' box-solid' : '';
        
        
        echo '<div class="box box-'. $this->type . $solid . '">
                <div class="box-header with-border">
                    <h3 class="box-title">' . $this->title . '</h3>';
        if (count($this->buttons)) {
            echo '<div class="box-tools pull-right">';
            foreach ($this->buttons as $button) {
                echo $button;
            }
            echo '</div>';
        }
        echo '</div>
                <div class="box-body">';
    }

    public function run()
    {
        echo '</div></div>';
    }
}