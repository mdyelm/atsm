<div class="col-lg-12">
    <div class="newBlock">
        <p class="nopd nomg">ユニット端末の詳細情報。</p>
    </div>
    <?php
    echo $this->Form->create('Unit', array(
        'url' => array('controller' => 'Units', 'action' => 'unit_edit'),
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
                        <?php if (isset($data)): ?>
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
                        <?php if (isset($organization_name[$data['Unit']['organization_id']])): ?>
                            <?php echo h($organization_name[$data['Unit']['organization_id']]); ?>
                        <?php endif; ?>
                    </label>
                </td>
            </tr> 
            <tr class="cap">
                <th class="tbW20">
                    <span>ライセンス番号発行</span>
                </th>
                <td>
                    <label class="pL5">
                        <?php if (!empty($data['Unit']['license_number'])): ?>
                            <?php echo h($data['Unit']['license_number']); ?>
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
                        <?php echo h(Configure::read('Unit.status')[$data['Unit']['status']]) ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>IPアドレス</span>
                </th>
                <td>
                    <label class="pL5">
                        <?php echo h($data['Unit']['ip_address']) ?>
                    </label>
                </td>
            </tr>
            <tr class="cap">
                <th class="tbW20">
                    <span>認証コード</span>
                </th>
                <td>
                    <label class="pL5">
                        <?php echo h($data['Unit']['authen_code']) ?>
                    </label>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="pd14 text-center">
        <?php
        echo $this->Html->link(
                '戻る', array(
            'controller' => 'Units',
            'action' => 'index'
                ), array('class' => 'btnS')
        );
        ?>
    </div>
    <?= $this->Form->end(); ?>
</div>