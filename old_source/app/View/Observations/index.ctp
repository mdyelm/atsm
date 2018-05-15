<div class="col-lg-12">
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->Element("pager") ?>
    <table class="table font13">
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
                <td><?php echo $row['Observation']['client_id']; ?></td>
                <td><?php echo h($row['Observation']['client_name']); ?></td>
                <td><?php echo h($row['Observation']['place']); ?></td>
                <td class="wid5">
                    <input type="button" onclick="location.href = '<?php echo $this->Html->url(array("action" => "status", $row['Observation']['id'])) ?>'" value="観測状況">
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>