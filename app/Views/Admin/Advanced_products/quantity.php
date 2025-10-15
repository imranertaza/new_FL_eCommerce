
<p onclick="updateFunction('<?php echo $val->product_id; ?>', 'quantity', '<?php echo $val->quantity; ?>', 'view_qty_<?php echo $val->product_id; ?>','bulkForm_qty_<?php echo $val->product_id; ?>','reQuantityUpdate_<?php echo $val->product_id?>')">
    <?php echo !empty($val->quantity)?$val->quantity:'<i style="color: #ccc;">NULL</i>'; ?> </p>
<span id="view_qty_<?php echo $val->product_id; ?>"></span>
