@extends('layouts.master')

@push('css')
<style>
    .dt-buttons {
        display: none;
        position: inherit;
        text-align:right;
        margin: left;
        margin-right: 30%;
    }   
    .dataTables_filter {
        position: inherit;
        margin: right;
    }
</style>
@endpush

@push('css')
<style>
    .tampil-bayar {
        font-size: 5em;
        text-align: center;
        height: 100px;
    }

    .tampil-terbilang {
        padding: 10px;
        background: #f0f0f0;
    }

    .table-penjualan tbody tr:last-child {
        display: none;
    }

    @media(max-width: 768px) {
        .tampil-bayar {
            font-size: 3em;
            height: 70px;
            padding-top: 5px;
        }
    }
</style>
@endpush

@section('title')
    Page Penjualan Detail
@endsection


@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="text-center">
                    @if($errors->any())
                    <span class="badge badge-danger"><h4>Error : {{$errors->first()}}</h4></span>
                    @endif
                </div>
                    id_penjualan : {{ $id_penjualan }}
                <form class="form-produk">
                    @csrf
                    <div class="form-group row">
                        <label for="kode_produk" class="col-lg-2">Kode Produk</label>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <input type="hidden" name="id_penjualan" id="id_penjualan" value="{{ $id_penjualan }}">
                                <input type="hidden" name="id_produk" id="id_produk">
                                <input type="text" class="form-control" name="kd_produk" id="kd_produk">
                                <span class="input-group-btn">
                                    <button onclick="tampilProduk()" class="btn btn-info btn-flat" type="button">Pilih Produk <i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>

                <table class="table table-stiped table-bordered table-penjualan table-responsive">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th width="15%">Jumlah</th>
                        <th>Subtotal</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>

                <hr class="sidebar-divider">

                <div class="row">
                    <div class="col-lg-12">
                        <form action="{{ route('transaksi.simpan') }}" class="form-penjualan form-horizontal" method="post">
                            @csrf

                             <div class="form-group row">
                                <label for="totalrp" class="col-lg-1 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <input type="hidden" name="batch_user" id="batch_user" class="form-control">
                                <input type="hidden" name="sts_flow" id="sts_flow" class="form-control">

                                <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
                                <input type="hidden" name="total_harga" id="total">
                                <input type="hidden" name="total_item" id="total_item">
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group row">
                                    <label for="nosp" class="col-lg-3 control-label">Nosp</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="nosp" id="nosp" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama_customer" class="col-lg-3 control-label">nama_customer</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="nama_customer" id="nama_customer" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="alamat" class="col-lg-3 control-label">alamat</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="alamat" id="alamat" class="form-control" required>
                                    </div>
                                </div>
                                {{-- live ajax --}}
                                    <div class="form-group row">
                                        <label for="provinsi" class="col-lg-3 control-label">Provinsi</label>
                                        <div class="col-lg-8">
                                            <select name="provinsi" id="provinsi">
                                                <option id="provinsi" value="">---Pilih Provinsi---</option>
                                                @foreach ($provinsi as $item)
                                                <option value="{{ $item->prov_id }}">{{ $item->prov_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="kota" class="col-lg-3 control-label">kota</label>
                                        <div class="col-lg-8">
                                           <select class="form-select form-select-lg" name="kota" id="kota">
                                                <option selected>---Pilih Kota---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="kecamatan" class="col-lg-3 control-label">kecamatan</label>
                                        <div class="col-lg-8">
                                            <select class="form-select form-select-lg" name="kecamatan" id="kecamatan" required>
                                                <option selected>---Pilih Kecamatan---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="kelurahan" class="col-lg-3 control-label">kelurahan</label>
                                        <div class="col-lg-8">
                                            <select class="form-select form-select-lg" name="kelurahan" id="kelurahan" required>
                                                <option selected>---Pilih kelurahan---</option>
                                            </select>
                                        </div>
                                    </div>
                                {{-- live ajax --}}
                                <div class="form-group row">
                                    <label for="no_tlp" class="col-lg-3 control-label">no_tlp</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="no_tlp" id="no_tlp" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="sts_beli" class="col-lg-3 control-label">sts_beli</label>
                                    <div class="col-lg-8">
                                        <select name="sts_beli" id="sts_beli" required>
                                            <option value=""> ==== Pilih Tipe Beli == </option>
                                            <option value="1"> Cash </option>
                                            <option value="2"> Credit </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tgl_jual" class="col-lg-3 control-label">tgl_jual</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="tgl_jual" id="tgl_jual" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="sales" class="col-lg-3 control-label">sales</label>
                                    <div class="col-lg-8">
                                        <select name="sales" id="sales" required>
                                            <option value="">---Pilih Sales---</option>
                                            @foreach ($marketing as $item)
                                            <option value="{{ $item->nik_sales }}">{{ $item->nama_sales }} / {{ $item->nik_sales }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="ket_input" class="col-lg-3 control-label">Keterangan</label>
                                    <div class="col-lg-8">
                                        <textarea name="ket_input" id="ket_input" rows="3" class="form-control"></textarea>
                                    </div>
                                </div>

                                {{-- <div class="form-group row">
                                    <label for="verifikator" class="col-lg-3 control-label">verifikator</label>
                                    <div class="col-lg-8">
                                        <input type="hiden" name="verifikator" id="verifikator" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tgl_verif" class="col-lg-3 control-label">tgl_verif</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="tgl_verif" id="tgl_verif" class="form-control">
                                    </div>
                                </div> --}}
                                
                                {{-- <div class="form-group row">
                                    <label for="t_manager" class="col-lg-3 control-label">t_manager</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="t_manager" id="t_manager" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="gt_manager" class="col-lg-3 control-label">gt_manager</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="gt_manager" id="gt_manager" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kdiv_marketing" class="col-lg-3 control-label">kdiv_marketing</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="kdiv_marketing" id="kdiv_marketing" class="form-control">
                                    </div>
                                </div> --}}
                                {{-- <div class="form-group row">
                                    <label for="kd_driver" class="col-lg-3 control-label">kd_driver</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="kd_driver" id="kd_driver" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tgl_delivery" class="col-lg-3 control-label">tgl_delivery</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="tgl_delivery" id="tgl_delivery" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kd_helper" class="col-lg-3 control-label">kd_helper</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="kd_helper" id="kd_helper" class="form-control">
                                    </div>
                                </div> --}}

                                {{-- <div class="form-group row">
                                    <label for="batch_user" class="col-lg-3 control-label">batch_user</label>
                                    <div class="col-lg-8">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="sts_flow" class="col-lg-3 control-label">sts_flow</label>
                                    <div class="col-lg-8">
                                    </div>
                                </div> --}}

                            </div>
                        </form>
                    </div>
                </div>
            </div> 
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
            </div>
        </div>
    </div>
</div>
@includeIf('penjualan_detail.produk')
@endsection

@push('script')
<script>
    let table, table2;
    $(function () {
        $('body').addClass('sidebar-collapse');

        table = $('.table-penjualan').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('transaksi.data', $id_penjualan) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga'},
                {data: 'jumlah'},
                {data: 'subtotal'},
                {data: 'aksi', searchable: false, sortable: false},
            ],
            dom: 'Brt',
            bSort: false,
            paginate: false
        });

        table2 = $('.table-produk').DataTable();

        $(document).on('input', '.quantity', function () {
            let id = $(this).data('id');
            let produk = $(this).data('produk');
            let jumlah = parseInt($(this).val());

            if (jumlah < 1) {
                $(this).val(1);
                alert('Jumlah tidak boleh kurang dari 1');
                return;
            }
            if (jumlah > 10000) {
                $(this).val(10000);
                alert('Jumlah tidak boleh lebih dari 10000');
                return;
            }

            $.post(`{{ url('/transaksi') }}/${id}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'put',
                    'jumlah': jumlah,
                    'produk': produk
                })
                .done(response => {
                    $(this).on('mouseout', function () {
                        table.ajax.reload(() => loadForm($('#diskon').val()));
                    });
                })
                .fail(errors => {
                    alert('Tidak dapat menyimpan data quantitiy');
                    return;
                });
        });

        $('.btn-simpan').on('click', function () {
            $('.form-penjualan').submit();
        });
    });

    function tampilProduk() {
        $('#modal-produk').modal('show');
    }

    function hideProduk() {
        $('#modal-produk').modal('hide');
    }

    function pilihProduk(id, kode) {
        $('#id_produk').val(id);
        $('#kd_produk').val(kode);
        hideProduk();
        tambahProduk();
    }

    function tambahProduk() {
        $.post('{{ route('transaksi.store') }}', $('.form-produk').serialize())
            .done(response => {
                $('#kd_produk').focus();
                table.ajax.reload(() => loadForm());
                table.ajax.reload();
            })
            .fail(function(xhr, status, error) {
                alert(xhr.responseText)
                return;
            });
    }

    function tampilMember() {
        $('#modal-member').modal('show');
    }

    function pilihMember(id, kode) {
        $('#id_member').val(id);
        $('#kode_member').val(kode);
        loadForm($('#diskon').val());
        $('#diterima').val(0).focus().select();
        hideMember();
    }

    function hideMember() {
        $('#modal-member').modal('hide');
    }

    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload(() => loadForm($('#diskon').val()));
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }

    function loadForm() {
        $('#total').val($('.total').text());
        $('#total_item').val($('.total_item').text());
        $.get(`{{ url('/transaksi/loadform') }}/${$('.total').text()}`)
            .done(response => {
                $('#totalrp').val('Rp. '+ response.totalrp);
                $('#sts_flow').val('1');
                $('#batch_user').val(response.batch_user);
            })
            .fail(function(xhr, status, error) {
                alert(xhr.responseText)
                return;
            });
    }
</script>
@endpush
