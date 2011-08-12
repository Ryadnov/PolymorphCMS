<?php
class SaveButton extends JuiButton
{
    public  function init()
    {
        Y::clientScript()->registerScript('save-button-subit', "
            $(document).ready(function() {
                //form submit
                var ajaxSave = function () {

                    var form = $(this).closest('form');
                    form.ajaxSubmit({
                         success: function() {
                            form.find('.submit-form-result').fadeOut(0).text('Сохранено').fadeIn(500).delay(800).fadeOut(500);
                         }
                    });
                    return false;
                }

                $('#widget-form-save-button').click(ajaxSave);

            });
        ");
        parent::init();
    }
}
