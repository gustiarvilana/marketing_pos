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

@section('title')
    Page Penjualan
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('transaksi.baru') }}" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i> Tambah Transaksi</a>
        </div>
        <div class="card-body">
            {{-- <div class="panel-body">
                    <div class="form-group">
                        <label for="filter_name">Cari Nama</label>
                        <input type="text" class="form-control filter" name="filter_name" id="filter_name" placeholder="search name">
                    </div>
            </div> --}}
            <table class="table table-striped table-inverse table-bordered table-responsive" id="table">
                <thead class="thead-inverse">
                    <tr>
                        <th>No</th>
                        <th>No SP</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Kelurahan</th>
                        <th>Kecamatan</th>
                        <th>Kota</th>
                        <th>Status flow</th>
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
    let name = $("#filter_name").val()

    $(document).ready(function () {

        var table = $('#table').DataTable({
            proccesing: true,
            searching:true,
            autoWidth: false,
            ajax: {
                url: '{{ route('penjualan.data') }}',
                data: function(d){
                    d.name = name;
                }
            },
            columns: [
                {data: 'DT_RowIndex',searcable: false,sortable: false},
                {data: 'nosp'},
                {data: 'nama_customer'},
                {data: 'alamat'},
                {data: 'kelurahan'},
                {data: 'kecamatan'},
                {data: 'kota'},
                {data: 'sts_flow'},
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
        name = $("#filter_name").val() 
        
        $('#table').DataTable().ajax.reload(null,false)
    });
</script>
@endpush