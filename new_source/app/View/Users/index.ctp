<div class="col-lg-12">
    <div class="newBlock">
        <p class="nopd nomg">システムに登録されている担当者の一覧を表示しています。</p>
        <p class="nopd nomg">新規登録、編集、削除ボタンにより必要な操作を行ってください。</p>
        <?php
        echo $this->Form->create('User', array(
            'id' => 'idUsers',
			'class' => 'form-horizontal',
            'url' => array('controller' => 'Users', 'action' => 'index'),
            'inputDefaults' => array(
                'label' => false,
                'div' => false,
                'required' => false,
        )));
        if (empty($data)) {
            $data['user_id'] = "";
            $data['user_name'] = "";
            $data['organization_name'] = "";
            $data['phone'] = "";
            $data['mail_address'] = "";
            $data['role'] = "";
        }
        $this->data = $data;
        ?>
        <?php echo $this->Flash->render('UserIndex'); ?>
        <table class="table table-striped font13 borderInput">
            <thead>
                <tr class="cap">
                    <th>担当者ID</th>
                    <th>担当者名</th>
                    <th>所属組織</th>
                    <th>緊急連絡先</th>
                    <th>メールアドレス</th>
                    <th>システム権限</th>
                </tr>
            </thead>
            <tbody>
                <tr class="active">
                    <td>
                        <?php echo $this->Form->input('user_id', array('value' => $this->data['user_id'], 'type' => 'text', 'style' => 'width: 100%', 'label' => false, 'div' => false)); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input('user_name', array('value' => $this->data['user_name'], 'type' => 'text', 'style' => 'width: 100%', 'label' => false, 'div' => false)); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input('organization_name', array('maxlength'=>30,'value' => $this->data['organization_name'], 'type' => 'text', 'style' => 'width: 100%', 'label' => false, 'div' => false)); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input('phone', array('value' => $this->data['phone'], 'type' => 'text', 'style' => 'width: 100%', 'label' => false, 'div' => false)); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input('mail_address', array('value' => $this->data['mail_address'], 'type' => 'text', 'style' => 'width: 100%', 'label' => false, 'div' => false)); ?>
                    </td>
                    <td>
                        <?php
                        echo $this->Form->input('role', array(
                            'options' => Configure::read('User.role1'),
                            'empty' => '-----',
                            'style' => 'width: 100%',
                            'label' => false,
                            'div' => false,
                            'value' => $this->data['role']
                        ));
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-center">
            <button type="submit" class="btnS">検索</button>
            <button type="button" id="btClear" class="btnS">クリア</button>
            <?php if ($userRole['role'] == 0 || $userRole['role'] == 1): ?>
                <?php
                echo $this->Html->link(
                        '新規登録', array(
                    'controller' => 'Users',
                    'action' => 'user_regist'
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
                <th>担当者ID</th>
                <th>担当者名</th>
                <th>所属組織</th>
                <th>緊急連絡先</th>
                <th>メールアドレス</th>
                <th>システム権限</th>
                <th class="w7p2">編集</th>
                <th class="w7p2">削除</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataP as $row): ?>
                <?php if (($userRole['role'] == 1 || $userRole['role'] == 0) && $row['User']['role'] != 0): ?>
                    <tr class="active">
                        <td><?php echo $row['User']['user_id']; ?></td>
                        <td><?php echo h($row['User']['user_name']); ?></td>
                        <td><?php echo h($row['Organization']['organization_name']); ?></td>
                        <td><?php echo h($row['User']['phone']); ?></td>
                        <td><?php echo h($row['User']['mail_address']); ?></td>
                        <td>
                            <?php if (isset($row['User']['role']) && isset($role[$row['User']['role']])): ?>
                                <?php echo h($role[$row['User']['role']]); ?>
                            <?php endif; ?>
                        </td>
                        <?php if ($userRole['role'] == 0 || ($userRole['organization_name'] == $row['Organization']['organization_name'])): ?>
                            <td>
                                <?php
                                echo $this->Html->link(
                                        '編集', array(
                                    'controller' => 'Users',
                                    'action' => 'user_edit',
                                    $row['User']['id']
                                        ), array('class' => 'btnE')
                                );
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Html->link(
                                        '削除', array(
                                    'controller' => 'Users',
                                    'action' => 'user_delete',
                                    $row['User']['id']
                                        ), array('class' => 'btnD')
                                );
                                ?>
                            </td>
                        <?php else: ?>
                            <td>
                                <?php
                                echo $this->Html->link(
                                        '編集', array(
                                    'controller' => 'Users',
                                    'action' => 'user_edit',
                                    $row['User']['id']
                                        ), array('class' => 'btnE disUserBT' , 'onclick' => 'return false')
                                );
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Html->link(
                                        '削除', array(
                                    'controller' => 'Users',
                                    'action' => 'user_delete',
                                    $row['User']['id']
                                        ), array('class' => 'btnD disUserBT', 'onclick' => 'return false')
                                );
                                ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php elseif (($userRole['role'] == 2 && $userRole['id'] == $row['User']['id'])): ?>
                    <tr class="active">
                        <td><?php echo $row['User']['user_id']; ?></td>
                        <td><?php echo h($row['User']['user_name']); ?></td>
                        <td><?php echo h($row['Organization']['organization_name']); ?></td>
                        <td><?php echo h($row['User']['phone']); ?></td>
                        <td><?php echo h($row['User']['mail_address']); ?></td>
                        <td>
                            <?php if (isset($row['User']['role']) && isset($role[$row['User']['role']])): ?>
                                <?php echo h($role[$row['User']['role']]); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Html->link(
                                    '編集', array(
                                'controller' => 'Users',
                                'action' => 'user_edit',
                                $row['User']['id']
                                    ), array('class' => 'btnE')
                            );
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Html->link(
                                    '削除', array(
                                'controller' => 'Users',
                                'action' => 'user_delete',
                                $row['User']['id']
                                    ), array('class' => 'btnD disUserBT', 'onclick' => 'return false')
                            );
                            ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $this->start("viewscript"); ?>
<script>
    $(document).ready(function () {
        $('#btClear').click(function () {
            window.location.href = "<?= $this->Html->url(array("controller" => "Users", "action" => "clear_data")); ?>";
        });
    });
</script>
<?php $this->end(); ?>