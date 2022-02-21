<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets') }}/Robots.ico">

    <!-- Custom fonts for this template-->
    <link href="{{ asset("assets") }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset("assets") }}/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{ asset("assets") }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- DataTables -->
    {{-- <link rel="stylesheet" href="{{ asset("assets2") }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> --}}
    <!-- DataTables Button -->
    <link rel="stylesheet" href="{{ asset("assets2") }}/bower_components/datatables.net-bs/css/buttons.dataTables.min.css">

    @stack('css')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    @include('layouts.header')

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
                    </div>

                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('layouts.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin Akan Logout?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">//</div>
                <div class="modal-footer">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" type="button">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset("assets") }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset("assets") }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset("assets") }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset("assets") }}/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    {{-- <script src="{{ asset("assets") }}/vendor/chart.js/Chart.min.js"></script> --}}

    <!-- Page level custom scripts -->
    {{-- <script src="{{ asset("assets") }}/js/demo/chart-area-demo.js"></script>
    <script src="{{ asset("assets") }}/js/demo/chart-pie-demo.js"></script> --}}

     <!-- Page level plugins -->
    <script src="{{ asset("assets") }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset("assets") }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset("assets") }}/js/demo/datatables-demo.js"></script>

    <!-- DataTables -->
    <script src="{{ asset("assets2") }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset("assets2") }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- Button export DataTables -->
    <script src="{{ asset("assets2") }}/bower_components/datatables.net-bs/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset("assets2") }}/bower_components/datatables.net-bs/js/buttons.print.min.js"></script>
    <script src="{{ asset("assets2") }}/bower_components/datatables.net-bs/js/buttons.colVis.min.js"></script>
    <script src="{{ asset("assets2") }}/bower_components/datatables.net-bs/js/buttons.html5.min.js"></script>
    <script src="{{ asset("assets2") }}/bower_components/datatables.net-bs/js/jszip.min.js"></script>
    <script src="{{ asset("assets2") }}/bower_components/datatables.net-bs/js/pdfmake.min.js"></script>
    <script src="{{ asset("assets2") }}/bower_components/datatables.net-bs/js/vfs_fonts.js"></script>
    {{-- validator --}}
    <script src="{{ asset("js") }}/validator.min.js"></script>



    <script>
        $('#provinsi').change(function(){
        var prov_id = $(this).val(); 
        console.log('prov : ', prov_id);
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
            
        $('#kota').click(function(){
            var city_id = $(this).val();    
            console.log('city : ', city_id);
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