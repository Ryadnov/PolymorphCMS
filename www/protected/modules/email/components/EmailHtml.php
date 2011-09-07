<?php
class EmailHtml
{
    public static function link($src, $txt = '', $style = '') {
        return '<a href="'.Yii::app()->baseUrl.'/'.$src.'" target="_blank" style="'.$style.'">'.$txt.'</a>';
    }

    public static function extLink($src, $txt = '', $style = '') {
        return '<a href="'.$src.'" target="_blank" style="'.$style.'">'.$txt.'</a>';
    }

    public static function image($img, $url, $pathToImg){
        $img_html = '<img src="'.Yii::app()->baseUrl.$pathToImg.$img.'" align="left" style="border: none" />';
        return slef::a($url, $img_html);
    } 

    public static function td($w, $h) {
        return '
        <td width="'.$w.'" height="'.$h.'" style="line-height:0;">
            <img src="'.Yii::app()->baseUrl.'/images/space.gif" width="'.$w.'" height="'.$h.'" />
        </td>';
    }

    public static function tr($w, $h, $colspan) {
        return '<tr><td colspan="'.$colspan.'" height="'.$h.'" width="'.$w.'" style="line-height:0;"><img src="http://freenews.kz/images/space.gif" width="'.$w.'" height="'.$h.'" /></td></tr>'."\n";

    }

    public static function space($w, $h) {
        return '<img src="'.Yii::app()->baseUrl.'/images/space.gif" width="'.$w.'" align="left" height="'.$h.'" />'."\n";
    }

}