<div class="row">
    <div class="col-md-6">

        <?php
        $catSel = get_lebel_by_value_in_theme_settings('home_category');
        $cat = get_all_data_array('cc_product_category');

        ?>


        <form action="<?php echo base_url('settings_update') ?>" method="post" enctype="multipart/form-data">

            <div class="form-group mt-2">
                <label><?php echo get_lebel_by_title_in_theme_settings('trending_youtube_video'); ?></label>
                <input type="text" name="value" class="form-control"
                       value="<?php echo get_lebel_by_value_in_theme_settings('trending_youtube_video'); ?>" required>
                <input type="hidden" name="label" value="trending_youtube_video" required>
            </div>

            <button class="btn btn-primary">Save</button>
        </form>
        <form action="<?php echo base_url('settings_update') ?>" method="post" enctype="multipart/form-data">

            <div class="form-group mt-2">
                <label><?php echo get_lebel_by_title_in_theme_settings('brands_youtube_video'); ?></label>
                <input type="text" name="value" class="form-control"
                       value="<?php echo get_lebel_by_value_in_theme_settings('brands_youtube_video'); ?>" required>
                <input type="hidden" name="label" value="brands_youtube_video" required>
            </div>

            <button class="btn btn-primary">Save</button>
        </form>


        <form action="<?php echo base_url('home_special_banner') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group mt-5">
                <?php
                $special_banner_1 = get_lebel_by_value_in_theme_settings('special_banner');
                echo image_view('uploads/special_banner', '', $special_banner_1, 'noimage.png', 'w-75');
                ?>
            </div>
            <div class="form-group">
                <label><?php echo get_lebel_by_title_in_theme_settings('special_banner'); ?></label>
                <br>
                <small>width-837 x height-190</small>
                <input type="file" name="special_banner" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <form action="<?php echo base_url('home_left_side_banner') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group mt-5">
                <?php
                $special_banner_1 = get_lebel_by_value_in_theme_settings('left_side_banner_one');
                echo image_view('uploads/left_side_banner', '', $special_banner_1, 'noimage.png', 'w-25');
                ?>
            </div>
            <div class="form-group">
                <label><?php echo get_lebel_by_title_in_theme_settings('left_side_banner_one'); ?></label>
                <br>
                <small>width-262 x height-420</small>
                <input type="file" name="left_side_banner" class="form-control" required>
                <input type="hidden" name="label" class="form-control" value="left_side_banner_one" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <form action="<?php echo base_url('home_left_side_banner') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group mt-5">
                <?php
                $banner_1 = get_lebel_by_value_in_theme_settings('left_side_banner_three');
                echo image_view('uploads/left_side_banner', '', $banner_1, 'noimage.png', 'w-25');
                ?>
            </div>
            <div class="form-group">
                <label><?php echo get_lebel_by_title_in_theme_settings('left_side_banner_three'); ?></label>
                <br>
                <small>width-262 x height-420</small>
                <input type="file" name="left_side_banner" class="form-control" required>
                <input type="hidden" name="label" class="form-control" value="left_side_banner_three" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>


    </div>

    <div class="col-md-6 ">

        <form action="<?php echo base_url('settings_update') ?>" method="post" enctype="multipart/form-data">

            <div class="form-group mt-2">
                <label><?php echo get_lebel_by_title_in_theme_settings('hot_deals_category'); ?></label>
                <select name="value" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                    $catSel = get_lebel_by_value_in_theme_settings('hot_deals_category');
                    foreach ($cat as $val) {
                        ?>
                        <option value="<?php echo $val->prod_cat_id; ?>"
                            <?php echo ($val->prod_cat_id == $catSel) ? 'selected' : ''; ?>><?php echo display_category_with_parent($val->prod_cat_id); ?>
                        </option>
                    <?php } ?>
                </select>
                <input type="hidden" name="label" value="hot_deals_category" required>
            </div>

            <button class="btn btn-primary">Save</button>
        </form>

        <form action="<?php echo base_url('settings_update') ?>" method="post" enctype="multipart/form-data">

            <div class="form-group mt-2">
                <label><?php echo get_lebel_by_title_in_theme_settings('trending_collection_category'); ?></label>
                <select name="value" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                    $catSel = get_lebel_by_value_in_theme_settings('trending_collection_category');
                    foreach ($cat as $val) {
                        ?>
                        <option value="<?php echo $val->prod_cat_id; ?>"
                            <?php echo ($val->prod_cat_id == $catSel) ? 'selected' : ''; ?>><?php echo display_category_with_parent($val->prod_cat_id); ?>
                        </option>
                    <?php } ?>
                </select>
                <input type="hidden" name="label" value="trending_collection_category" required>
            </div>

            <button class="btn btn-primary">Save</button>
        </form>

        <form action="<?php echo base_url('settings_update') ?>" method="post" enctype="multipart/form-data">

            <div class="form-group mt-2">
                <label><?php echo get_lebel_by_title_in_theme_settings('special_category_one'); ?></label>
                <select name="value" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                    $catSel = get_lebel_by_value_in_theme_settings('special_category_one');
                    foreach ($cat as $val) {
                        ?>
                        <option value="<?php echo $val->prod_cat_id; ?>"
                            <?php echo ($val->prod_cat_id == $catSel) ? 'selected' : ''; ?>><?php echo display_category_with_parent($val->prod_cat_id); ?>
                        </option>
                    <?php } ?>
                </select>
                <input type="hidden" name="label" value="special_category_one" required>
            </div>

            <button class="btn btn-primary">Save</button>
        </form>
        <form action="<?php echo base_url('settings_update') ?>" method="post" enctype="multipart/form-data">

            <div class="form-group mt-2">
                <label><?php echo get_lebel_by_title_in_theme_settings('special_category_two'); ?></label>
                <select name="value" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                    $catSel = get_lebel_by_value_in_theme_settings('special_category_two');
                    foreach ($cat as $val) {
                        ?>
                        <option value="<?php echo $val->prod_cat_id; ?>"
                            <?php echo ($val->prod_cat_id == $catSel) ? 'selected' : ''; ?>><?php echo display_category_with_parent($val->prod_cat_id); ?>
                        </option>
                    <?php } ?>
                </select>
                <input type="hidden" name="label" value="special_category_two" required>
            </div>

            <button class="btn btn-primary">Save</button>
        </form>
        <form action="<?php echo base_url('settings_update') ?>" method="post" enctype="multipart/form-data">

            <div class="form-group mt-2">
                <label><?php echo get_lebel_by_title_in_theme_settings('special_category_three'); ?></label>
                <select name="value" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                    $catSel = get_lebel_by_value_in_theme_settings('special_category_three');
                    foreach ($cat as $val) {
                        ?>
                        <option value="<?php echo $val->prod_cat_id; ?>"
                            <?php echo ($val->prod_cat_id == $catSel) ? 'selected' : ''; ?>><?php echo display_category_with_parent($val->prod_cat_id); ?>
                        </option>
                    <?php } ?>
                </select>
                <input type="hidden" name="label" value="special_category_three" required>
            </div>

            <button class="btn btn-primary">Save</button>
        </form>

        <form action="<?php echo base_url('home_left_side_banner') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group mt-5">
                <?php
                $banner_1 = get_lebel_by_value_in_theme_settings('left_side_banner_two');
                echo image_view('uploads/left_side_banner', '', $banner_1, 'noimage.png', 'w-25');
                ?>
            </div>
            <div class="form-group">
                <label><?php echo get_lebel_by_title_in_theme_settings('left_side_banner_two'); ?></label>
                <br>
                <small>width-262 x height-420</small>
                <input type="file" name="left_side_banner" class="form-control" required>
                <input type="hidden" name="label" class="form-control" value="left_side_banner_two" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>


    </div>
</div>