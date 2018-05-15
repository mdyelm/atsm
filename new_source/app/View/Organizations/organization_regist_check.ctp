<div class="col-lg-12">
    <div class="newBlock">
        <p class="nopd nomg">以下の情報で新規作成します。よろしいでしょうか？</p>
    </div>
    <?php if (isset($data['organizations']['organization_regist']['Organization'])): ?>
        <?php $o = $data['organizations']['organization_regist']['Organization'] ?>
    <?php else: ?>
        <input type="button" id="resendEr" class="resendEr" onClick="location.href = './'" style="display: none">
    <?php endif; ?>
    <?php
    echo $this->Form->create('Organization', array(
        'url' => array('controller' => 'Organizations', 'action' => 'organization_regist_check'),
        'id' => 'formOrganization',
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
                    <span>組織ID</span>
                </th>
                <td>
                    <label class="pL5"></label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>組織名 <span style="color: red;">※</span></span></span>
                </th>
                <td>
                    <label class="pL5"><?php echo h($o['organization_name']) ?>　</label>
                </td>
            </tr> 
            <tr class="cap">
                <th class="tbW20">
                    <span>担当部署</span>
                </th>
                <td>
                    <label class="pL5"><?php echo h($o['position']) ?>　</label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>代表電話番号 <span style="color: red;">※</span></span></span>
                </th>
                <td>
                    <label class="pL5"><?php echo h($o['phone']) ?></label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>代表メールアドレス <span style="color: red;">※</span></span></span>
                </th>
                <td>
                    <label class="pL5"><?php echo h($o['mail_address']) ?></label> 
                </td>
            </tr>
        </tbody>
    </table>
    <div class="pd14 text-center">
        <input type="submit" class="btnS" value="登録"/>
        <?php
        echo $this->Html->link(
                '戻る', array(
            'controller' => 'Organizations',
            'action' => 'organization_regist'
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
            <p>組織情報を登録しました。</p>
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