@extends('layouts.master')

@section('title')
    Page Gaji
@endsection

@push('css')
<style>
    .dt-buttons {
        /* display: none; */
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

@section('content')

@if (session('msg'))
    <div>
        <hr>
    </div>
    <div class="alert alert-success text-center">
        {{ session('msg') }}
    </div>
    <div>
        <hr>
    </div>        
@elseif(session('error'))
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

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ route('gaji.prosess') }}" class="btn btn-success btn-xs"><i
            class="fa fa-plus-circle"></i> Hitung Gaji</a>
    </div>
    <div class="card-body">
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
        <table class="table table-striped table-inverse table-bordered table-responsive" id="table">
            <thead class="thead-inverse">
                <tr>
                    <th>No</th>
                    <th>nik</th>
                    <th>nama</th>
                    <th>jabatan</th>
                    <th>penjualan</th>
                    <th>cn</th>
                    <th>penjualan_bersih</th>
                    <th>incentive</th>
                    <th>bonus</th>
                    <th>total_gaji</th>
                    <th>kasbon</th>
                    <th>periode</th>
                    <th>tahun</th>
                    <th>tgl_open_tm</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@endsection

@push('script')
<script>
    let tahun = $("#filter_tahun").val()
    let bulan = $("#filter_bulan").val()

    $(document).ready(function () {

        var table = $('#table').DataTable({
            proccesing: true,
            searching:true,
            autoWidth: false,
            ajax: {
                url: '{{ route('gaji.data') }}',
                data: function(d){
                    d.tahun = tahun;
                    d.bulan = bulan;
                }
            },
            columns: [
                {data: 'DT_RowIndex',searcable: false,sortable: false},
                {data: 'nik'},
                {data: 'nama'},
                {data: 'jabatan'},
                {data: 'penjualan'},
                {data: 'cn'},
                {data: 'penjualan_bersih'},
                {data: 'incentive'},
                {data: 'bonus'},
                {data: 'total_gaji'},
                {data: 'kasbon'},
                {data: 'periode'},
                {data: 'tahun'},
                {data: 'tgl_open_tm'},
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
        $('#modal-form .modal-title').text('Tambah User');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
    };

    function editform(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit User');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nik]').val(response.nik);
                $('#modal-form [name=name]').val(response.name);
                $('#modal-form [name=username]').val(response.username);
                $('#modal-form [name=email]').val(response.email);
                $('#modal-form [name=level]').val(response.level);
                $('#modal-form [name=password]').val(response.password);
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
        console.log([tahun,bulan]);
        
        $('#table').DataTable().ajax.reload(null,false)
    });
</script>
@endpush