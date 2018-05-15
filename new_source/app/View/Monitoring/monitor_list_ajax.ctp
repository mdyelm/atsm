<?php if ($data): 
?>
    <?php foreach ($data as $key => $row): ?>
        <?php  
            $monitorDate = $row['MonitoringLog']['monitor_date'];
            $monitor_date_view = new \DateTime($monitorDate);
            $monitor_date_view = $monitor_date_view->format('Y/m/d H:i:s');
        ?>
            <div>
                <?php 
                    $checkFileJpg_A = $this->Common->checkFileJpg_A($unit_id,$row['MonitoringLog']['file_jpg']);
                    if(!empty($checkFileJpg_A)){ ?>   
                    <img class="blueBorder" src="<?=$checkFileJpg_A?>" width="475px">
                <?php } ?>  
                <p>
                    <?php 
                        echo $monitor_date_view ;
                    ?>
                </p>
            </div>
    <?php endforeach; ?>
<?php endif; ?>