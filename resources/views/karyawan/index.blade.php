@extends('layouts.master')

@section('title')
    Page Karyawan
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

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button onclick="addform('{{ route('karyawan.store') }}')" class="btn-success btn-xs"><i
            class="fa fa-plus-circle"></i> Tambah Karyawan
        </button>
    </div>
    <div class="card-body">
        {{-- <div class="text-center">
             <div class="form-group">
                <label for="filter_name">Cari Nama</label>
                <input type="text" class="form-control filter" name="filter_name" id="filter_name" placeholder="search name">
            </div>
        </div> --}}
        <table class="table table-striped table-inverse table-bordered table-responsive" id="table">
            <thead class="thead-inverse">
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Username</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@includeIf('karyawan.form')

@endsection

@push('script')
<script>
    let name = $("#filter_name").val()

    $(document).ready(function () {

        var table = $('#table').DataTable({
            proccesing: true,
            searching:true,
            autoWidth: false,
            ajax: {
                url: '{{ route('karyawan.data') }}',
                data: function(d){
                    d.name = name;
                }
            },
            columns: [
                {data: 'DT_RowIndex',searcable: false,sortable: false},
                {data: 'nik'},
                {data: 'nama'},
                {data: 'nama_jabatan'},
                {data: 'username'},
                {data: 'alamat'},
                {data: 'status'},
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
        $('#modal-form .modal-title').text('Tambah Karyawan');

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
                $('#modal-form [name=nama]').val(response.nama);
                $('#modal-form [name=alamat]').val(response.alamat);
                $('#modal-form [name=kec]').val(response.kec);
                $('#modal-form [name=kota]').val(response.kota);
                $('#modal-form [name=kode_jabatan]').val(response.kode_jabatan);
                $('#modal-form [name=photo]').val(response.photo);
                $('#modal-form [name=no_hp]').val(response.no_hp);
                $('#modal-form [name=tmk]').val(response.tmk);
                $('#modal-form [name=tkk]').val(response.tkk);
                $('#modal-form [name=status]').val(response.status);

                $('#modal-form [name=nik_sales]').val(response.nik_sales);
                $('#modal-form [name=nama_sales]').val(response.nama_sales);
                $('#modal-form [name=nik_tm]').val(response.nik_tm);
                $('#modal-form [name=nama_tm]').val(response.nama_tm);
                $('#modal-form [name=nik_gtm]').val(response.nik_gtm);
                $('#modal-form [name=nama_gtm]').val(response.nama_gtm);
                $('#modal-form [name=nik_kdiv]').val(response.nik_kdiv);
                $('#modal-form [name=nama_kdiv]').val(response.nama_kdiv);
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
        name = $("#filter_name").val() 
        
        $('#table').DataTable().ajax.reload(null,false)
    });
</script>
@endpush