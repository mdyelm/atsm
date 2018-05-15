<div class="col-lg-12 non-float m40">
    <div class="well bs-component">
        <table class="table table-hover font13">
            <tbody>
                <tr class="cap">
                    <th class="voidbackcoler">
                        <span class="tableView">クライアントID</span>
                        <label class="mL7"><?php echo h($info['CLIENT_ID']) ?></label>
                    </th>
                </tr>
                <tr class="cap">
                    <th class="voidbackcoler">
                        <span class="tableView">クライアント名</span>
                        <label class="mL7"><?php echo h($info['CLIENT_NAME']) ?></label>
                    </th>
                </tr>
                <tr class="cap">
                    <th class="voidbackcoler">
                        <span class="tableView">観測場所</span>
                        <label class="mL10-6"><?php echo h($info['PLACE']) ?></label>
                    </th>
                </tr>
            <th class="editborderstyle">
                <span class="tableView">アラート計測時間</span>
                <?php echo $this->Form->input("Alert.time", array("type" => "select", "options" => $info['ALERT_TIME'], "id" => "alert_time_select", "class" => "mL5-5", "div" => false, "label" => false)); ?>
            </th>
            <tr class="cap">
                <th class="voidbackcoler"><span class="tableView">画素差異数グラフ</span>
                    <div align="center" class="graphView">
                        <canvas id="chart" width="864" height="500"></canvas>
                    </div>
                </th>
            </tr>

            <tr class="cap">
                <th class="voidbackcoler">
                    <span class="tableView">モニター画像</span>
                    <div class="timeline">
                        <ul class="intervals" id="tl1" style="width: 100%">
                            <?php if ($info["MONITOR"]): ?>
                                <?php $width = round(864 / ceil(count($info["MONITOR"]))); ?>
                                <?php foreach ($info["MONITOR"] as $index => $monitor_date): ?>
                                    <?php if ($monitor_date != ""): ?>
                                        <a href="<?php echo $this->App->getMonitorImageURL($info["CLIENT_ID"], $monitor_date) ?>" data-lightbox="<?php echo "image" . $index ?>">
                                            <li class="first marking Tip" data-title="<?php echo $monitor_date ?>" style="width: <?php echo $width ?>px">&nbsp;</li>
                                        </a>
                                    <?php else: ?>
                                        <li style="width: <?php echo $width ?>px">&nbsp;</li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <p class="prev">
                        <a href="javascript:void(0)" onclick="window.open('<?php echo $this->Html->url(array("controller" => "Pop", "action" => "alert_monitor_list", $info["ID"], $info["ALERT_ID"])) ?>', '', 'width=512,height=900'); return false;">
                            <?php echo $this->Html->image("arrow.png", array("class" => "arrow")) ?>モニター画像一覧を表示
                        </a>
                    </p>
                </th>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<?php echo $this->Html->script("graph"); ?>
<?php $this->start("viewscript"); ?>
<script>
    $(window).load(function () {
//        $("#alert_time_select").val(<?php // echo $info["ALERT_ID"] ?>);
        var diff_pix_data = '<?php echo $info["DIFF_PIX_DATA"] ?>';
        var mes_date_data = '<?php echo $info["MES_DATE_DATA"] ?>';
        var alert_diff_pix_data = '<?php echo $info["ALERT_DIFF_PIX_DATA"] ?>';
        setData(diff_pix_data, mes_date_data, alert_diff_pix_data);
//        setGraph();
        var alert_start = '<?php echo $info["ALERT_START"] ?>';
        var alert_end = '<?php echo $info["ALERT_END"] ?>';
        setGraph2Line(alert_start, alert_end);
        $('.Tip').tipper();
        //各要素のdata属性にオプションを設定しています
        $("#alert_time_select").change(function () {
            var alert_time = $(this).val();
            location.href = '<?php echo $this->html->url(array("controller" => $this->name, "action" => "status", $info["ID"])) ?>/' + alert_time;
        })
    });
</script>
<?php $this->end(); ?>

