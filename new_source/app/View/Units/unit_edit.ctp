<div class="col-lg-12">
    <div class="newBlock">
        <p class="nopd nomg">ユニット端末の編集したい項目を入力し、最後に「確認」ボタンを押してください。</p>
    </div>
    <?php
    echo $this->Form->create('Unit', array(
        'url' => array('controller' => 'Units', 'action' => 'unit_edit'),
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
                    <label class="pL5">
                        <?php if (isset($data)): ?>
                            <?php echo h($data['Unit']['unit_id']) ?>
                        <?php endif; ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>管理組織 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if ($userRole['role'] == 0): ?>
                            <?php
                            echo $this->Form->input('organization_id', array(
                                'options' => $organization_name,
                                'empty' => '選択してください',
                                'class' => 'inputNewDes',
                                'label' => false,
                                'div' => false
                            ));
                            ?>
                        <?php else: ?>
                            <?php echo h($organization_name[$data['Unit']['organization_id']]); ?>
                            <?= $this->Form->input('organization_id', array('type' => 'hidden')) ?>
                        <?php endif; ?>

                    </label>
                </td>
            </tr> 
            <tr class="cap">
                <th class="tbW20">
                    <span>ライセンス番号</span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if (!empty($data['Unit']['license_number'])): ?>
                            <?php echo h($data['Unit']['license_number']); ?>
                        <?php endif; ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
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
                    <label class="label_ex_date" style="margin-left: 15px">有効期限
                    </label>
                    <?php 
                    echo $this->Form->input('expiration_date', array('type' => 'text', 'style' => 'width: 20%', "class" => "inputNewDes w150 datetimepicker", 'label' => false, 'div' => false)); 
                    ?>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>稼働状況ステータス</span>
                </th>
                <td>
                    <label class="pL5">
                        <?php echo h(Configure::read('Unit.status')[$data['Unit']['status']]) ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>IPアドレス</span>
                </th>
                <td>
                    <label class="pL5">
                        <?php echo h($data['Unit']['ip_address']) ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>認証コード</span>
                </th>
                <td>
                    <label class="pL5">
                        <?php echo h($data['Unit']['authen_code']) ?>
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
    <?= $this->Form->input('unit_id', array('type' => 'hidden')) ?>
    <?= $this->Form->input('status', array('type' => 'hidden')) ?>
    <?= $this->Form->input('ip_address', array('type' => 'hidden')) ?>
    <?= $this->Form->input('id', array('type' => 'hidden')) ?>
    <?= $this->Form->input('license_number', array('type' => 'hidden')) ?>
    <?= $this->Form->input('place', array('type' => 'hidden')) ?>
    <?= $this->Form->input('authen_code', array('type' => 'hidden')) ?>
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
    $(document).ready(function () {
        $('.datetimepicker').datetimepicker({
            "setDate": new Date(),
            timepicker: false,
            format: 'Y/m/d'
        });
        checkDate($('#UnitLicenseType').val());
        $(document).on("change", "#UnitLicenseType", function () {
            var value = $(this).val();
            $(this).parent().next().next().next().text('');
            checkDate(value);
        });

    });
</script>
<?php $this->end(); ?>