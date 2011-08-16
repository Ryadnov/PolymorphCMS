<?php
class SaveButton extends JuiButton
{
    public  function init()
    {
        Y::clientScript()->registerScript('save-button', "
            $(document).ready(function() {
                //form submit
                var ajaxSave = function () {
                    var form = $(this).closest('form');
                    $(form).submit();
                    return false;
                }

                $('#widget-form-save-button').click(ajaxSave);

            });
        ");
        parent::init();
    }
}
