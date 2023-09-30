<div class="row">
    <div class="col-md-6 card p-2">
        <form action="<?php echo base_url('header_section_one_update') ?>" method="post" enctype="multipart/form-data">
            <h3>Top Section One</h3>
            <?php $theme = get_lebel_by_value_in_settings('Theme');?>
            <div class="form-group">
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('head_side_title_1',$theme);?></label>
                <input type="text" class="form-control" required name="head_side_title_1"
                    value="<?php echo get_lebel_by_value_in_theme_settings_with_theme('head_side_title_1',$theme);?>">
            </div>

            <div class="form-group">
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('head_side_category_1',$theme);?></label>
                <select name="head_side_category_1" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                        $catSel = get_lebel_by_value_in_theme_settings_with_theme('head_side_category_1',$theme);
                        $cat = get_all_data_array('cc_product_category');
                        foreach ($cat as $val){
                    ?>
                    <option value="<?php echo $val->prod_cat_id;?>"
                        <?php echo ($val->prod_cat_id == $catSel)?'selected':'';?>><?php echo $val->category_name;?>
                    </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <?php
                    $head_side_baner_1 = get_lebel_by_value_in_theme_settings_with_theme('head_side_baner_1',$theme);
                    echo image_view('uploads/top_side_baner', '', $head_side_baner_1, 'noimage.png', 'w-25');
                ?><br>
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('head_side_baner_1',$theme);?></label>
                <input type="file" class="form-control" name="head_side_baner_1">
            </div>

            <div class="form-group">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>

    <div class="col-md-6 card p-2">
        <form action="<?php echo base_url('header_section_two_update') ?>" method="post" enctype="multipart/form-data">
            <h3>Top Section Two</h3>

            <div class="form-group">
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('head_side_title_2',$theme);?></label>
                <input type="text" class="form-control" required name="head_side_title_2"
                    value="<?php echo get_lebel_by_value_in_theme_settings_with_theme('head_side_title_2',$theme);?>">
            </div>

            <div class="form-group">
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('head_side_category_2',$theme);?></label>
                <select name="head_side_category_2" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                        $catSel2 = get_lebel_by_value_in_theme_settings_with_theme('head_side_category_2',$theme);
                        $cat = get_all_data_array('cc_product_category');
                        foreach ($cat as $val){
                    ?>
                    <option value="<?php echo $val->prod_cat_id;?>"
                        <?php echo ($val->prod_cat_id == $catSel2)?'selected':'';?>><?php echo $val->category_name;?>
                    </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <?php
                    $head_side_baner_2 = get_lebel_by_value_in_theme_settings_with_theme('head_side_baner_2',$theme);
                    echo image_view('uploads/top_side_baner', '', $head_side_baner_2, 'noimage.png', 'w-25');
                ?><br>
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('head_side_baner_2',$theme);?></label>
                <input type="file" class="form-control" name="head_side_baner_2">
            </div>

            <div class="form-group">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>

    <div class="col-md-6 card p-2">
        <form action="<?php echo base_url('home_category_update') ?>" method="post" enctype="multipart/form-data">
            <h3>Category Section One</h3>
            <div class="form-group">
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('home_category_title_1',$theme);?></label>
                <input type="text" class="form-control" required name="home_category_title_1"
                    value="<?php echo get_lebel_by_value_in_theme_settings_with_theme('home_category_title_1',$theme);?>">
            </div>
            <div class="form-group">
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('home_category_1',$theme);?> </label>
                <select name="home_category_1" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                        $catSel_1 = get_lebel_by_value_in_theme_settings('home_category_1');
                        $cat = get_all_data_array('cc_product_category');
                        foreach ($cat as $val){
                    ?>
                    <option value="<?php echo $val->prod_cat_id;?>"
                        <?php echo ($val->prod_cat_id == $catSel_1)?'selected':'';?>><?php echo $val->category_name;?>
                    </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <?php
                    $home_category_baner_1 = get_lebel_by_value_in_theme_settings_with_theme('home_category_baner_1',$theme);
                    echo image_view('uploads/home_category', '', $home_category_baner_1, 'noimage.png', 'w-25');
                ?><br>
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('home_category_baner_1',$theme);?></label>
                <input type="file" class="form-control" name="home_category_baner_1">
            </div>
            <input type="hidden" class="form-control" required name="prefix" value="1">
            <button class="btn btn-primary">Save</button>
        </form>
    </div>

    <div class="col-md-6 card p-2">
        <form action="<?php echo base_url('home_category_update') ?>" method="post" enctype="multipart/form-data">
            <h3>Category Section Two</h3>
            <div class="form-group">
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('home_category_title_2',$theme);?></label>
                <input type="text" class="form-control" required name="home_category_title_2"
                    value="<?php echo get_lebel_by_value_in_theme_settings_with_theme('home_category_title_2',$theme);?>">
            </div>
            <div class="form-group">
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('home_category_2',$theme);?> </label>
                <select name="home_category_2" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                        $catSel_1 = get_lebel_by_value_in_theme_settings('home_category_2');
                        $cat = get_all_data_array('cc_product_category');
                        foreach ($cat as $val){
                    ?>
                    <option value="<?php echo $val->prod_cat_id;?>"
                        <?php echo ($val->prod_cat_id == $catSel_1)?'selected':'';?>><?php echo $val->category_name;?>
                    </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <?php
                    $home_category_baner_1 = get_lebel_by_value_in_theme_settings_with_theme('home_category_baner_2',$theme);
                    echo image_view('uploads/home_category', '', $home_category_baner_1, 'noimage.png', 'w-25');
                ?><br>
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('home_category_baner_2',$theme);?></label>
                <input type="file" class="form-control" name="home_category_baner_2">
            </div>
            <input type="hidden" class="form-control" required name="prefix" value="2">
            <button class="btn btn-primary">Save</button>
        </form>
    </div>

    <div class="col-md-6 card p-2">
        <form action="<?php echo base_url('home_category_update') ?>" method="post" enctype="multipart/form-data">
            <h3>Category Section Three</h3>
            <div class="form-group">
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('home_category_title_3',$theme);?></label>
                <input type="text" class="form-control" required name="home_category_title_3"
                    value="<?php echo get_lebel_by_value_in_theme_settings_with_theme('home_category_title_3',$theme);?>">
            </div>
            <div class="form-group">
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('home_category_3',$theme);?> </label>
                <select name="home_category_3" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                        $catSel_1 = get_lebel_by_value_in_theme_settings('home_category_3');
                        $cat = get_all_data_array('cc_product_category');
                        foreach ($cat as $val){
                    ?>
                    <option value="<?php echo $val->prod_cat_id;?>"
                        <?php echo ($val->prod_cat_id == $catSel_1)?'selected':'';?>><?php echo $val->category_name;?>
                    </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <?php
                    $home_category_baner_1 = get_lebel_by_value_in_theme_settings_with_theme('home_category_baner_3',$theme);
                    echo image_view('uploads/home_category', '', $home_category_baner_1, 'noimage.png', 'w-25');
                ?><br>
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('home_category_baner_3',$theme);?></label>
                <input type="file" class="form-control" name="home_category_baner_3">
            </div>
            <input type="hidden" class="form-control" required name="prefix" value="3">
            <button class="btn btn-primary">Save</button>
        </form>
    </div>

    <div class="col-md-6 card p-2">
        <form action="<?php echo base_url('home_category_update') ?>" method="post" enctype="multipart/form-data">
            <h3>Category Section Four</h3>
            <div class="form-group">
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('home_category_title_4',$theme);?></label>
                <input type="text" class="form-control" required name="home_category_title_4"
                    value="<?php echo get_lebel_by_value_in_theme_settings_with_theme('home_category_title_4',$theme);?>">
            </div>
            <div class="form-group">
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('home_category_4',$theme);?> </label>
                <select name="home_category_4" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                        $catSel_1 = get_lebel_by_value_in_theme_settings('home_category_4');
                        $cat = get_all_data_array('cc_product_category');
                        foreach ($cat as $val){
                    ?>
                    <option value="<?php echo $val->prod_cat_id;?>"
                        <?php echo ($val->prod_cat_id == $catSel_1)?'selected':'';?>><?php echo $val->category_name;?>
                    </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <?php
                    $home_category_baner_1 = get_lebel_by_value_in_theme_settings_with_theme('home_category_baner_4',$theme);
                    echo image_view('uploads/home_category', '', $home_category_baner_1, 'noimage.png', 'w-25');
                ?><br>
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('home_category_baner_4',$theme);?></label>
                <input type="file" class="form-control" name="home_category_baner_4">
            </div>
            <input type="hidden" class="form-control" required name="prefix" value="4">
            <button class="btn btn-primary">Save</button>
        </form>
    </div>

    <div class="col-md-6 card p-2">
        <form action="<?php echo base_url('home_category_update') ?>" method="post" enctype="multipart/form-data">
            <h3>Category Section Five</h3>
            <div class="form-group">
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('home_category_title_5',$theme);?></label>
                <input type="text" class="form-control" required name="home_category_title_5"
                    value="<?php echo get_lebel_by_value_in_theme_settings_with_theme('home_category_title_5',$theme);?>">
            </div>
            <div class="form-group">
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('home_category_5',$theme);?> </label>
                <select name="home_category_5" class="form-control" required>
                    <option value="">Please Select</option>
                    <?php
                        $catSel_1 = get_lebel_by_value_in_theme_settings('home_category_5');
                        $cat = get_all_data_array('cc_product_category');
                        foreach ($cat as $val){
                    ?>
                    <option value="<?php echo $val->prod_cat_id;?>"
                        <?php echo ($val->prod_cat_id == $catSel_1)?'selected':'';?>><?php echo $val->category_name;?>
                    </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <?php
                    $home_category_baner_1 = get_lebel_by_value_in_theme_settings_with_theme('home_category_baner_5',$theme);
                    echo image_view('uploads/home_category', '', $home_category_baner_1, 'noimage.png', 'w-25');
                ?><br>
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('home_category_baner_5',$theme);?></label>
                <input type="file" class="form-control" name="home_category_baner_5">
            </div>
            <input type="hidden" class="form-control" required name="prefix" value="5">
            <button class="btn btn-primary">Save</button>
        </form>
    </div>

    <div class="col-md-6 card p-2">
        <form action="<?php echo base_url('banner_bottom_update') ?>" method="post" enctype="multipart/form-data">
            <h3>Banner Bottom</h3>
            <div class="form-group">
                <?php
                    $banner_bottom = get_lebel_by_value_in_theme_settings_with_theme('banner_bottom',$theme);
                    echo image_view('uploads/banner_bottom', '', $banner_bottom, 'noimage.png', 'w-100');
                ?><br>
                <label><?php echo get_lebel_by_title_in_theme_settings_with_theme('banner_bottom',$theme);?></label>
                <input type="file" class="form-control" name="banner_bottom">
            </div>
            <button class="btn btn-primary">Save</button>

        </form>
    </div>

</div>