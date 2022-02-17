@extends('layouts.master')

@section('title')
    Tabel Group Marketing
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

<div class="card shadow mb-4">
    {{--  --}}
    <div class="card-body table-responsive">
        <table class="table table-striped table-bordered table-inverse">
            <thead class="thead-inverse">
                <tr>
                    {{-- <th width=5%>No</th> --}}
                    <th>Nik Sales</th>
                    <th>Nama Sales</th>
                    <th>Nik TM</th>
                    <th>Nama TM</th>
                    <th>Nik GTM</th>
                    <th>Nama GTM</th>
                    <th>Nik KADIV</th>
                    <th>Nama KADIV</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $i=0;
                    @endphp
                    @foreach ($group_marketing as $group)
                        <tr>
                            {{-- <td width=5%>{{ $i++ }}</td> --}}
                            <td>{{ $group->nik_sales }}</td>
                            <td>{{ $group->nama_sales }}</td>
                            <td>{{ $group->nik_tm }}</td>
                            <td>{{ $group->nama_tm }}</td>
                            <td>{{ $group->nik_gtm }}</td>
                            <td>{{ $group->nama_gtm }}</td>
                            <td>{{ $group->nik_kdiv }}</td>
                            <td>{{ $group->nama_kdiv }}</td>
                        </tr>           
                    @endforeach
                </tbody>
        </table>
    </div>
</div>

@endsection

@push('script')
<script>
    $(document).ready(function () {

        var table = $('.table').DataTable({
            proccesing: true,
            searching:true,
            autoWidth: false,
           
        });
    });
</script>
@endpush