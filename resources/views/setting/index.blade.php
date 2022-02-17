@extends('layouts.master')

@section('title')
Page Setting
@endsection

@section('content')

<!-- Content Row -->
@if (session('alert'))
    <div>
        <hr>
    </div>
    <div class="alert alert-success text-center">
        {{ session('alert') }}
    </div>
    <div>
        <hr>
    </div>            
@endif

@if (Auth::user()->level == 32)
    {{-- Seting periode --}}
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header py-3 text-center">
                        <div class="row d-flex justify-content-center text-center">
                            <div class="ceter">
                                <h3>Periode Setting</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">

                        <div class="row d-flex justify-content-center text-center">
                            <div class="ceter">
                                @if ($periode_jalan == null)
                                {{-- ================Start================= --}}
                                <div class="col-lg-12">
                                    <div class="card-body">
                                        <form class="form-inline" action="{{ route('setting.store') }}" method="POST">
                                            @csrf
                                            <label>Periode Awal</label>
                                            <input type="hidden" name="nik_tm" id="nik_tm" value="{{ Auth::user()->nik }}">
                                            <input type="text" class="form-control m-2" id="tahun_periode"
                                                placeholder="YYYY - 2022" name="tahun_periode" required>
                                            <select name="periode" id="periode" class="form_control" required>
                                                <option value="">---Pilih Bulan---</option>
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
                                            <input type="text" class="form-control m-2" id="tgl_awal"
                                                placeholder="Tgl legkap - 20220101" name="tgl_awal" required>
            
                                            <button type="submit" class="btn btn-primary">Mulai Penjualan</button>
                                        </form>
                                    </div>
                                </div>
                                {{-- ================Start================= --}}
                                @else
                                {{-- =====================Close============================ --}}
                                <div class="col-lg-12">
                                    <div class="card-body">
                                        <form class="form-inline"
                                            action="{{ route('setting.update',$periode_jalan->tgl_awal) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="nik_tm" value="{{ $periode_jalan->nik_tm }}">
                                            <input type="hidden" name="tahun_periode"
                                                value="{{ $periode_jalan->tahun_periode }}">
                                            <input type="hidden" name="periode" value="{{ $periode_jalan->periode }}">
                                            <label>Periode Akhir</label>
                                            <input type="text" class="form-control m-2" id="tgl_akhir"
                                                placeholder="Ketik tanggal - 20220101" name="tgl_akhir">
            
                                            <button type="submit" class="btn btn-success">Tutup Penjualan</button>
                                        </form>
                                    </div>
                                </div>
                                {{-- =====================Close============================ --}}
                                @endif
                            </div>
                        </div>

                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Tahun</th>
                                    <th> Periode </th>
                                    <th>Tanggal Awal</th>
                                    <th>Tanggal Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($periode as $item)
                                <tr>
                                    <td>{{ $item->tahun_periode }}</td>
                                    <td>{{ $item->periode }}</td>
                                    <td>{{ $item->tgl_awal }}</td>
                                    <td>{{ $item->tgl_akhir }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    {{-- end Seting periode --}}
@endif
<br>
<br>
@if (Auth::user()->level == 25)
    {{-- Upload data CN --}}
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header py-3 text-center">
                        <div class="row d-flex justify-content-center text-center">
                            <div class="ceter">
                                <h3>Upload data CN</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive">
                        <div class="container justify-content-center text-center">
                            <div class="d-flex justify-content-center text-center">
                                <div class="card bg-light mt-3">
                                    <div class="card-header">
                                        Import data CN sesuai format Excel yang telah ditentukan.
                                    </div>
                                    <div class="card-body">
                                        <small> data CN periode 2022 </small>
                                        <form action="{{ route('cnimport') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group form-inline">
                                                <select name="periode" id="periode" class="form-control m-3" required>
                                                    <option value="">--Pilih Periode--</option>
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
                                                <input type="text" class="form-control" name="tahun" id="tahun" placeholder="--ketik Tahun YYYY -- 2022" required>
                                            </div>
                                            <input type="file" name="file" class="form-control" required>
                                            <br>
                                            <button class="btn btn-success">Import User Data</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <table class="table table-striped table-bordered table-inverse">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Periode</th>
                                            <th>Jumlah CN</th>
                                            <th>Nominal CN</th>
                                            <th>Tanggal Input</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($log_upload_cn as $item)
                                            <tr>
                                                <td scope="row">{{ $item->tahun }}</td>
                                                <td>{{ $item->periode }}</td>
                                                <td>{{ $item->jumlah_cn }}</td>
                                                <td> Rp. {{ format_uang($item->nominal_cn) }}</td>
                                                <td>{{ $item->tanggal_input }}</td>
                                            </tr>     
                                            @endforeach
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- end Upload data CN --}}    
@endif










@endsection