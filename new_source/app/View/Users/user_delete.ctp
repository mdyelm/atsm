<div class="col-lg-12">
    <div class="newBlock">
        <p class="nopd nomg">以下の担当者情報を削除します。よろしいでしょうか？</p>
    </div>
    <?php
    echo $this->Form->create('User', array(
        'url' => array('controller' => 'Users', 'action' => 'user_delete'),
        'id' => 'formUser',
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
                    <label class="pL5">
                        <?php if (isset($data['User']['user_id']) && !empty($data['User']['user_id'])): ?>
                            <?php echo h($data['User']['user_id']) ?>
                        <?php endif; ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>担当者名 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if (isset($data['User']['user_name']) && !empty($data['User']['user_name'])): ?>
                            <?php echo h($data['User']['user_name']) ?>
                        <?php else: ?>
                            0
                        <?php endif; ?>
                    </label>
                </td>
            </tr> 
            <tr class="cap">
                <th class="tbW20">
                    <span>所属組織 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if (isset($data['User']['organization_id']) && !empty($data['User']['organization_id'])): ?>
                            <?php echo h($organization_name[$data['User']['organization_id']]) ?>
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
                        <?php if (isset($data['User']['phone']) && !empty($data['User']['phone'])): ?>
                            <?php echo h($data['User']['phone']) ?>
                        <?php else: ?>
                            0
                        <?php endif; ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>メールアドレス <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if (isset($data['User']['mail_address']) && !empty($data['User']['mail_address'])): ?>
                            <?php echo h($data['User']['mail_address']) ?>
                        <?php endif; ?>
                    </label> 
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>システム権限 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if (isset($data['User']['role']) && !empty($data['User']['role'])): ?>
                            <?php echo h($role[$data['User']['role']]); ?>
                        <?php endif; ?>
                    </label> 
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>閲覧許可ユニット <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if (isset($data['User']['unit_id']) && !empty($data['User']['unit_id'])): ?>
                            <?php echo h($data['User']['unit_id']); ?>
                        <?php endif; ?>
                    </label> 
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>パスワード <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">**********</label> 
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>パスワード確認 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">**********</label> 
                </td>
            </tr>
        </tbody>
    </table>
    <div class="pd14 text-center">
        <input type="submit" class="btnS" value="削除"/>
        <?php
        echo $this->Html->link(
                '戻る', array(
            'controller' => 'Users',
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
            <p>担当者情報を削除しました。</p>
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