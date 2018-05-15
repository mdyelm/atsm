<div class="col-lg-12 divMonitoring">
    <?php echo $this->Flash->render('Monitoring'); ?>
    <?php echo $this->Flash->render('erRole') ?>
    <div class="newBlock">
        <p class="nopd nomg">システムに登録されているユニットの監視状況を表示しています。</p>
        <p class="nopd nomg">「監視状況」ボタンをクリックすると、対応するユニットの監視状況を閲覧出来ます。</p>
        <?php
        echo $this->Form->create('Monitoring', array(
            'id' =>'idMonitoring',
	    'class' => 'form-horizontal',
            'url' => array('controller' => 'Monitoring', 'action' => 'index'),
            'inputDefaults' => array(
                'label' => false,
                'div' => false,
                'required' => false,
        )));
        if(empty($data)){
            $data['unit_id'] = "";
            $data['organization_name'] = "";
            $data['place'] = "";
            $data['status'] = "";
            $data['ip_address'] = "";
        }
        $this->data = $data;
        ?>
        <?php echo $this->Flash->render('MonitoringIndex'); ?>
        <table class="table table-striped font13 borderInput">
            <thead>
                <tr class="cap">
                    <th>ユニット端末ID</th>
                    <th>管理組織</th>
                    <th>観測場所名</th>
                    <th>稼働状況ステータス</th>
                    <th>IPアドレス</th>
                </tr>
            </thead>
            <tbody>
                <tr class="active">
                    <td>
                        <?php echo $this->Form->input('unit_id', array('value'=>$this->data['unit_id'],'type' => 'text','style' => 'width: 100%', "label" => false, "div" => false)); ?>

                    </td>
                    <td>
                        <?php echo $this->Form->input('organization_name', array('maxlength'=>30,'value'=>$this->data['organization_name'],'type' => 'text','style' => 'width: 100%', "label" => false, "div" => false)); ?>

                    </td>
                    <td>
                        <?php echo $this->Form->input('place', array('value'=>$this->data['place'],'type' => 'text','style' => 'width: 100%', "label" => false, "div" => false)); ?>

                    </td>
                    <td>
                        <?php 
                            echo $this->Form->input('status', array(
                                'options' => $status,
                                'empty' => '--------------------',
                                'style' => 'width: 100%',
                                "label" => false, 
                                "div" => false,
                                'value'=>$this->data['status'],

                            ));
                        ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input('ip_address', array('value'=>$this->data['ip_address'],'type' => 'text','style' => 'width: 100%', "label" => false, "div" => false)); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-center">
            <button type="submit" class="btnS">検索</button>
            <button id="btClear" type="button" class="btnS">クリア</button>
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
                <th>稼働状況ステータス</th>
                <th>IPアドレス</th>
                <th class="w9">監視状況確認</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataP as $row): ?>
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
                <td><?php echo h($status[$row['Unit']['status']]); ?></td>
                <td><?php echo h($row['Unit']['ip_address']); ?></td>
                <td>
                    <?php
                        echo $this->Html->link(
                            '監視状況',
                            array(
                                'controller' => 'Monitoring',
                                'action' => 'status',
                                $row['Unit']['id']
                            ),
                            array('class' => 'btnSt')
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
   $( document ).ready(function() {
        $('#btClear').click(function(){
            window.location.href = "<?=$this->Html->url(array("controller" => "Monitoring","action" => "clear_data"));?>";
        });
    });
</script>
<?php $this->end(); ?>