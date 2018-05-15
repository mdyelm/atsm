<div class="col-lg-12">
    <div class="newBlock">
        <p class="nopd nomg">以下の情報で編集します。よろしいでしょうか？</p>
    </div>
    <?php if (isset($data['users']['user_edit']['User'])): ?> 
        <?php $data = $data['users']['user_edit']['User']; ?>
    <?php elseif (isset($data['User'])): ?>
        <?php $data = $data['User']; ?>
    <?php else: ?>
        <input type="button" id="resendEr" class="resendEr" onClick="location.href = './'" style="display: none">
    <?php endif; ?>
    <?php
    echo $this->Form->create('User', array(
        'url' => array('controller' => 'Users', 'action' => 'user_edit_check'),
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
                        <?php
                        if (isset($data)) {
                            echo h($data['user_id']);
                        }
                        ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>担当者名 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        if (isset($data)) {
                            echo h($data['user_name']);
                        }
                        ?>
                    </label>
                </td>
            </tr> 
            <tr class="cap">
                <th class="tbW20">
                    <span>所属組織 <span style="color: red;">※</span></span>
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
                    <span>緊急連絡先 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        if (isset($data)) {
                            echo h($data['phone']);
                        }
                        ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>メールアドレス <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        if (isset($data)) {
                            echo h($data['mail_address']);
                        }
                        ?>
                    </label> 
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>システム権限 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        if (isset($data['role']) && isset($role[$data['role']])) {
                            echo h($role[$data['role']]);
                        }
                        ?>
                    </label> 
                </td>
            </tr>
            <?php if (isset($data['role']) && $data['role'] == 2): ?>
                <tr class="cap">
                    <th class="tbW20">
                        <span>閲覧許可ユニット <span style="color: red;">※</span></span>
                    </th>
                    <td>
                        <label class="pL5 dpUnit">
                            <?php
                            if (isset($data['dp_unit_id'])) {
                                $checkLastString = substr($data['dp_unit_id'], -1);
                                if ($checkLastString == '/') {
                                    $dp_unit_id = substr($data['dp_unit_id'], 0, -1);
                                } else {
                                    $dp_unit_id = $data['dp_unit_id'];
                                }
                            }
                            ?>
                            <?php
                            if (isset($data['dp_unit_id']) && isset($dp_unit_id)) {
                                echo h($dp_unit_id);
                            }
                            ?>
                        </label> 
                    </td>
                </tr>
            <?php endif; ?>
            <tr class="cap">
                <th class="tbW20">
                    <span>ユニット端末異常通知 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if (!empty($data['notification']) && isset(Configure::read("radio_notification")[$data['notification']])): ?>
                            <?php echo h(Configure::read("radio_notification")[$data['notification']]); ?>
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
        <input type="submit" class="btnS" value="編集"/>
        <?php
        echo $this->Html->link(
                '戻る', array(
            'controller' => 'Users',
            'action' => 'user_edit',
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
            <p>担当者情報を編集しました。</p>
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