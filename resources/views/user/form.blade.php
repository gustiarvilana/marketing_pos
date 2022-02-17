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
                        <label for="name" class="col-md-2 col-md-offset-1 control-label">Nama</label>
                        <div class="col-md-6">
                            <input type="text" name="name" id="name" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-md-2 col-md-offset-1 control-label">Username</label>
                        <div class="col-md-6">
                            <input type="text" name="username" id="username" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-2 col-md-offset-1 control-label">Email</label>
                        <div class="col-md-6">
                            <input type="text" name="email" id="email" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="level" class="col-md-2 col-md-offset-1 control-label">Level</label>
                        <div class="col-md-6">
                            <select name="level" id="level">
                                <option value="">Pilih Level</option>
                                @foreach ($jabatan as $item) 
                                    <option value="{{ $item->kode_jabatan }}">{{ $item->nama_jabatan }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-md-2 col-md-offset-1 control-label">Password</label>
                        <div class="col-md-6">
                            <input type="password" name="password" id="password" class="form-control" required>
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