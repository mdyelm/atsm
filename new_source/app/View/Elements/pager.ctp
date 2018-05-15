<ul class="pager">
    <?php
    if ($dataP) {
        $classPrev = "";
        $classNext = "";
        if(!$this->Paginator->params()['prevPage']){ 
            $classPrev = "disabledPa";
        }
        if(!$this->Paginator->params()['nextPage']){ 
            $classNext = "disabledPa";
        }
        ?>
        <li class="previous">
            <a class="<?=$classPrev?>" id="prevLink" href="javascript:void(0)">← Prev</a>
            <?php echo $this->Paginator->prev(" ", array("tag" => false, "class" => "hidden"), null, array('class' => 'prev hidden')); ?>
        </li>
        <li class="caption">
            <span><?php echo $this->Paginator->counter(array('format' => '%count%件中')); ?><?php echo $this->Paginator->counter(array('format' => __('{:start} ～ {:end} 件を表示'))); ?></span>
        </li>
        <li class="next">
            <a class="<?=$classNext?>" id="nextLink" href="javascript:void(0)">Next →</a>
            <?php echo $this->Paginator->next(" ", array("tag" => false, "class" => "hidden"), null, array('class' => 'next hidden')); ?>
        </li>
    <?php
    }
    ?>
</ul>
<?php $this->start("viewscript"); ?>
<script>
    $(document).ready(function () {
        var next = $("a[rel=next]").attr("href");
        if (next) {
            $("#nextLink").attr("href", next);
        } else {
            $("#nextLink").attr("disabled", "disabled");
        }
        var prev = $("a[rel=prev]").attr("href");
        if (prev) {
            $("#prevLink").attr("href", prev);
        } else {
            $("#prevLink").attr("disabled", "disabled");
        }
    });
</script>
<?php $this->end(); ?>