<?php if ($data): ?>
    <?php foreach ($data as $row): ?>
        <div>
            <img src="<?php echo $this->App->getMonitorImageURL($client_id, $row) ?>" width="475px">
            <p><?php echo $row ?></p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <h3><font color="red">モニター画像はありません。</font></h3>
<?php endif; ?>