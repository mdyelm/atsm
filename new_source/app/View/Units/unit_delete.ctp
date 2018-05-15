<div class="col-lg-12">
    <div class="newBlock">
        <p class="nopd nomg">以下のユニット端末を削除します。よろしいでしょうか？</p>
    </div>
    <?php
    echo $this->Form->create('Unit', array(
        'url' => array('controller' => 'Units', 'action' => 'unit_delete'),
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
                        <?php if (isset($data['Unit']['unit_id']) && !empty($data['Unit']['unit_id'])): ?>
                            <?php echo h($data['Unit']['unit_id']) ?>
                        <?php endif; ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>管理組織</span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        if (isset($data['Unit']['organization_id']) && isset($organization_name[$data['Unit']['organization_id']])) {
                            echo h($organization_name[$data['Unit']['organization_id']]);
                        }
                        ?>
                    </label>
                </td>
            </tr> 
            <tr class="cap">
                <th class="tbW20">
                    <span>ライセンス番号発行</span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if (isset($data['Unit']['license_number']) && !empty($data['Unit']['license_number'])): ?>
                            <?php echo h($data['Unit']['license_number']) ?>
                        <?php endif; ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>ライセンス種別</span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        if (isset(Configure::read('License.type')[$data['Unit']['license_type']]) && !empty(Configure::read('License.type')[$data['Unit']['license_type']])) {
                            echo h(Configure::read('License.type')[$data['Unit']['license_type']]);
                        }
                        ?>
                        <?php
                        if (isset($data['Unit']['license_type']) && $data['Unit']['license_type'] == 1) {
                            echo h('試用期限 ' . $data['Unit']['expiration_date']);
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
                        <?php if (isset($data['Unit']['status']) && !empty($status[$data['Unit']['status']])): ?>
                            <?php echo h($status[$data['Unit']['status']]) ?>
                        <?php endif; ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>IPアドレス</span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if (isset($data['Unit']['ip_address']) && !empty($data['Unit']['ip_address'])): ?>
                            <?php echo h($data['Unit']['ip_address']) ?>
                        <?php endif; ?>
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
                        if (isset($data['Unit']['authen_code'])) {
                            echo h($data['Unit']['authen_code']);
                        }
                        ?>
                    </label>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="pd14 text-center">
        <input type="submit" class="btnS" value="削除"/>
        <?php
        echo $this->Html->link(
                '戻る', array(
            'controller' => 'Units',
            'action' => 'index'
                ), array('class' => 'btnS')
        );
        ?>
    </div>
    <?= $this->Form->input('id', array('type' => 'hidden')) ?>
    <?= $this->Form->end(); ?>
</div>
<!--確認メッセージ用-->
<div id="modal">
    <div id="open01">
        <div class="close_overlay"></div>
        <span class="modal_window">
            <h2>確認</h2>
            <p>ユニット端末情報を削除しました。</p>
            <input type="button" value="はい" onClick="location.href = '../'">
        </span><!--/.modal_window-->
    </div><!--/#open01-->
</div>
<!--END-->
<?php $this->start("viewscript"); ?>
<script>
    $(function () {
        var check_reg = <?php echo $checkDel; ?>;
        console.log(check_reg);
        if (check_reg === 1) {
            location.href = '#open01';
        }
    });
</script>
<?php $this->end(); ?>