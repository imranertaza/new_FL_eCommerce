<?= $this->extend('Admin/layout') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Blog Schedule create</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Blog Schedule create</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title">Blog Schedule create</h3>
                    </div>
                    <div class="col-md-4">
                        <a href="<?php echo base_url('blog-schedule') ?>" class="btn btn-danger float-right btn-xs"> Back</a>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px">
                        <?php if (session()->getFlashdata('message') !== null) : echo session()->getFlashdata('message'); endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="<?php echo base_url('blog-schedule-create-action')?>" method="post" >
                    <?= csrf_field() ?>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Schedule Name <span class="requi">*</span></label>
                                <input type="text" name="schedule_name" class="form-control" placeholder="Title" required>
                            </div>
                            <div class="form-group">
                                <label>Start Date <span class="requi">*</span></label>
                                <input type="date" name="start_date"  class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>End Date <span class="requi">*</span></label>
                                <input type="date" name="end_date"  class="form-control" required>
                            </div>
                            <button class="btn btn-primary" >Create</button>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Blog </label>
                                <select class="select2bs4" name="blog_id[]" multiple="multiple" data-placeholder="Select a Blog" style="width: 100%;" required>
                                    <?php foreach ($blog as $val) { ?>
                                        <option value="<?= $val->blog_id; ?>"><?= $val->blog_title; ?></option>
                                    <?php } ?>

                                </select>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">

            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<?= $this->endSection() ?>
<?= $this->section('java_script') ?>
<script>
</script>
<?= $this->endSection() ?>
