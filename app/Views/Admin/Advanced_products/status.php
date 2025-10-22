
<?php if ($val->status == 'Active') { ?>
    <button type="button" onclick="bulkAllStatusUpdate('<?php echo $val->product_id; ?>','Inactive','status','reStatusUpdate_<?php echo $val->product_id?>')" class="btn btn-success btn-xs"><?php echo $val->status; ?></button>
<?php } else { ?>
    <button type="button" onclick="bulkAllStatusUpdate('<?php echo $val->product_id; ?>','Active','status','reStatusUpdate_<?php echo $val->product_id?>')" class="btn btn-warning btn-xs"><?php echo $val->status; ?></button>
<?php } ?>

