<div class="col-lg-12">
    <div class="newBlock">
        <p class="nopd nomg">過去のログデータ、静止画像がダウンロードできます。</p>
        <p class="nopd nomg">期間の設定を行い、それぞれダウンロードボタンをクリックしてください。</p>
    </div>
    <?php echo $this->Session->flash('errorData'); ?>
    <?=
    $this->Form->create('Data', array(
        'url' => array('controller' => 'Admin', 'action' => '#'),
        'class' => 'form-horizontal',
        'id' => 'formDownload',
        'inputDefaults' => array(
            'error' => false,
        )
    ))
    ;
    ?>
    <table class="table font13">
        <tbody>
            <tr class="cap">
                <th class="tbW20">
                    <span>組織名</span>
                </th>
                <td>
                    <label class="pdL5" id="nameOrg">
                        <?php if ($userRole['role'] == 0): ?>
                        <?php elseif ($userRole['role'] == 1 || $userRole['role'] == 2): ?>
                            <?php echo h($userRole['organization_name']); ?>
                        <?php endif; ?>
                    </label>
                </td>
                <!--<td><label>C-001</label></td>-->
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>ユニット端末ID</span>
                </th>
                <td>
                    <label class="pdL5">
                        <?php
                        echo $this->Form->input('unit_id', array(
                            'options' => $unit,
                            'id' => 'selUnit',
                            'class' => 'inputNewDes w300',
                            'empty' => '-----------------',
                            'label' => false,
                            'div' => false
                        ));
                        ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>ログデータ出力</span>
                </th>
                <td>
                    <!--<label class="pdL5">-->
                    <?php echo $this->Form->input('start_date', array('type' => 'text', "class" => "inputNewDes w150 datetimepicker text-center", 'label' => false, 'div' => false)); ?>
                    <?php
                    echo $this->Form->input('start_time', array(
                        'options' => configure::read('time_csv'),
                        'class' => 'inputNewDes w50 text-center mgL15',
                        'empty' => '---',
                        'label' => false,
                        'div' => false
                    ));
                    ?>
                    <span class="mgL10">時</span>
                    <span class="mgC20">～</span>
                    <?php echo $this->Form->input('end_date', array('type' => 'text', "class" => "inputNewDes w150 datetimepicker text-center", 'label' => false, 'div' => false)); ?>
                    <?php
                    echo $this->Form->input('end_time', array(
                        'options' => configure::read('time_csv'),
                        'class' => 'inputNewDes w50 text-center mgL15',
                        'empty' => '---',
                        'label' => false,
                        'div' => false
                    ));
                    ?>
                    <span class="mgL10">時</span>
                    <input type="button" class="mgC15 text-center pull-right btnEx downloadCSV" data-bind="CSV" value="ダウンロード">
                    <!--</label>-->
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>静止画像ダウンロード</span>
                </th>
                <td>
                    <?php echo $this->Form->input('img_date', array('type' => 'text', "class" => "inputNewDes w150 datetimepicker text-center", 'label' => false, 'div' => false)); ?>
                    <?php
                    echo $this->Form->input('img_time', array(
                        'options' => configure::read('time_img'),
                        'class' => 'inputNewDes w50 text-center mgL15',
                        'empty' => '---',
                        'label' => false,
                        'div' => false
                    ));
                    ?>
                    <span class="mgL10">時</span>
                    <input type="button" class="mgC15 text-center pull-right btnEx downloadCSV" data-bind="Img" value="ダウンロード">
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>解析画像ダウンロード</span>
                </th>
                <td>
                    <?php echo $this->Form->input('img_date2', array('type' => 'text', "class" => "inputNewDes w150 datetimepicker text-center", 'label' => false, 'div' => false)); ?>
                    <?php
                    echo $this->Form->input('img_time2', array(
                        'options' => configure::read('time_img'),
                        'class' => 'inputNewDes w50 text-center mgL15',
                        'empty' => '---',
                        'label' => false,
                        'div' => false
                    ));
                    ?>
                    <span class="mgL10">時</span>
                    <input type="button" class="mgC15 text-center pull-right btnEx downloadCSV" data-bind="Img2" value="ダウンロード">
                </td>
            </tr>
        </tbody>
    </table>
    <?= $this->Form->input('check_type', array('type' => 'hidden')); ?>
    <?= $this->Form->end(); ?>
</div>
<?php $this->start("viewscript"); ?>
<?php echo $this->Html->css("jquery.datetimepicker.min"); ?>
<?php echo $this->Html->script("jquery.datetimepicker.full"); ?>
<script>
    $(document).ready(function () {
        $('.datetimepicker').datetimepicker({
            "setDate": new Date(),
            timepicker: false,
            format: 'Y/m/d'
        });

        function checkNameOrg(data) {
            var checkRole = <?php echo $userRole['role'] ?>;
            $.ajax({
                type: "POST",
                data: data, // You will get all the select data..
                url: '<?= Router::url(array('controller' => 'Datas', 'action' => 'selectUnit')) ?>',
                cache: false,
                timeout: 600000,
                dataType: 'json',
                success: function (data) {
                    if (checkRole == 1 || checkRole == 2) {

                    } else {
                        $('#nameOrg').html(data.name);
                    }
                },
            });
            event.preventDefault();
            return false;
        }
        // change ユニット端末ID 
        $('#selUnit').on('change', function (event) {
            var data = {
                id: this.value
            };
            checkNameOrg(data);
        });
        var dataOrg = {
            id: $('#selUnit').val()
        }
        if (dataOrg.id) {
            checkNameOrg(dataOrg);
        }
        // download csv
        $(document).on("click", ".downloadCSV", function (event) {
            event.preventDefault();
            var type = $(this).attr('data-bind')
            $('#DataCheckType').val(type);
            $('#formDownload').attr('action', '<?= Router::url(array('controller' => 'Datas', 'action' => 'export_data')); ?>');
            $('#formDownload').submit();
            $('#flashMessage').css('display', 'none');
            $('#errorDataMessage').css('display', 'none');
        });
        // format hour

//        $('.hour').bind("change paste keyup", function () {
//            this.value = this.value.replace(/\./g, "");
//            if (!$.isNumeric($(this).val())) {
//                $(this).val('');
//            }
//            if ($(this).val() > 23) {
//                $(this).val(23);
//            }
//        });
    });
</script>
<?php $this->end(); ?>