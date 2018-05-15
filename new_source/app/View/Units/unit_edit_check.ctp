<div class="col-lg-12">
    <div class="newBlock">
        <p class="nopd nomg">以下の情報で編集します。よろしいでしょうか？</p>
    </div>
    <?php if (isset($data['units']['unit_edit']['Unit'])): ?> 
        <?php $data = $data['units']['unit_edit']['Unit']; ?>
    <?php elseif (isset($data['Unit'])): ?>
        <?php $data = $data['Unit']; ?>
    <?php else: ?>
        <input type="button" id="resendEr" class="resendEr" onClick="location.href = './'" style="display: none">
    <?php endif; ?>
    <?php
    echo $this->Form->create('Unit', array(
        'url' => array('controller' => 'Units', 'action' => 'unit_edit_check'),
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
                        <?php
                        if (isset($data)) {
                            echo h($data['unit_id']);
                        }
                        ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>管理組織 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        if (isset($data['organization_id']) && isset($organization_name[$data['organization_id']])) {
                            echo h($organization_name[$data['organization_id']]);
                        }
                        ?>
                    </label>
                </td>
            </tr> 
            <tr class="cap">
                <th class="tbW20">
                    <span>ライセンス番号</span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if (!empty($data['license_number'])): ?>
                            <?php echo h($data['license_number']); ?>
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
                        if (isset(Configure::read('License.type')[$data['license_type']]) && !empty(Configure::read('License.type')[$data['license_type']])) {
                            echo h(Configure::read('License.type')[$data['license_type']]);
                        }
                        ?>
                        <?php
                        if (isset($data['license_type']) && $data['license_type'] == 1) {
                            echo h('試用期限 ' . $data['expiration_date']);
                        }
                        ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>稼働状況ステータス</span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        if (isset($data['status']) && isset($status[$data['status']])) {
                            echo h($status[$data['status']]);
                        }
                        ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>IPアドレス</span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        if (isset($data)) {
                            echo h($data['ip_address']);
                        }
                        ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>認証コード</span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        if (isset($data)) {
                            echo h($data['authen_code']);
                        }
                        ?>
                    </label>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="pd14 text-center">
        <input type="submit" class="btnS" value="編集"/>
        <?php
        echo $this->Html->link(
                '戻る', array(
            'controller' => 'Units',
            'action' => 'unit_edit',
            $data['id'],
            1
                ), array('class' => 'btnS')
        );
        ?>
    </div>
    <?= $this->Form->end(); ?>
</div>
<!--確認メッセージ用-->
<div id="modal">
    <div id="open01">
        <div class="close_overlay"></div>
        <span class="modal_window">
            <h2>確認</h2>
            <p>ユニット端末情報を編集しました。</p>
            <input type="button" value="はい" onClick="location.href = './'">
        </span><!--/.modal_window-->
    </div><!--/#open01-->
</div>
<!--END-->
<?php $this->start("viewscript"); ?>
<script>
    $(function () {
        var check_reg = <?php echo $checkEdit; ?>;
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