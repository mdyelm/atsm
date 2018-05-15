<div class="col-lg-12 non-float">
    <div class="newBlock">
        <p class="nopd nomg">ユニット端末の景観の変化の様子を表示しています。</p>
        <p class="nopd nomg">「監視画像」欄の青枠をクリックすることにより現地の画像をポップアップ表示します。</p>
        <p class="nopd nomg">グラフの最新の状態を閲覧するためには、グラフ更新ボタンをクリックしてください。</p>
        <?php
        echo $this->Form->create('Monitoring', array(
            'id' =>'idMoStatus',
            'url' => "/Monitoring/status/".$unitData['Unit']['id']."#idMoStatus",
            'inputDefaults' => array(
                'label' => false,
                'div' => false,
                'required' => false,
        )));
        ?>
        <div class="well bs-component">
            <?php echo $this->Flash->render('MonitoringStatus'); ?>
            <a onclick="getDataNow();">
                <input class="pull-right mgB10 btnRf" type="button" value="グラフ更新">
                <input id="idGetDataNow" name="getDataNow" type="hidden" value="0">
            </a>
            <p class="pull-right nopd nomg mgT6">
                現在「<?=date("Y/m/d H:i:s");?>」に取得したデータを表示しています。
            </p>
            
            <table class="table font13">
                <tbody>
                    <tr class="cap">
                        <th class="text-center tbW20">
                            <span>ユニット端末ID</span>
                        </th>
                        <td>
                            <label class="pdL5"><?=$unitData['Unit']['unit_id']?></label>
                        </td>
                      <!--<td><label>C-001</label></td>-->
                    </tr>
                    <tr class="cap">
                        <th class="text-center tbW20">
                            <span>管理組織</span>
                        </th>
                        <td>
                            <label class="pdL5">
                                    <?=$unitData['Organization']['organization_name'] ?>
                            </label>
                        </td>
                    </tr>
                    <tr class="cap">
                        <th class="text-center tbW20">
                            <span>観測場所名</span>
                        </th>
                        <td>
                            <label class="pdL5">
                                <?php if (!empty($unitData['Unit']['place'])): ?>
                                    <?php echo h($unitData['Unit']['place']); ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </label>
                        </td>
                    </tr>
                    <tr class="cap">
                        <th class="text-center tbW20">
                            <span>表示時間</span>
                        </th>
                        <td>
                            <!--<label class="pdL5">-->
                                <?php 
                                    $dateModify = new \DateTime($dateSet['dateStart']);
                                    $date = $dateModify->format('Y/m/d');
                                    $time = $dateModify->format('H');
                                    $minute= $dateModify->format('i');
                                    $dateEnd = new \DateTime($dateSet['dateEnd']);
                                    $dateView = $dateEnd->format('Y/m/d H時 i分');
                                    $dateEndValue = $dateEnd->format('Y/m/d H:i:s');
                                    $dateStartValue = $dateModify->format('Y/m/d H:i:s');
                                ?>
                                <?php echo $this->Form->input('date', array('value'=>$date,'type' => 'text', "class" => "inputNewDes w150 datetimepicker text-center", 'label' => false, 'div' => false)); ?>
                                <?php echo $this->Form->input('dateEnd', array('value'=>$dateEndValue,'type' => 'hidden', 'label' => false, 'div' => false)); ?>
                                <?php echo $this->Form->input('dateStart', array('value'=>$dateStartValue,'type' => 'hidden', 'label' => false, 'div' => false)); ?>
                                <?php echo $this->Form->input('time', array('min'=>0,"max" => 23,'value'=>$time,'type' => 'number', "class" => "checkMax inputNewDes w50 text-center mgL15", 'label' => false, 'div' => false)); ?>
                                <span class="mgL10">時</span>
                                <?php echo $this->Form->input('minute', array('min'=>0,"max" => 59,'value'=>$minute,'type' => 'number', "class" => "checkMax inputNewDes w50 text-center mgL15", 'label' => false, 'div' => false)); ?>
                                <span class="mgL10">分</span>
                                <span class="mgC20">～</span><span id="viewDateEnd"><?=$dateView?></span>
                                <input type="button" class="mgC15 w70 text-center btnE submitForm" value="再表示">
                            <!--</label>-->
                        </td>
                    </tr>
                    <tr class="cap">
                        <th class="text-center tbW20">
                            <span>表示間隔</span>
                        </th>
                        <td>
                            <label class="pdL5">
                                <?php 
                                    echo $this->Form->input('display_interval', array(
                                        'options' => Configure::read('display_interval'),
                                        'class' => 'inputNewDes w100 changeSubmit',
                                        'label' => false, 
                                        'div' => false,
                                        'value' => $dateSet['displayInterval'],
                                        'id' => 'selectDisplayInterval'
                                    ));
                                ?>
                            </label>
                        </td>
                    </tr>
