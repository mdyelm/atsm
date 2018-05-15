<div class="col-lg-12">
    <div class="newBlock">
        <p class="nopd nomg">以下の情報で登録します。よろしいでしょうか？</p>
    </div>
    <?php if (isset($data['units']['unit_regist']['Unit'])): ?>
        <?php $o = $data['units']['unit_regist']['Unit'] ?>
    <?php else: ?>
        <input type="button" id="resendEr" class="resendEr" onClick="location.href = './'" style="display: none">
    <?php endif; ?>
    <?php
    echo $this->Form->create('Unit', array(
        'url' => array('controller' => 'Units', 'action' => 'unit_regist_check'),
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
                        <?php
                        if (isset($organization_name[$o['organization_id']])) {
                            echo h($organization_name[$o['organization_id']]);
                        }
                        ?>
                    </label>
                </td>
            </tr> 
            <tr class="cap">
                <th class="tbW20">
                    <span>ライセンス番号発行 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        if (isset($o['license_number'])) {
                            echo h($o['license_number']);
                        }
                        ?>
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
                        if (isset(Configure::read('License.type')[$o['license_type']]) && !empty(Configure::read('License.type')[$o['license_type']])) {
                            echo h(Configure::read('License.type')[$o['license_type']]);
                        }
                        ?>
                        <?php
                        if (isset($o['license_type']) && $o['license_type'] == 1) {
                            echo h('試用期限 ' . $o['expiration_date']);
                        }
                        ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>認証コード <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        if (isset($o['authen_code'])) {
                            echo h($o['authen_code']);
                        }
                        ?>
                    </label>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="pd14 text-center">
        <input type="submit" class="btnS" value="登録"/>
        <?php
        echo $this->Html->link(
                '戻る', array(
            'controller' => 'Units',
            'action' => 'unit_regist'
                ), array('class' => 'btnS')
        );
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<!--確認メッセージ用-->
<div id="modal">
    <div id="open01">
        <div class="close_overlay"></div>
        <span class="modal_window">
            <h2>確認</h2>
            <p>ユニット端末情報を登録しました。</p>
            <input type="button" value="はい" onClick="location.href = './'">
        </span><!--/.modal_window-->
    </div><!--/#open01-->
</div>
<!--END-->
<?php $this->start("viewscript"); ?>
<script>
    $(function () {
        var check_reg = <?php echo $checkReg; ?>;
        if (check_reg === 1) {
            location.href = '#open01';
        }
        // check resend page 
        if ($("#resendEr").hasClass("resendEr")) {
            $(".resendEr").click();
        }
    });
</script>
<?php $this->end(); ?>