<!--メインコンテンツ-->
<div class="col-lg-12">
    <?php echo $this->Session->flash(); ?>
    <div class="mt21" align="right">
        <?php echo $this->Html->link("新規登録", array("controller" => $this->name, "action" => "create"), array("class" => "btn btn-def2")) ?>
    </div>  
    <?php echo $this->Element("pager") ?>
    <table class="table font13">
        <thead>
            <tr class="cap">
                <th>担当者ID</th>
                <th>組織名</th>
                <th>担当・役職名</th>
                <th>氏名</th>
                <th>システム権限</th>
                <!--<th>ログインID</th>-->
                <th>編集</th>
                <th>削除</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr class="active">
                    <td><?php echo $row['SUser']['user_id']; ?></td>
                    <td><?php echo h($row['SUser']['organization_name']); ?></td>
                    <td><?php echo h($row['SUser']['position']); ?></td>
                    <td><?php echo h($row['SUser']['user_name']); ?></td>
                    <td><?php echo $this->App->getAuthority($row['SUser']['authority']) ?></td>
                    <!--<td><?php echo $row['SUser']['login_id']; ?></td>-->
                    <td class="wid5"><input type="button" onClick="location.href = '<?php echo $this->Html->url(array("controller" => $this->name, "action" => "edit", $row['SUser']['id'])) ?>'" value="編集"></td>
                    <td class="wid5"><input type="button" onClick="location.href = '<?php echo $this->Html->url(array("controller" => $this->name, "action" => "delete", $row['SUser']['id'])) ?>'"value="削除"></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



