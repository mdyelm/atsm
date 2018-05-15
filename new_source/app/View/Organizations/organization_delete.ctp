<div class="col-lg-12">
    <div class="newBlock">
        <p class="nopd nomg">以下の組織情報を削除します。よろしいでしょうか？</p>
    </div>
    <?php
    echo $this->Form->create('Organization', array(
        'url' => array('controller' => 'Organizations', 'action' => 'organization_delete', $org_id),
        'id' => 'formOrganization',
        'class' => 'form-horizontal',
        'inputDefaults' => array(
            'label' => false,
            'div' => false,
    )));
    ?>
    <table class="table font13">
        <tbody>
            <tr class="cap">
                <th class="tbW20">
                    <span>組織ID <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if (isset($data['Organization']['organization_id']) && !empty($data['Organization']['organization_id'])): ?>
                            <?php echo h($data['Organization']['organization_id']) ?>
                        <?php endif; ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>組織名 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if (isset($data['Organization']['organization_name']) && !empty($data['Organization']['organization_name'])): ?>
                            <?php echo h($data['Organization']['organization_name']) ?>
                        <?php else: ?>
                            0
                        <?php endif; ?>
                    </label>
                </td>
            </tr> 
            <tr class="cap">
                <th class="tbW20">
                    <span>担当部署</span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if (isset($data['Organization']['position'])): ?>
                            <?php echo h($data['Organization']['position']) ?>
                        <?php endif; ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>代表電話番号 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if (isset($data['Organization']['phone']) && !empty($data['Organization']['phone'])): ?>
                            <?php echo h($data['Organization']['phone']) ?>
                        <?php else: ?>
                            0
                        <?php endif; ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>代表メールアドレス <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if (isset($data['Organization']['mail_address']) && !empty($data['Organization']['mail_address'])): ?>
                            <?php echo h($data['Organization']['mail_address']) ?>
                        <?php endif; ?>
                    </label> 
                </td>
            </tr>
        </tbody>
    </table>
    <div class="pd14 text-center">
        <!--<input type="submit" class="btnS" value="削除"/>-->
        <input type="button" class="btnS" value="削除" onClick="location.href = '#open02'"/>

        <?php
        echo $this->Html->link(
                '戻る', array(
            'controller' => 'Organizations',
            'action' => 'index'
                ), array('class' => 'btnS')
        );
        ?>
    </div>
    <?= $this->Form->input('id', array('type' => 'hidden', 'value' => $data['Organization']['id'])) ?>
    <?= $this->Form->input('check_del_unit', array('type' => 'hidden')) ?>
    <?= $this->Form->end(); ?>
</div>
<!--確認メッセージ用-->
<div id="modal">
    <div id="open01">
        <div class="close_overlay"></div>
        <span class="modal_window">
            <h2>確認</h2>
            <p>組織情報を削除しました。</p>
            <input type="button" value="はい" onClick="location.href = '../'">
        </span><!--/.modal_window-->
    </div><!--/#open01-->
</div>
<div id="modal">
    <div id="open02">
        <div class="close_overlay"></div>
        <span class="modal_window">
            <h2>確認</h2>
            <p style="text-align: center;">組織を削除すると、組織に属している担当者が削除されます。よろしいですか？</p>
            <input type="button" value="はい" class="checkDelOrg" data-bind="1">
            <a href ="#" style="color: #000000">
                <input type="button" value="いいえ">
            </a>
        </span><!--/.modal_window-->
    </div><!--/#open02-->
</div>
<div id="modal">
    <div id="open03">
        <div class="close_overlay"></div>
        <span class="modal_window">
            <h2>確認</h2>
            <p style="text-align: center;">組織で管理しているユニット端末とその観測データも全て削除しますか？</p>
            <input type="button" value="はい" class="checkDelUnit" data-bind="1">
            <input type="button" value="いいえ" class="checkDelUnit" data-bind="2">
        </span><!--/.modal_window-->
    </div><!--/#open02-->
</div>
<!--END-->
<?php $this->start("viewscript"); ?>
<script>
    $(function () {
        var check_reg = <?php echo $checkDel; ?>;
        if (check_reg === 1) {
            location.href = '#open01';
        }
        $('.checkDelOrg').on('click', function () {
            location.href = '#open03';
        });
        $('.checkDelUnit').on('click', function () {
            var value = $(this).attr('data-bind');
            $('#OrganizationCheckDelUnit').val(value);
            $('#formOrganization').submit();
        });

    });
</script>
<?php $this->end(); ?>
