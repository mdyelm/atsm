<!--メインコンテンツ-->
<div class="col-lg-12">
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->Element("pager") ?>
    <table class="table font13">
        <thead>
            <tr class="cap">
                <th>クライアントID</th>
                <th>クライアント名称</th>
                <th>観測場所</th>
                <th>ホスト名</th>
                <th>IPアドレス</th>
                <th>観測データ</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr class="active">
                    <td><?php echo $row['Client']['client_id']; ?></td>
                    <td><?php echo h($row['Client']['client_name']); ?></td>
                    <td><?php echo h($row['Client']['place']); ?></td>
                    <td><?php echo h($row['Client']['host']); ?></td>
                    <td><?php echo h($row['Client']['ip_address']); ?></td>
                    <td class="wid5">
                        <input type="button" onClick="location.href = '<?php echo $this->Html->url(array("controller" => $this->name, "action" => "detail", $row["Client"]["id"])) ?>'"value="観測データ">
                    </td>
                </tr>
            <?php endforeach; ?>
    </table>
</div>

