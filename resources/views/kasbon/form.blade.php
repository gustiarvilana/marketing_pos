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
                        <label for="nik" class="col-md-2 col-md-offset-1 control-label">nama Karyawan</label>
                        <div class="col-md-6">
                            <select name="nik" id="nik" class="form-control" required>
                                <option value="">--Pilih Karyawan--</option>
                                @foreach ($karyawan as $nik => $nama)
                                    <option value="{{ $nik }}">{{ $nik }} / {{ $nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tgl_kasbon" class="col-md-2 col-md-offset-1 control-label">tgl_kasbon</label>
                        <div class="col-md-6">
                            <input type="text" name="tgl_kasbon" id="tgl_kasbon" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nom_kasbon" class="col-md-2 col-md-offset-1 control-label">nom_kasbon</label>
                        <div class="col-md-6">
                            <input type="text" name="nom_kasbon" id="nom_kasbon" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ket_keperluan" class="col-md-2 col-md-offset-1 control-label">ket_keperluan</label>
                        <div class="col-md-6">
                            <textarea name="ket_keperluan" id="ket_keperluan" class="form-control" rows="4" required></textarea>
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