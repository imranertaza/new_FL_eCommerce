<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo get_lebel_by_value_in_settings('store_name'); ?> | Admin Panel</title>
    <link rel="shortcut icon" href="<?php echo base_url() ?>/uploads/logo/<?php echo get_lebel_by_value_in_theme_settings('favicon')->value;?>">

    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-header" content="<?= csrf_header() ?>">
    <meta name="csrf-name" content="<?= csrf_token() ?>">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url() ?>/admin_assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?php echo base_url() ?>/admin_assets/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url() ?>/admin_assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>/admin_assets/dist/css/custome.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
          href="<?php echo base_url() ?>/admin_assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url() ?>/admin_assets/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo base_url() ?>/admin_assets/plugins/summernote/summernote-bs4.min.css">

    <link rel="stylesheet"
          href="<?php echo base_url() ?>/admin_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
          href="<?php echo base_url() ?>/admin_assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet"
          href="<?php echo base_url() ?>/admin_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet"
          href="<?php echo base_url() ?>/admin_assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
          href="<?php echo base_url() ?>/admin_assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
          href="<?php echo base_url() ?>/admin_assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url() ?>/admin_assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet"
          href="<?php echo base_url() ?>/admin_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet"
          href="<?php echo base_url() ?>/admin_assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="<?php echo base_url() ?>/admin_assets/plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="<?php echo base_url() ?>/admin_assets/plugins/dropzone/min/dropzone.min.css">
    <!-- Theme style -->

    <!--    lightbox-->
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/assets_fl/lightbox.min.css">
    <script src="<?php echo base_url() ?>/assets/assets_fl/lightbox-plus-jquery.min.js"></script>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <!--    <div class="preloader flex-column justify-content-center align-items-center">-->
    <!---->
    <!--        <i class="fas fa-3x fa-sync-alt fa-spin"></i>-->
    <!--        <div class="text-bold pt-2">Loading...</div>-->
    <!--    </div>-->

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" title="Logout" href="<?php echo base_url('admin_logout')?>" role="button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 20px;">
                        <path
                            d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z" />
                    </svg> </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>

        </ul>
    </nav>
    <!-- /.navbar -->


    <?= $this->include('Admin/sidebar'); ?>

    <?= $this->renderSection('content'); ?>




    <footer class="main-footer">
        <strong>Copyright &copy; 2023 <a href="dnationsoft.com">Dnationsoft</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.1.0
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/jquery/jquery.min.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url() ?>/admin_assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url() ?>/admin_assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!-- DataTables  & Plugins -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>/admin_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>/admin_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>/admin_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>/admin_assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>

<script src="<?php echo base_url() ?>/admin_assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>/admin_assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo base_url() ?>/admin_assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo base_url() ?>/admin_assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>/admin_assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>/admin_assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>/admin_assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Select2 -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url() ?>/admin_assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="<?php echo base_url() ?>/admin_assets/plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->


<script src="<?php echo base_url() ?>/admin_assets/dist/js/pages/dashboard.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>/admin_assets/dist/js/adminlte.min.js"></script>

