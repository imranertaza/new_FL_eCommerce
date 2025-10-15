
<p onclick="updateFunction('<?php echo $val->product_id; ?>', 'price', '<?php echo $val->price; ?>', 'view_price_<?php echo $val->product_id; ?>','bulkForm_price_<?php echo $val->product_id; ?>','rePriceUpdate_<?php echo $val->product_id?>')">
    <?php echo !empty($val->price)?$val->price:'<i style="color: #ccc;">NULL</i>'; ?></p>
<span id="view_price_<?php echo $val->product_id; ?>"></span>
