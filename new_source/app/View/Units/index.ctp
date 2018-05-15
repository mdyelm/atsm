<div class="col-lg-12">
    <div class="newBlock">
        <p class="nopd nomg">システムに登録されているユニット端末の一覧を表示しています。</p>
        <p class="nopd nomg">新規登録、詳細、削除ボタンにより必要な操作を行ってください。</p>
        <?php
        echo $this->Form->create('Unit', array(
            'id' => 'idUnit',
			'class' => 'form-horizontal',
            'url' => array('controller' => 'Units', 'action' => 'index'),
            'inputDefaults' => array(
                'label' => false,
                'div' => false,
                'required' => false,
        )));
        if (empty($data)) {
            $data['unit_id'] = "";
            $data['organization_name'] = "";
            $data['place'] = "";
            $data['status'] = "";
            $data['license_type'] = "";
            $data['ip_address'] = "";
        }
        $this->data = $data;
        ?>
        <?php echo $this->Flash->render('UnitIndex'); ?>
        <table class="table table-striped font13 borderInput">
            <thead>
                <tr class="cap">
                    <th>ユニット端末ID</th>
                    <th>管理組織</th>
                    <th>観測場所名</th>
                    <th>ライセンス種別</th>
                    <th>稼働状況ステータス</th>
                    <th>IPアドレス</th>
                </tr>
            </thead>
            <tbody>
                <tr class="active">
                    <td>
                        <?php echo $this->Form->input('unit_id', array('value' => $this->data['unit_id'], 'type' => 'text', 'style' => 'width: 100%', 'label' => false, 'div' => false)); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input('organization_name', array('value' => $this->data['organization_name'], 'type' => 'text', 'style' => 'width: 100%', 'label' => false, 'div' => false, 'maxlength' => 30)); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input('place', array('value' => $this->data['place'], 'type' => 'text', 'style' => 'width: 100%', 'label' => false, 'div' => false)); ?>
                    </td>
                    <td>
                        <?php
                        echo $this->Form->input('license_type', array(
                            'options' => Configure::read('License.type'),
                            'empty' => '-----',
                            'style' => 'width: 100%',
                            'label' => false,
                            'div' => false,
                            'value' => $this->data['license_type']
                        ));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $this->Form->input('status', array(
                            'options' => $status,
                            'empty' => '-----',
                            'style' => 'width: 100%',
                            'label' => false,
                            'div' => false,
                            'value' => $this->data['status']
                        ));
                        ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input('ip_address', array('value' => $this->data['ip_address'], 'type' => 'text', 'style' => 'width: 100%', 'label' => false, 'div' => false)); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-center">
            <button type="submit" class="btnS">検索</button>
            <button type="button" id="btClear" class="btnS">クリア</button>
            <?php if ($userRole['role'] == 0): ?>
                <?php
                echo $this->Html->link(
                        '新規登録', array(
                    'controller' => 'Units',
                    'action' => 'unit_regist'
                        ), array('class' => 'btnS')
                );
                ?>
            <?php endif; ?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
    <?php echo $this->Element("pager") ?>
    <table class="table table-striped font13">
        <thead>
            <tr class="cap">
                <th>ユニット端末ID</th>
                <th>管理組織</th>
                <th>観測場所名</th>
                <th>ライセンス種別</th>
                <th>稼働状況ステータス</th>
                <th>IPアドレス</th>
                <th class="w7p2">詳細</th>
                <th class="w7p2">削除</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataP as $row): ?>
                <?php if (isset($row['Unit']['expiration_date']) && !empty($row['Unit']['expiration_date'])): ?>
                    <?php
                    $date = date("Y/m/d", strtotime($row['Unit']['expiration_date']));
                    ?>
                <?php endif; ?>
                <tr class="active">
                    <td><?php echo $row['Unit']['unit_id']; ?></td>
                    <td><?php echo h($row['Organization']['organization_name']); ?></td>
                    <td>
                        <?php if (!empty($row['Unit']['place'])): ?>
                            <?php echo h($row['Unit']['place']); ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (isset($row['Unit']['license_type']) && isset(Configure::read('License.type')[$row['Unit']['license_type']])): ?>
                            <?php echo h(Configure::read('License.type')[$row['Unit']['license_type']]); ?>
                        <?php endif; ?>
                        <?php
                        if (isset($row['Unit']['license_type']) && $row['Unit']['license_type'] == 1) {
                            echo h('(' . $date . 'まで)');
                        }
                        ?>
                    </td>
                    <td>
                        <?php if (isset($row['Unit']['status']) && isset($status[$row['Unit']['status']])): ?>
                            <?php echo h($status[$row['Unit']['status']]); ?>
                        <?php endif; ?>
                    </td>

                    <td><?php echo h($row['Unit']['ip_address']); ?></td>
                    <?php if ($userRole['role'] == 0): ?>
                        <td>
                            <?php
                            echo $this->Html->link(
                                    '詳細', array(
                                'controller' => 'Units',
                                'action' => 'unit_edit',
                                $row['Unit']['id']
                                    ), array('class' => 'btnE')
                            );
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Html->link(
                                    '削除', array(
                                'controller' => 'Units',
                                'action' => 'unit_delete',
                                $row['Unit']['id']
                                    ), array('class' => 'btnD')
                            );
                            ?>
                        </td>
                    <?php else: ?>
                        <td>
                            <?php
                            echo $this->Html->link(
                                    '詳細', array(
                                'controller' => 'Units',
                                'action' => 'unit_detail',
                                $row['Unit']['id']
                                    ), array('class' => 'btnE')
                            );
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Html->link(
                                    '削除', array(
                                'controller' => 'Units',
                                'action' => 'unit_delete',
                                $row['Unit']['id']
                                    ), array('class' => 'btnD', 'onclick' => 'return false', 'style' => 'background-color:#cccccc')
                            );
                            ?>
                        </td>
                    <?php endif; ?>


                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $this->start("viewscript"); ?>
<script>
    $(document).ready(function () {
        $('#btClear').click(function () {
            window.location.href = "<?= $this->Html->url(array("controller" => "Units", "action" => "clear_data")); ?>";
        });
    });
</script>
<?php $this->end(); ?>