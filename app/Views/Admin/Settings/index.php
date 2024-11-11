<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Settings </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin_dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Settings </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <form method="post" action="<?php echo base_url('settings_update_action')?>" enctype="multipart/form-data">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title">Settings </h3>
                    </div>
                    <div class="col-md-4 text-right">
                        <button type="submit" class="btn btn-primary btn-sm " >Save</button>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px">
                        <?php if (session()->getFlashdata('message') !== NULL) : echo session()->getFlashdata('message'); endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">General</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="store-tabs-four-profile-tab" data-toggle="pill" href="#store-tabs-four-store" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Store</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Local</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-currency" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Currency</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-mail" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Mail</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-footer-social" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Social</a>
                                    </li>



                                </ul>
                            </div>
                            <div class="card-body">
                                <?php
                                $settings = get_settings();
                                $settingsTitle = get_settings_title();
                                ?>
                                <div class="tab-content" id="custom-tabs-four-tabContent">

                                    <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['store_name'];?></label>
                                                    <input type="text" name="store_name" class="form-control" value="<?php echo $settings['store_name'];?>"  required>
                                                </div>

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['store_owner'];?></label>
                                                    <input type="text" name="store_owner" class="form-control" value="<?php echo $settings['store_owner'];?>"  required>
                                                </div>

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['address'];?></label>
                                                    <input type="text" name="address" class="form-control" value="<?php echo $settings['address'];?>"  required>
                                                </div>

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['category_product_limit'];?></label>
                                                    <input type="text" name="category_product_limit" class="form-control" value="<?php echo $settings['category_product_limit'];?>"  required>
                                                </div>


                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['email'];?></label>
                                                    <input type="text" name="email" class="form-control" value="<?php echo $settings['email'];?>"  required>
                                                </div>

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['phone'];?></label>
                                                    <input type="text" name="phone" class="form-control" value="<?php echo $settings['phone'];?>"  required>
                                                </div>

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['Theme'];?></label>

                                                    <select name="Theme" class="form-control" required>
                                                        <?php echo available_theme($settings['Theme']);?>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="store-tabs-four-store" role="tabpanel" aria-labelledby="custom-tabs-four-store-tab">
                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['meta_title'];?></label>
                                                    <input type="text" name="meta_title" class="form-control" value="<?php echo $settings['meta_title'];?>"  required>
                                                </div>

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['meta_keyword'];?></label>
                                                    <input type="text" name="meta_keyword" class="form-control" value="<?php echo $settings['meta_keyword'];?>"  required>
                                                </div>


                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['meta_description'];?></label>
                                                    <textarea name="meta_description" rows="5" class="form-control"><?php echo $settings['meta_description'];?></textarea>
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['country'];?></label>
                                                    <select name="country" class="form-control" onchange="selectState(this.value)" required>
                                                        <?php echo country($settings['country']);?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['state'];?></label>
                                                    <select name="state" class="form-control" id="stateView" required >
                                                        <?php echo state_with_country($settings['country'],$settings['state']);?>
                                                    </select>
                                                </div>


                                            </div>
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['length_class'];?></label>

                                                    <select name="length_class" class="form-control" required>
                                                        <?php $valLen = $settings['length_class'];?>
                                                        <option value="Centimeter" <?php echo ($valLen == 'Centimeter')?'selected':'';?> >Centimeter</option>
                                                        <option value="Milimeter" <?php echo ($valLen == 'Milimeter')?'selected':'';?> >Milimeter</option>
                                                        <option value="Inch" <?php echo ($valLen == 'Inch')?'selected':'';?> >Inch</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['weight_class'];?></label>

                                                    <select name="weight_class" class="form-control" required>
                                                        <?php $valweig = $settings['weight_class'];?>
                                                        <option value="Kilogram" <?php echo ($valweig == 'Kilogram')?'selected':'';?> >Kilogram</option>
                                                        <option value="Gram" <?php echo ($valweig == 'Gram')?'selected':'';?> >Gram</option>
                                                        <option value="Pound" <?php echo ($valweig == 'Pound')?'selected':'';?> >Pound</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="custom-tabs-four-currency" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['currency'];?></label>
                                                    <input type="text" name="currency" class="form-control" value="<?php echo $settings['currency'];?>"  required>
                                                </div>

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['currency_symbol'];?></label>
                                                    <input type="text" name="currency_symbol" class="form-control" value="<?php echo $settings['currency_symbol'];?>"  required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['invoice_prefix'];?></label>
                                                    <input type="text" name="invoice_prefix" class="form-control" value="<?php echo $settings['invoice_prefix'];?>"  required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane fade" id="custom-tabs-four-mail" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" name="new_account_alert_mail" <?php echo ($settings['new_account_alert_mail'] == '1')?'checked':'';?> class="custom-control-input" value="1" id="custom2" >
                                                        <label class="custom-control-label" for="custom2"><?php echo $settingsTitle['new_account_alert_mail'];?></label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" name="new_order_alert_mail" <?php echo ($settings['new_order_alert_mail'] == '1')?'checked':'';?> class="custom-control-input" value="1" id="customSwitch1" >
                                                        <label class="custom-control-label" for="customSwitch1"><?php echo $settingsTitle['new_order_alert_mail'];?></label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['mail_protocol'];?></label>
                                                    <input type="text" name="mail_protocol" class="form-control" value="<?php echo $settings['mail_protocol'];?>"  required>
                                                </div>

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['mail_address'];?></label>
                                                    <input type="text" name="mail_address" class="form-control" value="<?php echo $settings['mail_address'];?>"  required>
                                                </div>

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['smtp_host'];?></label>
                                                    <input type="text" name="smtp_host" class="form-control" value="<?php echo $settings['smtp_host'];?>"  required>
                                                </div>

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['smtp_crypto'];?></label>
                                                    <input type="text" name="smtp_crypto" class="form-control" value="<?php echo $settings['smtp_crypto'];?>"  required>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['smtp_port'];?></label>
                                                    <input type="text" name="smtp_port" class="form-control" value="<?php echo $settings['smtp_port'];?>"  required>
                                                </div>

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['smtp_timeout'];?></label>
                                                    <input type="text" name="smtp_timeout" class="form-control" value="<?php echo $settings['smtp_timeout'];?>"  required>
                                                </div>

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['smtp_username'];?></label>
                                                    <input type="text" name="smtp_username" class="form-control" value="<?php echo $settings['smtp_username'];?>"  required>
                                                </div>

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['smtp_password'];?></label>
                                                    <input type="text" name="smtp_password" class="form-control" value="<?php echo $settings['smtp_password'];?>"  required>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="custom-tabs-four-footer-social" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['fb_url'];?></label>
                                                    <input type="text" name="fb_url" class="form-control" value="<?php echo $settings['fb_url'];?>"  required>
                                                </div>

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['twitter_url'];?></label>
                                                    <input type="text" name="twitter_url" class="form-control" value="<?php echo $settings['twitter_url'];?>"  required>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['tiktok_url'];?></label>
                                                    <input type="text" name="tiktok_url" class="form-control" value="<?php echo $settings['tiktok_url'];?>"  required>
                                                </div>

                                                <div class="form-group">
                                                    <label><?php echo $settingsTitle['instagram_url'];?></label>
                                                    <input type="text" name="instagram_url" class="form-control" value="<?php echo $settings['instagram_url'];?>"  required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">

            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->
        </form>
    </section>
    <!-- /.content -->
</div>
<?= $this->endSection() ?>

<?= $this->section('java_script') ?>
<script>
    function selectState(country_id) {
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('get_state') ?>",
            data: {
                country_id: country_id
            },
            beforeSend: function() {
                $("#loading-image").show();
            },
            success: function(data) {
                $("#stateView").html(data);
            }

        });
    }

</script>
<?= $this->endSection() ?>