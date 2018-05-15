<div class="col-lg-12">
    <div class="newBlock">
        <p class="nopd nomg">以下の情報で登録します。よろしいでしょうか？</p>
    </div>
    <?php if (isset($data['users']['user_regist']['User'])): ?>
        <?php $o = $data['users']['user_regist']['User'] ?>
    <?php else: ?>
        <input type="button" id="resendEr" class="resendEr" onClick="location.href = './'" style="display: none">
    <?php endif; ?>
    <?php
    echo $this->Form->create('User', array(
        'url' => array('controller' => 'Users', 'action' => 'user_regist_check'),
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
                    <label class="pL5"></label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>担当者名 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5"><?php echo h($o['user_name']) ?></label>
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
                            if (isset($organization_name[$o['organization_id']])) {
                                echo h($organization_name[$o['organization_id']]);
                            }
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
                    <label class="pL5"><?php echo h($o['phone']) ?></label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>メールアドレス <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5"><?php echo h($o['mail_address']) ?></label> 
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>システム権限 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        if (isset($role[$o['role']])) {
                            echo h($role[$o['role']]);
                        }
                        ?>
                    </label> 
                </td>
            </tr>
            <?php if (isset($o['role']) && $o['role'] == 2): ?>
                <tr class="cap">
                    <th class="tbW20">
                        <span>閲覧許可ユニット <span style="color: red;">※</span></span>
                    </th>
                    <td>
                        <label class="pL5 dpUnit">
                            <?php
                            if (isset($o['dp_unit_id'])) {
                                $checkLastString = substr($o['dp_unit_id'], -1);
                                if ($checkLastString == '/') {
                                    $dp_unit_id = substr($o['dp_unit_id'], 0, -1);
                                } else {
                                    $dp_unit_id = $o['dp_unit_id'];
                                }
                            }
                            ?>
                            <?php
                            if (isset($o['dp_unit_id']) && isset($dp_unit_id)) {
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
                        <?php if (!empty($o['notification']) && isset(Configure::read("radio_notification")[$o['notification']])): ?>
                            <?php echo h(Configure::read("radio_notification")[$o['notification']]); ?>
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
        <input type="submit" class="btnS" value="登録"/>
        <?php
        echo $this->Html->link(
                '戻る', array(
            'controller' => 'Users',
            'action' => 'user_regist'
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
            <p>担当者情報を登録しました。</p>
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