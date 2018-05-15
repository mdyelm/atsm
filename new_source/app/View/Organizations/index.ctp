<div class="col-lg-12">
    <div class="newBlock">
        <p class="nopd nomg">システムに登録されている組織の一覧を表示しています。</p>
        <p class="nopd nomg">新規登録、編集、削除ボタンにより必要な操作を行ってください。</p>
        <?php
        echo $this->Form->create('Organization', array(
            'url' => array('controller' => 'Organizations', 'action' => 'index'),
            'id' => 'idOrganization',
            'class' => 'form-horizontal',
            'inputDefaults' => array(
                'label' => false,
                'div' => false,
                'required' => false,
        )));
        if (empty($data)) {
            $data['organization_id'] = "";
            $data['organization_name'] = "";
            $data['position'] = "";
            $data['phone'] = "";
            $data['mail_address'] = "";
        }
        $this->data = $data;
        ?>
        <?php echo $this->Flash->render('OrganizationIndex'); ?>
        <table class="table table-striped font13 borderInput">
            <thead>
                <tr class="cap">
                    <th>組織ID</th>
                    <th>組織名</th>
                    <th>担当部署</th>
                    <th>代表電話番号</th>
                    <th>代表メールアドレス</th>
                </tr>
            </thead>
            <tbody>
                <tr class="active">
                    <td>
                        <?php echo $this->Form->input('organization_id', array('value' => $this->data['organization_id'], 'type' => 'text', 'style' => 'width: 100%', 'label' => false, 'div' => false)); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input('organization_name', array('value' => $this->data['organization_name'], 'type' => 'text', 'style' => 'width: 100%', 'label' => false, 'div' => false)); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input('position', array('value' => $this->data['position'], 'type' => 'text', 'style' => 'width: 100%', 'label' => false, 'div' => false)); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input('phone', array('value' => $this->data['phone'], 'type' => 'text', 'style' => 'width: 100%', 'label' => false, 'div' => false)); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input('mail_address', array('value' => $this->data['mail_address'], 'type' => 'text', 'style' => 'width: 100%', 'label' => false, 'div' => false)); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-center">
            <button type="submit" class="btnS">検索</button>
            <button id="btClear" type="button" class="btnS">クリア</button>
            <?php
            echo $this->Html->link(
                    '新規登録', array(
                'controller' => 'Organizations',
                'action' => 'organization_regist'
                    ), array('class' => 'btnS')
            );
            ?>
        </div>
            <?= $this->Form->end(); ?>
    </div>
        <?php echo $this->Element("pager") ?>
    <table class="table table-striped font13">
        <thead>
            <tr class="cap">
                <th>組織ID</th>
                <th>組織名</th>
                <th>担当部署</th>
                <th>代表電話番号</th>
                <th>代表メールアドレス</th>
                <th class="w7p2">編集</th>
                <th class="w7p2">削除</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($dataP as $row): ?>
            <tr class="active">
                <td><?php echo $row['Organization']['organization_id']; ?></td>
                <td><?php echo h($row['Organization']['organization_name']); ?></td>
                <td><?php echo h($row['Organization']['position']); ?></td>
                <td><?php echo $row['Organization']['phone']; ?></td>
                <td><?php echo h($row['Organization']['mail_address']); ?></td>
                <td>
                    <?php
                        echo $this->Html->link(
                            '編集', array(
                            'controller' => 'Organizations',
                            'action' => 'organization_edit',
                            $row['Organization']['id']
                                ), array('class' => 'btnE')
                        );
                    ?>
                </td>
                <td>
                    <?php
                    echo $this->Html->link(
                            '削除', array(
                        'controller' => 'Organizations',
                        'action' => 'organization_delete',
                        $row['Organization']['id']
                            ), array('class' => 'btnD')
                    );
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $this->start("viewscript"); ?>
<script>
    $(document).ready(function () {
        $('#btClear').click(function () {
            window.location.href = "<?= $this->Html->url(array("controller" => "Organizations", "action" => "clear_data")); ?>";
        });
    });
</script>
<?php $this->end(); ?>