<?php
$date_year = array(
    "2013" => "2013",
    "2014" => "2014",
    "2015" => "2015",
    "2016" => "2016"
);
$date_month = array(
    "1" => "1",
    "2" => "2",
    "3" => "3",
    "4" => "4",
    "5" => "5",
    "6" => "6",
    "7" => "7",
    "8" => "8",
    "9" => "9",
    "10" => "10",
    "11" => "11",
    "12" => "12"
);
$date_day = array(
    "1" => "1",
    "2" => "2",
    "3" => "3",
    "4" => "4",
    "5" => "5",
    "6" => "6",
    "7" => "7",
    "8" => "8",
    "9" => "9",
    "10" => "10",
    "11" => "11",
    "12" => "12",
    "13" => "13",
    "14" => "14",
    "15" => "15",
    "16" => "16",
    "17" => "17",
    "18" => "18",
    "19" => "19",
    "20" => "20",
    "21" => "21",
    "22" => "22",
    "23" => "23",
    "24" => "24",
    "25" => "25",
    "26" => "26",
    "27" => "27",
    "28" => "28",
    "29" => "29",
    "30" => "30",
    "31" => "31"
);
?>
<div class="col-lg-12 non-float m40">
    <?php echo $this->Session->flash(); ?>
    <div class="well bs-component">
        <table class="table font13">
            <tbody>
                <tr class="cap">
                    <th class="editborderstyle">クライアントID</th>
                    <td>
                        <label for="inputEmail" class="control-label mgn9">
                            <?php echo $client["client_id"] ?>
                        </label>
                    </td>
                </tr>
                <tr class="cap">
                    <th class="editborderstyle">クライアント名</th>
                    <td>
                        <label for="inputEmail" class="control-label mgn9">
                            <?php echo $client["client_name"] ?>
                        </label>
                    </td>
                </tr>
                <tr class="cap">
                    <th class="editborderstyle">観測場所</th>
                    <td>
                        <label for="inputEmail" class="control-label mgn9">
                            <?php echo $client["place"] ?>
                        </label>
                    </td>
                </tr>
                <tr class="cap">
                    <th class="editborderstyle">観測データ出力</th>
                    <td>
                        <?php echo $this->Form->create("csvDownloadForm", array("type" => "post", "url" => array("controller" => $this->name, "action" => "download_csv", $client["id"], $client["client_id"]))) ?>
                        <div>
                            <?php echo $this->Form->input("CSVLog.start_date", array("type" => "text", "class" => "form-cont3 widqt datetimepicker", "label" => false, "div" => false)) ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;～&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $this->Form->input("CSVLog.end_date", array("type" => "text", "class" => "form-cont3 widqt datetimepicker", "label" => false, "div" => false)) ?>
                            <!--
                            <?php echo $this->Form->input("CSVLog.start_date.year", array("type" => "select", "options" => $date_year, "class" => "form-cont3 wid11", "label" => false, "div" => false)) ?>
                            年
                            <?php echo $this->Form->input("CSVLog.start_date.month", array("type" => "select", "options" => $date_month, "class" => "form-cont3", "label" => false, "div" => false)) ?>
                            月
                            <?php echo $this->Form->input("CSVLog.start_date.day", array("type" => "select", "options" => $date_day, "class" => "form-cont3", "label" => false, "div" => false)) ?>
                            日&nbsp;&nbsp;&nbsp;&nbsp;～
                            <?php echo $this->Form->input("CSVLog.end_date.year", array("type" => "select", "options" => $date_year, "class" => "form-cont3 wid11", "label" => false, "div" => false)) ?>
                            年
                            <?php echo $this->Form->input("CSVLog.end_date.month", array("type" => "select", "options" => $date_month, "class" => "form-cont3", "label" => false, "div" => false)) ?>
                            月
                            <?php echo $this->Form->input("CSVLog.end_date.day", array("type" => "select", "options" => $date_day, "class" => "form-cont3", "label" => false, "div" => false)) ?>
                            日
                            -->
                            <?php echo $this->Form->submit("CSVダウンロード", array("class" => "btn btn-def2 btn-mgnR20 mgn10", "style" => "float:right", "div" => false, "id" => "csv_download_btn")) ?>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </td>
                </tr>
                <tr class="cap">
                    <th class="editborderstyle">静止画像ダウンロード</th>
                    <td>
                        <?php echo $this->Form->create("imageDownloadForm", array("type" => "post", "url" => array("controller" => $this->name, "action" => "download_image", $client["id"], $client["client_id"]))) ?>
                        <div>
                            <?php echo $this->Form->input("ImageLog.date", array("type" => "text", "class" => "form-cont3 widqt datetimepicker", "label" => false, "div" => false)) ?>
                            <!--
                            <?php // echo $this->Form->input("ImageLog.date.year", array("type" => "select", "options" => $date_year, "class" => "form-cont3 wid11", "label" => false, "div" => false)) ?>
                            年
                            <?php // echo $this->Form->input("ImageLog.date.month", array("type" => "select", "options" => $date_month, "class" => "form-cont3", "label" => false, "div" => false)) ?>
                            月
                            <?php // echo $this->Form->input("ImageLog.date.day", array("type" => "select", "options" => $date_day, "class" => "form-cont3", "label" => false, "div" => false)) ?>
                            日
                            -->
                            <?php echo $this->Form->submit("画像ダウンロード", array("class" => "btn btn-def2 btn-mgnR20 mgn10", "style" => "float:right", "div" => false, "id" => "image_download_btn")) ?>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php $this->start("viewscript"); ?>
<?php echo $this->Html->css(array("jquery.datetimepicker.min")); ?>
<?php echo $this->Html->script(array("jquery.datetimepicker.full")); ?>
<script>
    $("#csv_download_btn, #image_download_btn").click(function () {
        $(".message").hide();
    })
    $(document).ready(function () {
        $(".datetimepicker").datetimepicker({
            timepicker: false,
            format: 'Y/m/d'
        })
    })
</script>
<?php $this->end(); ?>