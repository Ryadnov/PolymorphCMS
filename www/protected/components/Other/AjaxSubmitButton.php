<?php
class AjaxSubmitButton extends JuiButton
{
    public  function init()
    {
        Y::clientScript()->registerScriptFile('/js/plugins/jquery.form.js');

        $options = CJavaScript::encode($this->options);
        Y::clientScript()->registerScript('save-button', "
            $(document).ready(function() {
                //form submit
                $('#$this->id').closest('form').bind('submit', function(e) {
                    e.preventDefault(); // <-- important
                    $(this).ajaxSubmit($options);
                });
            });
        ");
        parent::init();
    }
}
