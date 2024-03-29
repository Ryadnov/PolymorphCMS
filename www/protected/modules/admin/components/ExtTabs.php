<?php

/*
 * class for ajax echo tabs
 * not registered script as parent class
 * but echo scripts in <script type='text/javascript'></script> tags
 */
class ExtTabs extends JuiTabs
{
    public $buttons;
    public $extHeaderHtml;

    public function init()
    {
        parent::init();
        $this->registerScritps();
    }
    
    public function run()
    {
        $id = $this->getId();
        if (isset($this->htmlOptions['id']))
            $id = $this->htmlOptions['id'];
        else
            $this->htmlOptions['id']=$id;

        echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";

        $tabsOut = "";
        $contentOut = "";
        $tabCount = 0;

        foreach($this->tabs as $title=>$content)
        {
            $tabId = (is_array($content) && isset($content['id']))?$content['id']:$id.'_tab_'.$tabCount++;

            if (!is_array($content))
            {
                $tabsOut .= strtr($this->headerTemplate, array('{title}'=>$title, '{url}'=>'#'.$tabId, '{id}'=>'#' . $tabId))."\n";
                $contentOut .= strtr($this->contentTemplate, array('{content}'=>$content,'{id}'=>$tabId))."\n";
            }
            elseif (isset($content['ajax']))
            {
                $tabsOut .= strtr($this->headerTemplate, array('{title}'=>$title, '{url}'=>CHtml::normalizeUrl($content['ajax']), '{id}'=>'#' . $tabId))."\n";
            }
            else
            {
                $tabsOut .= strtr($this->headerTemplate, array('{title}'=>$title, '{url}'=>'#'.$tabId))."\n";
                if(isset($content['content']))
                    $contentOut .= strtr($this->contentTemplate, array('{content}'=>$content['content'],'{id}'=>$tabId))."\n";
            }
        }

        foreach((array)$this->buttons as $button)
            $tabsOut .= $button;

        foreach((array)$this->extHeaderHtml as $html)
            $tabsOut .= $html;

        echo "<ul>\n".  $tabsOut . "</ul>\n";
        echo $contentOut;

        echo CHtml::closeTag($this->tagName)."\n";
    }

    public function registerScritps()
    {
        $options = empty($this->options) ? '' : CJavaScript::encode($this->options);
        Y::clientScript()
            ->registerScript($this->getId().'-form-submit', "
                $(document).ready(function(){
                    $('#{$this->getId()}').tabs({$options});
                });
            ")
            ->registerScriptFile('');
    }
}