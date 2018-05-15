<div class="col-lg-12">
    <div class="newBlock">
        <p class="nopd nomg">新しく登録したいユニット端末の情報を入力し、最後に「確認」ボタンを押してください。</p>
    </div>
    <?php
    echo $this->Form->create('Unit', array(
        'url' => array('controller' => 'Units', 'action' => 'unit_regist'),
        'id' => 'formUnit',
        'class' => 'form-horizontal',
        'inputDefaults' => array(
            'label' => false,
            'div' => false,
            'required' => false,
    )));
    ?>
    <table class="table font13">
        <tbody>
            <tr class="cap">
                <th class="tbW20">
                    <span>ユニット端末ID</span>
                </th>
                <td>
                    <label class="pL5"></label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>管理組織 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if ($userRole['role'] == 1): ?>
                            <?php echo h($org_full_name['Organization']['full_name']); ?>
                            <?php echo $this->Form->input('organization_id', array('type' => 'hidden', 'value' => $userRole['organization_id'])); ?>
                        <?php else: ?>
                            <?php
                            echo $this->Form->input('organization_id', array(
                                'options' => $organization_name,
                                'empty' => '選択してください',
                                'class' => 'inputNewDes',
                                'label' => false,
                                'div' => false
                            ));
                            ?>
                        <?php endif; ?>

                    </label>
                </td>
            </tr> 
            <tr class="cap">
                <th class="tbW20">
                    <span>ライセンス番号発行 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <button type="button" class="btLicense btnEx btnEx2">ライセンス番号発行</button>
                        <?php if (isset($erLicense)): ?>
                            <div class = "error-message"><?php echo h($erLicense[0]); ?></div>
                        <?php endif; ?>
                    </label>

                    <label class="pL5 license_number">
                        <?php if (isset($data['license_number']) && !empty($data['license_number'])): ?>
                            <?php echo h($data['license_number']); ?>
                        <?php endif; ?>
                    </label>
                    <?php if (isset($data['authen_code']) && !empty($data['authen_code'])): ?>
                        <label class="pL5 label_auth">認証コード: 
                            <span class="authen_code">
                                <?php echo h($data['authen_code']); ?>
                            </span>
                        </label>
                    <?php else: ?>
                        <label class="pL5 label_auth" style="display: none;">認証コード: 
                            <span class="authen_code"></span>
                        </label>
                    <?php endif; ?>
                </td>
            </tr>
            <tr class="cap exp_date">
                <th class="tbW20">
                    <span>ライセンス種別 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        echo $this->Form->input('license_type', array(
                            'options' => Configure::read('License.type'),
//                            'empty' => '---',
                            'class' => 'inputNewDes w80',
                            'label' => false,
                            'div' => false,
                        ));
                        ?>
                    </label>
                    <label class="label_ex_date" style="margin-left: 15px">
                        <?php if (isset($data['expiration_date']) && !empty($data['expiration_date'])): ?>
                            <?php echo h('有効期限: ' . $data['expiration_date']); ?>
                        <?php endif; ?>
                    </label>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="pd14 text-center">
        <input type="submit" class="btnS" value="確認"/>
        <?php
        echo $this->Html->link(
                '戻る', array(
            'controller' => 'Units',
            'action' => 'index'
                ), array('class' => 'btnS')
        );
        ?>
    </div>
    <?php echo $this->Form->input('license_number', array('type' => 'hidden')); ?>
    <?php echo $this->Form->input('authen_code', array('type' => 'hidden')); ?>
    <?php echo $this->Form->input('expiration_date', array('type' => 'hidden')); ?>
    <?= $this->Form->end(); ?>
</div>
<?php $this->start("viewscript"); ?>
<?php echo $this->Html->css("jquery.datetimepicker.min"); ?>
<?php echo $this->Html->script("jquery.datetimepicker.full"); ?>
<script>
    function checkDate(val) {
        if (val == 1) {
            $('#UnitExpirationDate').css('display', 'inline-block');
            $('.label_ex_date').css('display', 'inline-block');
        } else if (val == 2) {
//            $('.expiration').text('');
//            $('.error-message').text('');
            $('#UnitExpirationDate').css('display', 'none');
            $('.label_ex_date').css('display', 'none');
        }
    }
    function getLicese(data) {
        $.ajax({
            type: "POST",
//            data: data, // You will get all the select data..
            url: '<?= Router::url(array('controller' => 'Units', 'action' => 'getLiceseNumber')) ?>',
            cache: false,
            timeout: 600000,
            dataType: 'json',
            success: function (data) {
                $(".license_number").text(data.licenseNumber);
                $("#UnitLicenseNumber").val(data.licenseNumber);
                $(".authen_code").text(data.authenCodeLicense);
                $("#UnitAuthenCode").val(data.authenCodeLicense);
                $(".label_auth").css('display', 'inline-block');
                $("#UnitExpirationDate").val(data.expDate);
                $(".label_ex_date").text('有効期限: ' + data.expDate);
                $(".exp_date").show();
            },
        });
        event.preventDefault();
        return false;
    }
    $(document).ready(function () {
        $('.datetimepicker').datetimepicker({
            "setDate": new Date(),
            timepicker: false,
            format: 'Y-m-d'
        });
        checkDate($('#UnitLicenseType').val());
        $(document).on("change", "#UnitLicenseType", function () {
            var value = $(this).val();
            $(this).parent().next().next().next().text('');
            checkDate(value);
        });
        // get license number
        $(".btLicense").on("click", function () {
            $(this).next().text('');
            getLicese();
        });
        var checkLicenseNB = '<?php echo $data['license_number'] ?>';
        if (checkLicenseNB) {
            $(".exp_date").show();
        }
    });
</script>
<?php $this->end(); ?>