<script>
    // This is for go Back Button at the top -- Start --
    function goBack() {
        window.history.back();
    }
    // This is for go Back Button at the top -- End --

    // This is for DataTable -- Start --
    $(function() {

        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "targets": 'no-sort',
            "bSort": false,
            // "stateSave": true,
            "order": [
                [0, "desc"]
            ],
            // "bStateSave": true,
            // "fnStateSave": function (oSettings, oData) {
            //     localStorage.setItem('example1DataTables', JSON.stringify(oData));
            // },
            // "fnStateLoad": function (oSettings) {
            //     return JSON.parse(localStorage.getItem('example1DataTables'));
            // }
            // "buttons": ["csv", "excel", "pdf", "print" ]
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $("#dataTable1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "targets": 'no-sort',
            "bSort": false,
            // "stateSave": true,
            "order": [
                [0, "desc"]
            ],
            // "bStateSave": true,
            // "fnStateSave": function (oSettings, oData) {
            //     localStorage.setItem('example1DataTables', JSON.stringify(oData));
            // },
            // "fnStateLoad": function (oSettings) {
            //     return JSON.parse(localStorage.getItem('example1DataTables'));
            // }
            // "buttons": ["csv", "excel", "pdf", "print" ]
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "autoWidth": false,
            "responsive": true,
            "targets": 'no-sort',
            "bSort": false,
            "drawCallback": function( settings ) {
                checkShowHideRow();
            }
        });

        $('#productBulkEdit').DataTable({
            "paging": true,
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "stateSave": true,
            "targets": 'no-sort',
            "bSort": false,
            "drawCallback": function( settings ) {
                checkShowHideRow();
                image_load();
            }
        });



        $("#productListData").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "stateSave": true,
            "targets": 'no-sort',
            "bSort": false,
            "order": [
                [0, "desc"]
            ],
            "buttons": ["csv", "excel", "pdf", "print" ]
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#productListData_wrapper .col-md-6:eq(0)');

        <?php if (isset(newSession()->resetDatatable) && (newSession()->resetDatatable == true)){  ?>
        var table = $("#productListData").DataTable();
        table.search('').draw();
        table.page('first').draw('page');
        table.page.len(10).draw();

        <?php } if (isset($_GET['page'])){  ?>
        $('#productListData').DataTable().page(<?= $_GET['page']-1;?>).draw('page');
        $('#productBulkEdit').DataTable().page(<?= $_GET['page']-1;?>).draw('page');
        <?php } ?>

        if(sessionStorage.getItem("bulkDataTableReset") == '1'){
            var table = $("#productBulkEdit").DataTable();
            // Reset search query
            table.search('').draw();
            table.page('first').draw('page');
            table.page.len(10).draw();
        }
        sessionStorage.removeItem("bulkDataTableReset");
    });
    // This is for DataTable -- End --

    function bulk_datatable_reset(){
        sessionStorage.setItem("bulkDataTableReset", '1' );
    }


    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        $('.select2_pro').select2({
            multiple: true,
            theme: 'bootstrap4',
            ajax: {
                url: "<?php echo base_url('related_product') ?>",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            var img = '<img src="<?php echo base_url('uploads/products')?>/'+item.product_id+'/100_'+item.image+'" class="" loading="lazy" />' + item.name;
                            // var img = "<span ><img src='<?php echo base_url('uploads/products')?>/"+item.product_id+"/100_"+item.image+"' c/>" + item.name+"</span >";
                            return {
                                text: item.name,
                                id: item.product_id,

                            }

                        })
                    };
                },
                cache: true
            }
        });

        $('.bought_together_pro').select2({
            multiple: true,
            theme: 'bootstrap4',
            ajax: {
                url: "<?php echo base_url('related_product') ?>",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.product_id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('.product').select2({
            multiple: false,
            theme: 'bootstrap4',
            ajax: {
                url: "<?php echo base_url('related_product') ?>",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.product_id
                            }
                        })
                    };
                },
                cache: true
            }
        });


        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
        })

        $('.select2bs4_2').select2({
            theme: 'bootstrap4'
        })

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {
            'placeholder': 'mm/dd/yyyy'
        })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                        .endOf('month')
                    ]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        )

        //Timepicker
        $('#timepicker').datetimepicker({
            format: 'LT'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        })

        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

    })

    $(function () {
        // Summernote
        $('#editor').summernote();
    })

    $(document).ready(function(){
        $('#image').change(function(){
            $("#frames").html('');
            for (var i = 0; i < $(this)[0].files.length; i++) {
                $("#frames").append('<img src="'+window.URL.createObjectURL(this.files[i])+'" width="150px" height="150px" style="margin-left: 10px; margin-top: 10px;" />');
            }
        });

        $('#defimage').change(function(){
            $("#framesdef").html('');
            for (var i = 0; i < $(this)[0].files.length; i++) {
                $("#framesdef").append('<img src="'+window.URL.createObjectURL(this.files[i])+'" width="150px" height="150px"/>');
            }
        });

        $('#singleimage').change(function(){
            $("#framessingle").html('');
            for (var i = 0; i < $(this)[0].files.length; i++) {
                $("#framessingle").append('<img src="'+window.URL.createObjectURL(this.files[i])+'" width="300px" height=""/>');
            }
        });

    });

    function check_required_option(){
        var result = true;
        var mess = '<div class="alert alert-danger alert-dismissible" role="alert">All field are required! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'

        $('[name^="qty"]').each(function() {
            qty = parseInt(this.value);
            if (isNaN(qty)){
                result = false;
            }
        });

        $('[name^="price_op"]').each(function() {
            price = parseInt(this.value);
            if (isNaN(price)){
                result = false;
            }
        });

        $('[name^="opValue"]').each(function() {
            opValue = parseInt(this.value);
            if (isNaN(opValue)){
                result = false;
            }
        });


        if (result == false) {
            $('#message').html(mess);
        }else{
            $('#message').html('');
        }
    }

    function check_required_attribute(){
        var result = true;
        var mess = '<div class="alert alert-danger alert-dismissible" role="alert">All field are required! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'

        $('[name^="attribute_group_id"]').each(function() {
            group = parseInt(this.value);
            if (isNaN(group)){
                result = false;
            }
        });

        $('[name^="name"]').each(function() {
            name = parseInt(this.value);
            if (isNaN(name)){
                result = false;
            }
        });


        if (result == false) {
            $('#message').html(mess);
        }else{
            $('#message').html('');
        }
    }

    //form submit code (start)
    var timeout = null;
    function table_form_submit(){
        if (timeout !== null) {
            clearTimeout(timeout);
        }
        timeout = setTimeout(function () {
            $('#tableForm').submit();
        }, 1000);
        // $('#tableForm').submit();
    }

    $(document).ajaxComplete(function(event, xhr) {
        let headerName = $('meta[name="csrf-header"]').attr('content');
        let newToken   = xhr.getResponseHeader(headerName);
        if (newToken) {
            $('meta[name="csrf-token"]').attr('content', newToken);
        }
    });

</script>
<?= $this->renderSection('java_script') ?>
</body>
</html>
