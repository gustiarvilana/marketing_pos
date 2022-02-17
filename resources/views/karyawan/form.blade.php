<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

        <form action="" class="form-horizontal" method="post">
            @csrf
            @method('')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="nik" class="col-md-2 col-md-offset-1 control-label">NIK</label>
                        <div class="col-md-6">
                            <input type="text" name="nik" id="nik" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-md-2 col-md-offset-1 control-label">Nama</label>
                        <div class="col-md-6">
                            <input type="text" name="nama" id="nama" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="alamat" class="col-md-2 col-md-offset-1 control-label">alamat</label>
                        <div class="col-md-6">
                            <input type="text" name="alamat" id="alamat" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kec" class="col-md-2 col-md-offset-1 control-label">kec</label>
                        <div class="col-md-6">
                            <input type="text" name="kec" id="kec" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kota" class="col-md-2 col-md-offset-1 control-label">kota</label>
                        <div class="col-md-6">
                            <input type="text" name="kota" id="kota" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_jabatan" class="col-md-2 col-md-offset-1 control-label">kode_jabatan</label>
                        <div class="col-md-6">
                            <select name="kode_jabatan" id="kode_jabatan">
                                <option value="">Pilih Level</option>
                                @foreach ($jabatan as $item) 
                                    <option value="{{ $item->kode_jabatan }}">{{ $item->nama_jabatan }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="photo" class="col-md-2 col-md-offset-1 control-label">photo</label>
                        <div class="col-md-6">
                            <input type="text" name="photo" id="photo" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_hp" class="col-md-2 col-md-offset-1 control-label">no_hp</label>
                        <div class="col-md-6">
                            <input type="text" name="no_hp" id="no_hp" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_ktp" class="col-md-2 col-md-offset-1 control-label">no_ktp</label>
                        <div class="col-md-6">
                            <input type="text" name="no_ktp" id="no_ktp" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tmk" class="col-md-2 col-md-offset-1 control-label">tmk</label>
                        <div class="col-md-6">
                            <input type="text" name="tmk" id="tmk" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tkk" class="col-md-2 col-md-offset-1 control-label">tkk</label>
                        <div class="col-md-6">
                            <input type="text" name="tkk" id="tkk" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-md-2 col-md-offset-1 control-label">status</label>
                        <div class="col-md-6">
                            <select name="status" id="status" class="form-control" required>
                                <option value="">--pilih Status--</option>
                                <option value="1"> Aktif </option>
                                <option value="0"> Tidak Aktif </option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div> <hr> </div>
                    <br>
                    <h4>Form Link Sales</h4>
                    <br>

                    <div class="form-group row">
                        <label for="nik_sales" class="col-md-2 col-md-offset-1 control-label">nik_sales</label>
                        <div class="col-md-6">
                            <input type="text" name="nik_sales" id="nik_sales" class="form-control" >
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_sales" class="col-md-2 col-md-offset-1 control-label">nama_sales</label>
                        <div class="col-md-6">
                            <input type="text" name="nama_sales" id="nama_sales" class="form-control" >
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nik_tm" class="col-md-2 col-md-offset-1 control-label">nik_tm</label>
                        <div class="col-md-6">
                            <select name="nik_tm" id="nik_tm" class="form-control">
                                <option value="">--Pilih TM--</option>
                                @foreach ($karyawan->where('jabatan',32) as $tm)
                                    <option value="{{ $tm->nik }}"> {{ $tm->nik }} / {{ $tm->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_tm" class="col-md-2 col-md-offset-1 control-label">nama_tm</label>
                        <div class="col-md-6">
                            <input type="text" name="nama_tm" id="nama_tm" class="form-control" >
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nik_gtm" class="col-md-2 col-md-offset-1 control-label">nik_gtm</label>
                        <div class="col-md-6">
                             <select name="nik_gtm" id="nik_gtm" class="form-control">
                                <option value="">--Pilih GTM--</option>
                                @foreach ($karyawan->where('jabatan',23) as $tm)
                                    <option value="{{ $tm->nik }}"> {{ $tm->nik }} / {{ $tm->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_gtm" class="col-md-2 col-md-offset-1 control-label">nama_gtm</label>
                        <div class="col-md-6">
                            <input type="text" name="nama_gtm" id="nama_gtm" class="form-control" >
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nik_kdiv" class="col-md-2 col-md-offset-1 control-label">nik_kdiv</label>
                        <div class="col-md-6">
                            <select name="nik_kdiv" id="nik_kdiv" class="form-control">
                                <option value="">--Pilih GTM--</option>
                                @foreach ($karyawan->where('jabatan',25) as $tm)
                                    <option value="{{ $tm->nik }}"> {{ $tm->nik }} / {{ $tm->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_kdiv" class="col-md-2 col-md-offset-1 control-label">nama_kdiv</label>
                        <div class="col-md-6">
                            <input type="text" name="nama_kdiv" id="nama_kdiv" class="form-control" >
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-xs btn-primary">Simpan</button>
                    <button class="btn btn-xs btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>

    </div>
</div>