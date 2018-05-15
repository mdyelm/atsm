<div class="container backWhite">
    <div class="col-lg-12">
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Element("pager") ?>
        <table class="table table-striped table-hover font13">
            <thead>
                <tr class="cap">
                    <th>クライアントID</th>
                    <th>クライアント名</th>
                    <th>観測場所</th>
                    <th>観測状況</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr class="active">
                        <td><?php echo $row['Client']['client_id']; ?></td>
                        <td><?php echo h($row['Client']['client_name']); ?></td>
                        <td><?php echo h($row['Client']['place']); ?></td>
                        <td class="wid5"><input type="button" onClick="location.href = '<?php echo $this->Html->url(array("controller" => $this->name, "action" => "status", $row['Client']['id'])) ?>'"value="観測状況"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>



