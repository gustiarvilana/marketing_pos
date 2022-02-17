@extends('layouts.master')

@section('title')
    Delivery Detail
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('penjualan.index') }}" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i> Back</a>
        </div>
        <div class="card-body">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>No Sp</td>
                                    <td>:</td>
                                    <td>{{ $customer->nosp }}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>{{ $customer->nama_customer }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td>{{ $customer->alamat }}</td>
                                </tr>
                                <tr>
                                    <td>Kota</td>
                                    <td>:</td>
                                    <td>{{ $customer->kota }}</td>
                                </tr>
                                <tr>
                                    <td>Kecamatan</td>
                                    <td>:</td>
                                    <td>{{ $customer->kecamatan }}</td>
                                </tr>
                                <tr>
                                    <td>Kelurahan</td>
                                    <td>:</td>
                                    <td>{{ $customer->kelurahan }}</td>
                                </tr>
                                <tr>
                                    <td>Telpon/HP</td>
                                    <td>:</td>
                                    <td>{{ $customer->no_tlp }}</td>
                                </tr>
                                <tr>
                                    <td>Status Beli</td>
                                    <td>:</td>
                                    <td>{{ $customer->sts_beli }}</td>
                                </tr>
                                <tr>
                                    <td>Tgl Jual</td>
                                    <td>:</td>
                                    <td>{{ $customer->tgl_jual }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>Salles</td>
                                    <td>:</td>
                                    <td>{{ $customer->sales }}</td>
                                </tr>
                                <tr>
                                    <td>verifikator</td>
                                    <td>:</td>
                                    <td>{{ $customer->verifikator }}</td>
                                </tr>
                                <tr>
                                    <td>tgl_verif</td>
                                    <td>:</td>
                                    <td>{{ $customer->tgl_verif }}</td>
                                </tr>
                                <tr>
                                    <td>TM</td>
                                    <td>:</td>
                                    <td>{{ $customer->t_manager }}</td>
                                </tr>
                                <tr>
                                    <td>GTM</td>
                                    <td>:</td>
                                    <td>{{ $customer->gt_manager }}</td>
                                </tr>
                                <tr>
                                    <td>K.DIV. Marketing</td>
                                    <td>:</td>
                                    <td>{{ $customer->kdiv_marketing }}</td>
                                </tr>
                                <tr>
                                    <td>Driver</td>
                                    <td>:</td>
                                    <td>{{ $customer->kd_driver }}</td>
                                </tr>
                                <tr>
                                    <td>tgl_delivery</td>
                                    <td>:</td>
                                    <td>{{ $customer->tgl_delivery }}</td>
                                </tr>
                                <tr>
                                    <td>kd_helper</td>
                                    <td>:</td>
                                    <td>{{ $customer->kd_helper }}</td>
                                </tr>
                                <tr>
                                    <td>Diinput Oleh</td>
                                    <td>:</td>
                                    <td>{{ $customer->batch_user }}</td>
                                </tr>
                                <tr>
                                    <td>Status Prosess</td>
                                    <td>:</td>
                                    <td>{{ $customer->sts_flow }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($customer->ket_input)
                    <div class="div">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width=25%></th>
                                    <th width=50%>                                            <label>Keterangan Iput :</label>
                                            <div class="card-body">
                                                <textarea rows="3" disabled>{{ $customer->ket_input }}</textarea>
                                                 
                                            </div>                                    </th>
                                    <th width=25%></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                @endif

                @if ($customer->ket_verif)
                    <div class="div">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width=25%></th>
                                    <th width=50%>                                            <label>Keterangan Verif :</label>
                                            <div class="card-body">
                                                <textarea rows="3" disabled>{{ $customer->ket_verif }}</textarea> 
                                            </div>                                    </th>
                                    <th width=25%></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                @endif

                <div><hr></div>

                <table class="table table-bordered table-inverse">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Kode Produk</th>
                            <th>Harga Produk</th>
                            <th>Jumlah Produk</th>
                        </tr>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk as $key=>$item)
                            <tr>
                                <td>{{ $item -> kode_produk }}</td>
                                <td>{{ $item -> harga_produk }}</td>
                                <td>{{ $item -> jml_barang }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                </table>
                <div><hr></div>
                <table class="table">
                    <thead>
                        <tr>
                            <th width= 25%></th>
                            <th width= 50%>
                                <div class="card">
                                    <div class="card-body">
                                        <form action="{{ route('verif.show',$customer->nosp) }}" method="put">
                                            @csrf
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <strong>Nama Driver</strong>
                                                        <input type="text" class="form-control" name="kd_driver" id="kd_driver" required>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <strong>Nama Helper</strong>
                                                        <input type="text" class="form-control" name="kd_helper" id="kd_helper" required>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <strong>Status Delivery</strong>
                                                        <select name="sts_flow" id="sts_flow" class="form-control" required>
                                                            <option value=""> --Pilih Status-- </option>
                                                            <option value="4"> Diterima </option>
                                                            <option value="30"> Ditolak </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <strong>Keterangan</strong>
                                                        <textarea class="form-control" style="height:75px" name="ket_delivery"
                                                            placeholder="ket_delivery"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </th>
                            <th width= 25%></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    </div>
    
</div>

@endsection

