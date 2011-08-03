<?php
Yii::import('zii.widgets.jui.CJuiButton');
/*
 * class for ajax echo tabs
 * not registered script as parent class
 * but echo scripts in <script type='text/javascript'></script> tags
 */
class JuiButton extends CJuiButton
{
    public $theme='base';
    public $cssFile='jquery-ui.css';
    public $themeUrl='/css/jui';
    
}