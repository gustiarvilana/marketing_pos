@extends('layouts.master')

@section('title')
    Page Kasbon
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
        display: none;
        position: inherit;
        margin: right;
    }
</style>
@endpush

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button onclick="addform('{{ route('kasbon.store') }}')" class="btn-success btn-xs"><i
            class="fa fa-plus-circle"></i> Input Kasbon
        </button>
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
                {{-- <div class="col-lg-12 col-md-6">
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
                </div> --}}
            </div>

        
            <table class="table table-striped table-inverse table-bordered table-responsive" id="table">
            <thead class="thead-inverse">
                <tr>
                    <th>No</th>
                    <th>Nik</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Nominal</th>
                    <th>Keperluan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@includeIf('kasbon.form')

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
                url: '{{ route('kasbon.data') }}',
                data: function(d){
                    d.tahun = tahun;
                    d.bulan = bulan;
                }
            },
            columns: [
                {data: 'DT_RowIndex',searcable: false,sortable: false},
                {data: 'nik'},
                {data: 'nama'},
                {data: 'tgl_kasbon'},
                {data: 'nom_kasbon'},
                {data: 'ket_keperluan'},
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
        $('#modal-form .modal-title').text('Tambah Kasbon');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
    };

    function editform(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit User Kasbon');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nik]').val(response.nik);
                $('#modal-form [name=nama]').val(response.nama);
                $('#modal-form [name=tgl_kasbon]').val(response.tgl_kasbon);
                $('#modal-form [name=nom_kasbon]').val(response.nom_kasbon);
                $('#modal-form [name=ket_keperluan]').val(response.ket_keperluan);
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
        
        $('#table').DataTable().ajax.reload(null,false)
    });
</script>
@endpush