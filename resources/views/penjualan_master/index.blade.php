@extends('layouts.master')

@push('css')
<style>
    .dt-buttons {
        /* display: none; */
        position: inherit;
        text-align:right;
        margin: left;
        margin-right: 30%;
    }   
    /* .dataTables_filter {
        position: inherit;
        margin: right;
    } */

</style>
@endpush

@section('title')
    Page Penjualan Master
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
        <div class="card-header py-3">
            @if($errors->any())
            <h4>{{$errors->first()}}</h4>
            @endif

            @if (session('error'))
                <div>
                    <hr>
                </div>
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
                <div>
                    <hr>
                </div>            
            @endif
        </div>
        <div class="card-body">
            <div class="panel-body">
                <div class="col-lg-12 col-md-6">
                    <div class="form-inline">
                        <div class="form-group">
                            <label for="filter_tahun">Pilih Periode Tahun : </label>
                            <select name="filter_tahun" id="filter_tahun" class="form-control m-3 filter">
                                <option value="">---Pilih Tahun---</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                            </select>
                            <label for="filter_bulan">Pilih Periode Bulan : </label>
                            <select name="filter_bulan" id="filter_bulan" class="form-control m-3 filter">
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
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-6">
                    <div class="form-inline">
                         <div class="form-group">
                            <label for="filter_flow">Pilih Periode Tahun : </label>
                            <select name="filter_flow" id="filter_flow" class="form-control m-3 filter">
                                <option value="">---Pilih Status---</option>
                                @foreach ($sts_flow as $item)
                                <option value="{{ $item->kode_status }}">{{ $item->status }}</option>
                                @endforeach
                            </select>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-inverse table-bordered table-responsive" id="table">
                <thead class="thead-inverse">
                    <tr>
                        <th width=50%>No</th>
                        <th>No SP</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Kelurahan</th>
                        <th>Kecamatan</th>
                        <th>Kota</th>
                        <th>Tgl Jual</th>
                        <th>Status flow</th>
                        <th>Sales</th>
                        <th>TM</th>
                        <th>GTM</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    </div>
    
</div>

@includeIf('customer.form')

@endsection

@push('script')
<script>
    let tahun = $("#filter_tahun").val()
    let bulan = $("#filter_bulan").val()
    let flow = $("#filter_flow").val()

    $(document).ready(function () {

        var table = $('#table').DataTable({
            proccesing: true,
            searching:true,
            autoWidth: false,
            ajax: {
                url: '{{ route('penjualan_master.data') }}',
                data: function(d){
                    d.tahun = tahun;
                    d.bulan = bulan;
                    d.flow = flow;
                }
            },
            columns: [
                {data: 'DT_RowIndex',searcable: false,sortable: false},
                {data: 'nosp'},
                {data: 'nama_customer'},
                {data: 'alamat'},
                {data: 'subdis_name'},
                {data: 'dis_name'},
                {data: 'city_name'},
                {data: 'tgl_jual'},
                {data: 'sts_flow'},
                {data: 'nama_sales'},
                {data: 'nama_tm'},
                {data: 'nama_gtm'},
                {data: 'aksi'},
            ],

            // export
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [ 0, ':visible' ]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 5 ]
                    }
                },
                'colvis'
            ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (!e.preventDefault()) {
                $.ajax({
                        url: $('#modal-form form').attr('action'),
                        type: "post",
                        data: $('#modal-form form').serialize()
                    })
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        $('#table').DataTable().ajax.reload()
                    })
                    .fail((errors) => {
                        alert('Tidak dapat Menyimpan Data');
                        return;
                    });
            }
        })
    });

    function addform(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Customer');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
    };

    function editform(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Customer');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');

        $.get(url)
            .done((response) => {
                $('#modal-form [name=no_sp]').val(response.no_sp);
                $('#modal-form [name=nama_customer]').val(response.nama_customer);
                $('#modal-form [name=username]').val(response.username);
                $('#modal-form [name=alamat]').val(response.alamat);
                $('#modal-form [name=status]').val(response.status);
            })
            .fail((errors) => {
                alert('Tidak Dapat menampilkan data');
                return;
            });
    };

    function deleteform(url) {
        if (confirm('Yakin Akan Menghapus data???')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    $('#table').DataTable().ajax.reload()

                })
                .fail((errors) => {
                    return alert('Tidak Dapat Menghapus Data');
                });
        }
    }

    $(".filter").on('change',function () { 
        tahun = $("#filter_tahun").val()
        bulan = $("#filter_bulan").val()
        flow = $("#filter_flow").val()
        console.log([tahun,bulan,flow]);
        
        $('#table').DataTable().ajax.reload(null,false)
    });
</script>
@endpush