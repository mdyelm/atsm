<div class="col-lg-12">
    <div class="newBlock">
        <p class="nopd nomg">組織の編集したい項目を入力し、最後に「確認」ボタンを押してください。</p>
    </div>
    <?php
    echo $this->Form->create('Organization', array(
        'url' => array('controller' => 'Organizations', 'action' => 'organization_edit'),
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
                    <span>組織ID <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if (isset($data)): ?>
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
                        <?php
                        echo $this->Form->input('organization_name', array(
                            'type' => 'text',
                            'class' => 'inputNewDes w300',
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
                    <span>担当部署</span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        echo $this->Form->input('position', array(
                            'type' => 'text',
                            'class' => 'inputNewDes w300',
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
                    <span>代表電話番号 <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        echo $this->Form->input('phone', array(
                            'type' => 'text',
                            'class' => 'inputNewDes w300',
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
                    <span>代表メールアドレス <span style="color: red;">※</span></span>
                </th>
                <td>
                    <label class="pL5">
                        <?php
                        echo $this->Form->input('mail_address', array(
                            'type' => 'text',
                            'class' => 'inputNewDes w300',
                            'label' => false,
                            'div' => false
                        ));
                        ?>
                    </label> 
                    <span class="mgL10 opaText">半角英数記号50文字以内</span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="pd14 text-center">
        <input type="submit" class="btnS" value="確認"/>
        <?php
        echo $this->Html->link(
                '戻る', array(
            'controller' => 'Organizations',
            'action' => 'index'
                ), array('class' => 'btnS')
        );
        ?>
    </div>
    <?= $this->Form->input('organization_id', array('type' => 'hidden')) ?>
    <?= $this->Form->input('id', array('type' => 'hidden')) ?>
    <?= $this->Form->end(); ?>
</div>