@extends('layouts.master')  

@section('content')

<!-- Content Row -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4 ">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-center">
                <form action="{{ route('dashboard.index') }}" class="form-inline">
                    <label> </label><h6 class="m-0 font-weight-bold text-primary mr-3">Pilih Periode</h6> </label>
                    <select name="periode" id="periode" class="form-control">
                        <option value="">Sedang Berjalan</option>
                        <option value="1">(1) Januari - Februari</option>
                        <option value="2">(2) Februari - Maret</option>
                        <option value="3">(3) Maret - April</option>
                        <option value="4">(4) April - Mei</option>
                        <option value="5">(5) Mei - Juni</option>
                        <option value="6">(6) Juni - Juli</option>
                        <option value="7">(7) Juli - Agustus</option>
                        <option value="8">(8) Agustus - September</option>
                        <option value="9">(9) September - Oktober</option>
                        <option value="10">(10) Oktober - November</option>
                        <option value="11">(11) November - Desember</option>
                        <option value="11">(12) Desember - Januari-new</option>
                    </select>
                    <button type="submit">Go</button>
                </form>
                </div>
        </div>
    </div>

    <div class="row">
        <!-- Pejualan Bruto Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah SP Baru</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if ($jml_sp_baru)
                                    {{ $jml_sp_baru->count() }}
                                @else
                                    0
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Penjualan Verif Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                SP Verif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if ($jml_sp_verif)
                                    {{ $jml_sp_verif->count() }}
                                @else
                                    0
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Penjualan Terkirim Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                SP Terkirim</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                       @if ($jml_sp_terkirim)
                                           {{ $jml_sp_terkirim->count() }}
                                       @else
                                           0
                                       @endif 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Card disable -->
        <div class="col-xl-3 col-md-6 mb-4">
            {{-- <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Earnings (Monthly)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Tidak lolos Verif Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Tidak lolos Verif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if ($jml_sp_tolak_verif)
                                    {{ $jml_sp_tolak_verif->count() }}
                                @else
                                    0
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tidak Terkirim Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Tidak Terkirim</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if ($jml_sp_tolak_kirim)
                                    {{ $jml_sp_tolak_kirim->count() }}
                                @else
                                    0
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card disable -->
        <div class="col-xl-3 col-md-6 mb-4">
            {{-- <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

    </div>
<!-- Content Row -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content Row -->
    @if (Auth::user()->level == 25 || Auth::user()->level == 99)
         <!-- tabel Penjualan GTM -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Penjualan GTM</h6>
                    
                </div>
                <!-- Card Body -->
                <div class="card-body table-responsive" >
                    <table class="table table-striped table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                {{-- <th> No </th> --}}
                                <th> Nik </th>
                                <th width=25%> Nama </th>
                                <th width=25%> Periode Awal </th>
                                <th width=25%> Periode Akhir </th>
                                <th width=25%> Penjualan </th>
                                <th> CN </th>
                                <th width=25%> Total Penjualan </th>
                            </tr>
                            </thead>
                            <tbody>
                                 @foreach ($penjualan->unique('kdiv_marketing') as $item)
                                    <tr>
                                        <td>{{ $item->kdiv_marketing }}</td>
                                        <td>{{ $item->nama_kdiv }}</td>
                                        <td>{{ $item->tgl_awal }}</td>
                                        <td>{{ $item->tgl_akhir }}</td>
                                        <td>{{ $penjualan->where('kdiv_marketing',$item->kdiv_marketing)->sum('total_harga') }}</td>
                                        <td>{{ $penjualan->where('kdiv_marketing',$item->kdiv_marketing)->sum('cn') }}</td>
                                        <td>{{ $penjualan->where('kdiv_marketing',$item->kdiv_marketing)->sum('total_harga') - $penjualan->where('kdiv_marketing',$item->kdiv_marketing)->sum('cn') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    @endif
    @if (Auth::user()->level == 23 || Auth::user()->level == 25 || Auth::user()->level == 99  )
        <!-- tabel Penjualan TM -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Penjualan TM</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered table-inverse" style="display: block;">
                        <thead class="thead-inverse">
                            <tr>
                                {{-- <th> No </th> --}}
                                <th> Nik </th>
                                <th width=25%> Nama TM </th>
                                <th width=25%> Nama GTM </th>
                                <th width=25%> Periode Awal </th>
                                <th width=25%> Periode Akhir </th>
                                <th> Penjualan </th>
                                <th> (CN) </th>
                                <th width=25%> Total Penjualan </th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($penjualan->unique('t_manager') as $item)
                                    <tr>
                                        <td>{{ $item->t_manager }}</td>
                                        <td>{{ $item->nama_tm }}</td>
                                        <td>{{ $item->nama_gtm }}</td>
                                        <td>{{ $item->tgl_awal }}</td>
                                        <td>{{ $item->tgl_akhir }}</td>
                                        <td>{{ $penjualan->where('t_manager',$item->t_manager)->sum('total_harga') }}</td>
                                        <td>{{ $penjualan->where('t_manager',$item->t_manager)->sum('cn') }}</td>
                                        <td>{{ $penjualan->where('t_manager',$item->t_manager)->sum('total_harga') - $penjualan->where('t_manager',$item->t_manager)->sum('cn') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @if (Auth::user()->level == 32 || Auth::user()->level == 23 || Auth::user()->level == 25 || Auth::user()->level == 99 )
        <!-- tabel Penjualan Sales -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Penjualan Sales</h6>
                    
                </div>
                <!-- Card Body -->
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered table-inverse" style="display: block;">
                        <thead class="thead-inverse">
                            <tr>
                                {{-- <th> No </th> --}}
                                <th> Nik Sales </th>
                                <th width=25%> Nama Sales </th>
                                <th> Nama TM </th>
                                <th> Nama GTM </th>
                                <th width=25%> Periode Awal </th>
                                <th width=25%> Periode Akhir </th>
                                <th> Penjualan </th>
                                <th> (CN) </th>
                                <th width=25%> Total Penjualan </th>
                            </tr>
                            </thead>
                            <tbody>            
                               @foreach ($penjualan->unique('sales') as $item)
                                    <tr>
                                        <td>{{ $item->sales }}</td>
                                        <td>{{ $item->nama_sales }}</td>
                                        <td>{{ $item->nama_tm }}</td>
                                        <td>{{ $item->nama_gtm }}</td>
                                        <td>{{ $item->tgl_awal }}</td>
                                        <td>{{ $item->tgl_akhir }}</td>
                                        <td>{{ $penjualan->where('t_manager',$item->t_manager)->sum('total_harga') }}</td>
                                        <td>{{ $penjualan->where('t_manager',$item->t_manager)->sum('cn') }}</td>
                                        <td>{{ $penjualan->where('t_manager',$item->t_manager)->sum('total_harga') - $penjualan->where('t_manager',$item->t_manager)->sum('cn') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
 
</div>
<!-- /.container-fluid -->

@endsection


@push('script')
<script>
    let tahun = $("#filter_tahun").val()
    $(document).ready(function () {

        var table = $('.table').DataTable({
            proccesing: true,
            searching:true,
            autoWidth: false,
        });
    });

</script>
@endpush