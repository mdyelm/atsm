<ul class="pager">
    <?php
    if ($data) {
//        if ($this->Paginator->hasPrev()) {
        ?>
        <li class="previous">
            <a id="prevLink" href="javascript:void(0)">← Prev</a>
            <?php echo $this->Paginator->prev(" ", array("tag" => false, "class" => "hidden"), null, array('class' => 'prev hidden')); ?>
            <?php
//            if ($this->Paginator->hasPrev()) {
//                echo $this->Html->link('← Prev' . __(''), array("controller" => $this->name, "action" => $this->action, "page" => $this->Paginator->param("page") - 1), array("class" => "prev"));
//            } else {
//                echo $this->Html->tag("span", '← Prev' . __(''), array("class" => "prev"));
//            }
            ?>
        </li>
        <?php
//        }
        ?>
        <li class="caption">
            <span><?php echo $this->Paginator->counter(array('format' => '全%count%件中')); ?><?php echo $this->Paginator->counter(array('format' => __('{:start} ～ {:end} 件を表示'))); ?></span>
        </li>
        <?php
//        if ($this->Paginator->hasNext()) {
        ?>
        <li class="next">
            <a id="nextLink" href="javascript:void(0)">Next →</a>
            <?php // echo $this->Paginator->next("", array("escape" => false), null, array('class' => 'next disabled')); ?>
            <?php echo $this->Paginator->next(" ", array("tag" => false, "class" => "hidden"), null, array('class' => 'next hidden')); ?>
        </li>
        <?php
//        }
    }
    ?>
</ul>
<?php $this->start("viewscript"); ?>
<script>
    $(document).ready(function () {
//        $("a[rel=next]").hide();
//        $("span.next").hide();
        var next = $("a[rel=next]").attr("href");
        if (next) {
            $("#nextLink").attr("href", next);
        } else {
            $("#nextLink").attr("disabled", "disabled");
        }
        
//        $("a[rel=prev]").hide();
//        $("span.prev").hide();
        var prev = $("a[rel=prev]").attr("href");
        if (prev) {
            $("#prevLink").attr("href", prev);
        } else {
            $("#prevLink").attr("disabled", "disabled");
        }
    });
</script>
<?php $this->end(); ?>