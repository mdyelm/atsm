<h2><?=$unitData['Unit']['unit_id']?> 監視画像一覧</h2>
<input id="idPage" value="0" type="hidden">
<div id="viewData"></div>
<h3 id="checkDataNone" style="display: none;"><font color="red">データはもうありません。</font></h3>

<script>
    var getDataList = function (page) {
        var url = "<?php echo $this->Html->url(array("controller" => "Monitoring","action" => "monitor_list_ajax",$id)); ?>";
        var data = {
           'page' : page
        };
        $.post(url,data,function(dataR){
            if(page > parseInt($('#idPage').val())){ 
                if(dataR){
                    $('#idPage').val(page);
                    $('#checkDataNone').hide();
                }else{
                    if($('#idPage').val() > 1){
                        $('#checkDataNone').show();
                    }
                }
                $('#viewData').append(dataR);
            }
        },'html');
    };
    $( document ).ready(function() {
        getDataList(1);
    });
    $(document).scroll(function (e) {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            getDataList(parseInt($('#idPage').val()) + 1);
        }
    });
</script>