<!--                    <tr class="cap">
                        <th class="text-center tbW20">
                            <span>解析処理</span>
                        </th>
                        <td>
                            <label class="pdL5">
                                <?php 
                                    $classDisable = "";
                                    $disabledType = false;
                                    if($info['checkData']==0){ 
                                        
                                        $classDisable = "disabledPa";
                                        $disabledType = true;
                                    }
                                    echo $this->Form->input('diff_pix_type', array(
                                        'options' => Configure::read('diff_pix_type'),
                                        'class' => 'inputNewDes w70 changeSubmit '.$classDisable,
                                        'label' => false, 
                                        'div' => false,
                                        'disabled' => $disabledType,
                                        'value' => $dateSet['diff_pix_type'],
                                        'id' => 'selectDisplayInterval'
                                    ));
                                ?>
                            </label>
                        </td>
                    </tr>-->
                    
                    <tr class="cap">
                        <th class="text-center tbW20">
                            <span>画像差異グラフ</span>
                        </th>
                        <td>
                            <div class="graphView" align="center">
                                <canvas id="chart" width="730" height="500"></canvas>
                            </div>
                                <?php 
                                    echo $this->Form->input('prev_date', array(
                                        'type' => 'hidden',
                                        'id' => 'prevDate',
                                    ));
                                ?>
                                <?php 
                                    echo $this->Form->input('next_date', array(
                                        'type' => 'hidden',
                                        'id' => 'nextDate',
                                    ));
                                ?>
                            <?php 
                                if(!empty($dateSet['checkDisplayPrev'])) {
                            ?>
                                <a data-id="prevDate"  class="mgL15 pull-left nextPrev cursorPointer"><<  <span class="viewNextPrev"><?= $this->Common->convertStringNextPrev($dateSet['minuteNext'],$dateSet['secondsNext'])?></span>前を見る</a>
                            <?php 
                                }
                            ?>
                                
                            <?php 
                                if(!empty($dateSet['checkDisplayNext'])) {
                            ?>
                                <a data-id="nextDate"  class="mgR15 pull-right nextPrev cursorPointer"><span class="viewNextPrev"><?= $this->Common->convertStringNextPrev($dateSet['minuteNext'],$dateSet['secondsNext'])?></span>後を見る  >></a>
                            <?php 
                                }
                            ?>
                            
                        </td>
                    </tr>
                    <tr class="cap">
                        <th class="text-center tbW20">
                            <span>監視画像</span>
                        </th>
                        <td>
                            <div class="timeline">
                                <ul class="intervals" id="tl1">
                                    <?php foreach ($info["MONITOR"] as $valJpg) { ?>
                                        <?php if (!empty($valJpg['jpg'])){ ?>
                                            <a title="<?=$valJpg['date']?>" href="<?php echo $this->Common->checkFileJpg_A($info["UNIT_ID"], $valJpg['jpg']) ?>">
                                                <li class="first marking Tip" data-title="<?=$valJpg['date']?>">&nbsp;</li>
                                            </a>
                                        <?php }else{ ?>
                                            <li>&nbsp;</li>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            </div>
                            <p class="prev">
                                <a href="javascript:void(0)" onclick="window.open('<?php echo $this->Html->url(array("controller" => "Monitoring", "action" => "monitor_list",$unitData['Unit']['id'] )) ?>', '', 'scrollbars=1,width=512,height=900'); return false;">
                                監視画像一覧を表示
                                </a>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<!--メインコンテンツ終了-->
<?php $this->start("viewscript"); ?>
<?php echo $this->Html->script(array("jquery.datetimepicker.full","Chart", "jquery.fs.tipper.min", "graph", "jquery.magnific-popup.min")); ?>
<?php echo $this->Html->css(array("jquery.datetimepicker.min", "jquery.fs.tipper.min","magnific-popup")); ?>
<!--メインコンテンツ終了-->
<script>
    function getDataNow(){
        $('#idGetDataNow').val(1);
        $('#idMoStatus').submit();
    }
    $(document).ready(function () {
        $('.checkMax').keyup(function(){
           if(parseInt($(this).val()) > parseInt($(this).attr('max'))){
               $(this).val($(this).attr('max'));
           }
           if(parseInt($(this).val()) < parseInt($(this).attr('min'))){
               $(this).val($(this).attr('min'));
           }
        });
        var DIFF_PIX_DATA = '<?php echo $info["DIFF_PIX_DATA"] ?>';
        var MES_DATE_DATA = '<?php echo $info["MES_DATE_DATA"] ?>';
        var Threshold1 = '<?php echo $info["Threshold1"] ?>';
        var Threshold2 = '<?php echo $info["Threshold2"] ?>';
        var Threshold3 = '<?php echo $info["Threshold3"] ?>';
        setData(DIFF_PIX_DATA,MES_DATE_DATA,Threshold1,Threshold2,Threshold3);
        setGraph();
        $('.Tip').tipper();
        $('.datetimepicker').datetimepicker({
            setDate: new Date("<?=$dateSet['dateStart']?>"),
            timepicker: false,
            format: 'Y/m/d'
        });
        $('.intervals').magnificPopup({
            delegate: 'a',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile',
            closeOnBgClick: false,
            gallery: {
                enabled: true,
                navigateByImgClick: false,
                preload: [0,1] // Will preload 0 - before current, and 1 after the current image
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                titleSrc: function(item) {
                    return item.el.attr('title');
                }
            },
        });
        $('.submitForm').click(function(){
            $('#prevDate,#nextDate').val(0);
            $('#idMoStatus').submit();
        });
        $('.changeSubmit').change(function(){
            $('#prevDate,#nextDate').val(0);
            $('#idMoStatus').submit();
        });
        $('.nextPrev').click(function(){
            $('#prevDate,#nextDate').val(0);
            var dataId = $(this).attr('data-id');
            $('#'+ dataId).val(1);
            $('#idMoStatus').submit();
        });
        
    });
</script>
<?php $this->end(); ?>
