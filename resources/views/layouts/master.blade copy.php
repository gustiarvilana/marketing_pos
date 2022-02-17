<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RAM | Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset("assets") }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("assets") }}/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset("assets") }}/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset("assets") }}/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset("assets") }}/dist/css/skins/_all-skins.min.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ asset("assets") }}/bower_components/morris.js/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset("assets") }}/bower_components/jvectormap/jquery-jvectormap.css">
    <!-- Date Picker -->
    <link rel="stylesheet"
        href="{{ asset("assets") }}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset("assets") }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset("assets") }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset("assets") }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- DataTables Button -->
    <link rel="stylesheet" href="{{ asset("assets") }}/bower_components/datatables.net-bs/css/buttons.dataTables.min.css">
    
    @stack('css')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

{{-- <body class="hold-transition skin-blue sidebar-mini sidebar-collapse"> --}}
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        @include('layouts.header')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{ asset("assets") }}/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>{{ Auth::user()->name }}</p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                @include('layouts.sidebar')
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Dashboard
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <br>
            <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>44</h3>

                                <p>Customer Ordering</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route('salles.index') }}" class="small-box-footer btnPage">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>150</h3>

                                <p>Customer Verified</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('verif.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>53<sup style="font-size: 20px">%</sup></h3>

                                <p>Customer Delivered</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('delivery.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3>65</h3>

                                <p>Customer disverified</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{ route('cancel.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
            <!-- /.row -->
                
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        @include('layouts.footer')
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="{{ asset("assets") }}/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset("assets") }}/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset("assets") }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="{{ asset("assets") }}/bower_components/raphael/raphael.min.js"></script>
    <script src="{{ asset("assets") }}/bower_components/morris.js/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="{{ asset("assets") }}/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="{{ asset("assets") }}/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="{{ asset("assets") }}/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset("assets") }}/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="{{ asset("assets") }}/bower_components/moment/min/moment.min.js"></script>
    <script src="{{ asset("assets") }}/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="{{ asset("assets") }}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js">
    </script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset("assets") }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="{{ asset("assets") }}/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="{{ asset("assets") }}/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset("assets") }}/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset("assets") }}/dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset("assets") }}/dist/js/demo.js"></script>

    <!-- DataTables -->
    <script src="{{ asset("assets") }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset("assets") }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- Button export DataTables -->
    <script src="{{ asset("assets") }}/bower_components/datatables.net-bs/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset("assets") }}/bower_components/datatables.net-bs/js/buttons.print.min.js"></script>
    <script src="{{ asset("assets") }}/bower_components/datatables.net-bs/js/buttons.colVis.min.js"></script>
    <script src="{{ asset("assets") }}/bower_components/datatables.net-bs/js/buttons.html5.min.js"></script>
    <script src="{{ asset("assets") }}/bower_components/datatables.net-bs/js/jszip.min.js"></script>
    <script src="{{ asset("assets") }}/bower_components/datatables.net-bs/js/pdfmake.min.js"></script>
    <script src="{{ asset("assets") }}/bower_components/datatables.net-bs/js/vfs_fonts.js"></script>
    {{-- validator --}}
    <script src="{{ asset("js") }}/validator.min.js"></script>
    {{-- dorpdown Dinamis --}}
    <script>

    $('#provinsi').change(function(){
    var prov_id = $(this).val();    
        if(prov_id){
                $.ajax({
                type:"GET",
                url:"{{ route('marketing.getkota') }}?prov_id="+prov_id,
                dataType: 'JSON',
                success:function(res){               
                    if(res){
                        $("#kota").empty();
                        $("#kecamatan").empty();
                        $("#kelurahan").empty();
                        $("#kota").append('<option>---Pilih Kota---</option>');
                        $("#kecamatan").append('<option>---Pilih Kecamatan---</option>');
                        $("#keluraham").append('<option>---Pilih Keluraham---</option>');
                        $.each(res,function(nama,kode){
                            $("#kota").append('<option value="'+kode+'">'+nama+'</option>');
                        });
                    }else{
                    $("#kota").empty();
                    $("#kecamatan").empty();
                    $("#kelurahan").empty();
                    }
                }
                });
            }else{
                $("#kota").empty();
                $("#kecamatan").empty();
                $("#kelurahan").empty();
            }      
    });
        
    $('#kota').change(function(){
        var city_id = $(this).val();    
        if(city_id){
            $.ajax({
            type:"GET",
            url:"{{ route('marketing.getkecamatan') }}?city_id="+city_id,
            dataType: 'JSON',
            success:function(res){               
                if(res){
                    $("#kecamatan").empty();
                    $("#kelurahan").empty();
                    $("#kecamatan").append('<option>---Pilih Kecamatan---</option>');
                    $("#kelurahan").append('<option>---Pilih Kelurahan---</option>');
                    $.each(res,function(nama,kode){
                        $("#kecamatan").append('<option value="'+kode+'">'+nama+'</option>');
                    });
                }else{
                $("#kecamatan").empty();
                $("#kelurahan").empty();
                }
            }
            });
        }else{
            $("#kecamatan").empty();
            $("#kelurahan").empty();
        }      
    });

    $('#kecamatan').change(function(){
        var dis_id = $(this).val();    
        if(dis_id){
            $.ajax({
            type:"GET",
            url:"{{ route('marketing.getkelurahan') }}?dis_id="+dis_id,
            dataType: 'JSON',
            success:function(res){               
                if(res){
                    $("#kelurahan").empty();
                    $("#kelurahan").append('<option>---Pilih Kelurahan---</option>');
                    $.each(res,function(nama,kode){
                        $("#kelurahan").append('<option value="'+kode+'">'+nama+'</option>');
                    });
                }else{
                $("#kelurahan").empty();
                }
            }
            });
        }else{
            $("#kecamatan").empty();
        }      
    });

    </script>

    @stack('script')
</body>

</html>
