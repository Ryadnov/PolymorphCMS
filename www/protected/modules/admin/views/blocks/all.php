<div class="dark-blue-head">
    <?php echo Admin::ascLink('Добавить блок +', 'blocks/add', array('catPk'=>$cat->pk), array('id'=>'add-block-btn'),
        array('success'=> "js:function() {
           $('#block-tabs').tabs('load', 0);
        });")) ?>
</div>

<?php echo $this->widget('CTreeView', array('collapsed'=>true,'data'=>blocks, 'id'=>'blocks')) ?>
<script type="text/javascript">
$(document).ready(function() {

    $('#blocks li.widget-link a').click(function() {
        $('#widget-details').load($(this).attr('href'));
        return false;
    })
    $('.make-own-btn').asc({
        isStatic: true,
        buttons: {
            "Да" : function() {
                var $t = $('#blocks .make-own-btn'),
                    url = $t.attr('href'),
                    res = '';

                for(var a in $(this))
                    res += a+' = '+$(this)[a]+"</br>\n";
                alert($(this).attr('id'));
                return false;
                //make own and reload tab
                $.get(url, {}, function(data) {
                    if (data == 'ok')
                        $('#block-tabs').tabs('load', 0);
                });

                $(this).dialog("close");
            },
            "Отмена" : function() {
                $(this).dialog("close");
            }
        }
    });

    //you can dnd widgets between blocks
    $('#blocks > li').droppable({
        drop: function(e, ui) {
            var from = $(ui.draggable).closest('ul').parent().attr('id').split('_')[1],
                to = $(this).attr('id').split('_')[1],
                itemPk = $(ui.draggable).attr('id').split('_')[1],
                url = '/admin/blocks/saveWidgetsPosition?to='+to+'&from='+from+'&widgetPk='+itemPk;

                $.post(url,{}, function(){
                    var t = $("#block-tabs");
                    t.tabs('load', t.tabs('option', 'selected'));
                });
        },
        hoverClass: "accept"
    });

    $("#blocks ul").sortable({
        //connectWith: "#blocks ul",
        helper: "clone",
        opacity: 0.6,
        scroll: true,

        change: function(event, ui) {
            var id = $(this).closest('li').attr('id').split('_')[1],
                data = $(this).children('ul').sortable('serialize'),
                url = '/admin/blocks/saveWidgetsPosition?blockPk='+id+'&'+data;

            $.post(url);

            //array to $.when using apply, see http://docs.jquery.com/Types#Context.2C_Call_and_Apply
//            $.when.apply(null, objects).then(function() {
//
//            });
        }
    });

    //delete blocks

});

    $("#trash").droppable({
        drop: function(e, ui) {
            var params = $(ui.draggable).attr("id").split('_'),
                type = params[0],
                pk = params[1],
                url;
            if (type == 'widgets') {
                url = "/admin/widgets/delete";
            } else if (type == 'blocks') {
                url = "/admin/blocks/delete"
            }

            $.get(url, {pk : pk}, function() {
                $(ui.draggable).remove();
            });
        },
        hoverClass: "accept"
    });
</script>
