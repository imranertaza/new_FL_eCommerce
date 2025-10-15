
<?php if ($val->featured == '1') { ?>
    <button type="button" onclick="bulkAllStatusUpdate('<?php echo $val->product_id; ?>','0','featured','reFeaturedUpdate_<?php echo $val->product_id?>')" class="btn btn-success btn-xs">On</button>
<?php } else { ?>
    <button type="button" onclick="bulkAllStatusUpdate('<?php echo $val->product_id; ?>','1','featured','reFeaturedUpdate_<?php echo $val->product_id?>')" class="btn btn-warning btn-xs">Off</button>
<?php } ?>
