<div class="col-lg-12">
    <div class="newBlock">
        <p class="nopd nomg">新しく登録したい担当者の情報を入力し、最後に「確認」ボタンを押してください。</p>
    </div>
    <?php
    echo $this->Form->create('User', array(
        'url' => array('controller' => 'Users', 'action' => 'user_regist'),
        'id' => 'formUsers',
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
                    <span>担当者ID</span>
                </th>
                <td>
                    <label class="pL5"></label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>担当者名 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        echo $this->Form->input('user_name', array(
                            'type' => 'text',
                            'class' => 'inputNewDes w300',
                            'placeholder' => '武居信行',
                            'label' => false,
                            'div' => false
                        ));
                        ?>
                    </label>
                    <span class="mgL10 opaText">全角30文字以内</span>
                </td>
            </tr> 
            <tr class="cap">
                <th class="tbW20">
                    <span>所属組織 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if ($userRole['role'] == 1 || $userRole['role'] == 2): ?>
                            <?php if (isset($org_full_name['Organization']['full_name'])): ?>
                                <?php echo h($org_full_name['Organization']['full_name']) ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php
                            echo $this->Form->input('organization_id', array(
                                'options' => $organization_name,
                                'empty' => '選択してください',
                                'class' => 'inputNewDes w300',
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
                    <span>緊急連絡先 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        echo $this->Form->input('phone', array(
                            'type' => 'text',
                            'class' => 'inputNewDes w300',
                            'placeholder' => '0336800480',
                            'label' => false,
                            'div' => false
                        ));
                        ?>
                    </label>
                    <span class="mgL10 opaText">20文字以内半角数字のみ(ハイフンなし)</span>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>メールアドレス <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        echo $this->Form->input('mail_address', array(
                            'type' => 'text',
                            'class' => 'inputNewDes w300',
                            'placeholder' => 'takei@example.com',
                            'label' => false,
                            'div' => false
                        ));
                        ?>
                    </label> 
                    <span class="mgL10 opaText">半角英数記号50文字以内</span>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>システム権限 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        echo $this->Form->input('role', array(
                            'options' => Configure::read('User.role1'),
                            'empty' => '選択してください',
                            'class' => 'inputNewDes w150',
                            'label' => false,
                            'div' => false
                        ));
                        ?>
                    </label> 
                </td>
            </tr>
            <tr class="cap permission_unit">
                <th class="tbW20">
                    <span>閲覧許可ユニット <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        echo $this->Form->input('select', array(
                            'type' => 'select',
                            'empty' => '選択してください',
                            'class' => 'inputNewDes w200 unit_id',
                            'label' => false,
                            'div' => false
                        ));
                        ?>
                    </label> 
                    <button type="button" class="add_unit btnE">追加</button>
                    <span class="dpUnit"></span>
                    <?php if (isset($error_unit_id)): ?>
                        <div class="error-message"><?php echo h($error_unit_id[0]); ?></div>
                    <?php endif; ?>

                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>ユニット端末異常通知 <span style="color: red;">※</span></span>
                </th>
                <td class="notification">
                    <label class="pL5">
                    </label> 
                    <?php
                    echo $this->Form->input('notification', array(
                        'options' => Configure::read('radio_notification'),
                        'type' => 'radio',
                        'separator' => '  ',
                        'legend' => false,
                        'class' => 'radio_mgl20',
                    ));
                    ?>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>パスワード <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        echo $this->Form->input('login_pw', array(
                            'type' => 'password',
                            'class' => 'inputNewDes w150',
                            'label' => false,
                            'maxlength' => 15,
                            'div' => false
                        ));
                        ?>
                    </label> 
                    <span class="mgL10 opaText">6文字から15文字以内半角英数字のみ</span>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>パスワード確認 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        echo $this->Form->input('password_confirm', array(
                            'type' => 'password',
                            'class' => 'inputNewDes w150',
                            'label' => false,
                            'maxlength' => 15,
                            'div' => false
                        ));
                        ?>
                    </label> 
                    <span class="mgL10 opaText">6文字から15文字以内半角英数字のみ</span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="pd14 text-center">
        <input type="submit" class="btnS" value="確認"/>
        <?php
        echo $this->Html->link(
                '戻る', array(
            'controller' => 'Users',
            'action' => 'index'
                ), array('class' => 'btnS')
        );
        ?>
    </div>
    <?php if ($userRole['role'] == 1 || $userRole['role'] == 2): ?>
        <?= $this->Form->input('organization_id', array('type' => 'hidden', 'value' => $userRole['organization_id'])) ?>
    <?php endif; ?>
    <?= $this->Form->input('unit_id', array('type' => 'hidden')) ?>
    <?= $this->Form->input('dp_unit_id', array('type' => 'hidden')) ?>
    <?= $this->Form->end(); ?>
</div>

<?php $this->start("viewscript"); ?>
<script>
    var data_unit_id = new Array();
    var value_unit = '';
    var dp_value_unit = '';

    function getUnit(data) {
        if (data.id == '') {
            $(".unit_id").html('<option value="">選択してください</option>');
            data_unit_id = [];
            value_unit = '';
            dp_value_unit = '';
            $(".dpUnit").text('')
            $('#UserUnitId').val('');
            $('#UserDpUnitId').val('');
        } else {
            var checkRole = <?php echo $userRole['role'] ?>;
            $.ajax({
                type: "POST",
                data: data, // You will get all the select data..
                url: '<?= Router::url(array('controller' => 'Users', 'action' => 'getUnit')) ?>',
                cache: false,
                timeout: 600000,
                dataType: 'json',
                success: function (data) {
                    var unitArr = '<option value="">選択してください</option>';
                    $.each(data.unit, function (index, el) {
                        unitArr += '<option value="' + index + '">' + el + '</option>';
                    });
                    $(".unit_id").html(unitArr);
                },
            });
            event.preventDefault();
            return false;
        }
    }

    $(document).ready(function () {
        // get value_unit and dp_value_unit
        if ($("#UserUnitId").val()) {
            value_unit = $("#UserUnitId").val();
            if (value_unit == 'all') {
                data_unit_id = 'all'
            } else {
                data_unit_id = value_unit.split(',');
            }
        }
        if ($("#UserDpUnitId").val()) {
            dp_value_unit = $("#UserDpUnitId").val();
            $(".dpUnit").text(dp_value_unit)
        }
        // change ユニット端末ID .
        $('#UserOrganizationId').on('change', function (event) {
            data_unit_id = [];
            value_unit = '';
            dp_value_unit = '';
            $(".dpUnit").text('')
            $('#UserUnitId').val('');
            $('#UserDpUnitId').val('');
            var data = {
                id: this.value
            };
            getUnit(data);
        });
        // change システム権限 
        $('#UserRole').on('change', function (event) {
            if (this.value == 2) {
                $(".permission_unit").show();
            } else {
                $(".permission_unit").hide();
            }
        });
        // add 閲覧許可ユニット
        $('.add_unit').on('click', function (event) {
            var valUnit = $(".unit_id option:selected").val();
            var textUnit = $(".unit_id option:selected").text();
            //check error validate
            if ($(this).next().next()) {
                $(this).next().next().css('display', 'none')
            }
            if (valUnit) {
                if (data_unit_id.indexOf(valUnit) == -1) {
                    if (valUnit == 'all') {
                        $(".dpUnit").text('全て')
                        data_unit_id = ['all'];
                        value_unit = 'all';
                        dp_value_unit = '全て';
                    } else {
                        var dpUnit = $(".dpUnit").text();
                        if (dpUnit == '全て') {
                            $(".dpUnit").text(textUnit)
                            data_unit_id = [];
                            data_unit_id.push(valUnit);
                            value_unit = valUnit + ',';
                            dp_value_unit = textUnit;
                        } else {
                            if (dpUnit) {
                                dpUnit += '/' + textUnit;
                                dp_value_unit += '/' + textUnit;
                            } else {
                                dpUnit = textUnit;
                                dp_value_unit = textUnit;
                            }
                            $(".dpUnit").text(dpUnit)
                            data_unit_id.push(valUnit);
                            value_unit += valUnit + ',';

                        }
                    }
                    $('#UserUnitId').val(value_unit);
                    $('#UserDpUnitId').val(dp_value_unit);
                }
            } else {
                $(".dpUnit").text('')
                value_unit = '';
                dp_value_unit = '';
                data_unit_id = [];
                $('#UserUnitId').val(value_unit);
                $('#UserDpUnitId').val(dp_value_unit);

            }
        });

        if ($("#UserRole").val() == 2) {
            $(".permission_unit").show();
        } else {
            $(".permission_unit").hide();
        }
        var dataUnit = {
            id: $('#UserOrganizationId').val()
        }
        if (dataUnit.id) {
            getUnit(dataUnit);
        }

    });
</script>
<?php $this->end(); ?>