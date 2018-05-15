<!--<h1>観測状況管理</h1>-->
<div class="col-lg-12 non-float m40">
    <div class="well bs-component">
        <table class="table table-hover font13">
            <tbody>
                <tr class="cap">
                    <th class="voidbackcoler">
                        <span class="tableView">クライアントID</span>
                        <label class="mL7"><?php echo $info['CLIENT_ID'] ?></label>
                    </th>
                  <!--<td><label>C-001</label></td>-->
                </tr>
                <tr class="cap">
                    <th class="voidbackcoler">
                        <span class="tableView">クライアント名</span>
                        <label class="mL7"><?php echo $info['CLIENT_NAME'] ?></label>
                    </th>
                </tr>
                <tr class="cap">
                    <th class="voidbackcoler">
                        <span class="tableView">観測場所</span>
                        <label class="mL10-6"><?php echo $info['PLACE'] ?></label>
                    </th>
                </tr>
                <tr class="cap">
                    <th class="voidbackcoler"><span class="tableView">画素差異数グラフ</span>
                        <div class="graphView" align="center">
                            <canvas id="chart" width="864" height="500"></canvas>
                        </div>
                    </th>
                </tr>
                <tr class="cap">
                    <th class="voidbackcoler"><span class="tableView">表示時間</span>
                        <?php echo $this->Form->input("Observation.display_time", array("type" => "select", "options" => Configure::read("display_time_select"), "id" => "display_time_select", "class" => "mL7", "div" => false, "label" => false)); ?>
<!--                        <select id="display_time_select" class="mL7">
                            <option value=1>1時間</option>
                            <option value=6>6時間</option>
                            <option value=12>12時間</option>
                            <option value=24>24時間</option>
                        </select>-->
                    </th>
                </tr>
                <tr class="cap">
                    <th class="voidbackcoler">
                        <span class="tableView">モニター画像</span>
                        <div class="timeline">
                            <ul class="intervals" id="tl1">
                                <?php if ($info["MONITOR"]): ?>
                                    <?php foreach ($info["MONITOR"] as $index => $monitor_date): ?>
                                        <?php if ($monitor_date != ""): ?>
                                            <a href="<?php echo $this->App->getMonitorImageURL($info["CLIENT_ID"], $monitor_date) ?>" data-lightbox="<?php echo "image" . $index ?>">
                                                <li class="first marking Tip" data-title="<?php echo $monitor_date ?>">&nbsp;</li>
                                            </a>
                                        <?php else: ?>
                                            <li>&nbsp;</li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <p class="prev">
                            <a href="javascript:void(0)" onclick="window.open('<?php echo $this->Html->url(array("controller" => "Pop", "action" => "observation_monitor_list", $info["ID"], $display_time)) ?>', '', 'width=512,height=900'); return false;">
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
<!--メインコンテンツ終了-->
<?php $this->start("viewscript"); ?>
<script>
    $(document).ready(function () {
//        $("#display_time_select").val(<?php // echo $display_time ?>);
        var diff_pix_data = '<?php echo $info["DIFF_PIX_DATA"] ?>';
        var mes_date_data = '<?php echo $info["MES_DATE_DATA"] ?>';
        var alert_diff_pix_data = '<?php echo $info["ALERT_DIFF_PIX_DATA"] ?>';
        setData(diff_pix_data, mes_date_data, alert_diff_pix_data);
        setGraph();
        $('.Tip').tipper();
        //各要素のdata属性にオプションを設定しています
        $("#display_time_select").change(function () {
            var display_time = $(this).val();
            location.href = '<?php echo $this->html->url(array("controller" => $this->name, "action" => "status", $info["ID"])) ?>/' + display_time;
        })
    });
</script>
<?php $this->end(); ?>