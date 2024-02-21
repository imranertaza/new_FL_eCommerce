<ul class="list-unstyled" onclick="categoryBulkUpdate('<?php echo $product_id; ?>')">
    <?php foreach (get_array_data_by_id('cc_product_to_category', 'product_id', $product_id) as $cat) { ?>
        <li><?php echo display_category_with_parent($cat->category_id); ?></li>
    <?php } ?>
</ul>