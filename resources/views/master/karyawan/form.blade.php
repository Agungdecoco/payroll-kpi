<form method="POST" action="{{ isset($user) ? route('karyawan.update', $user->id) : route('karyawan.store') }}">
    @csrf
    @if (isset($user))
        @method('PUT')
    @endif

    <div class="row mb-3">
        <label for="inputText" class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-10">
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $user->name ?? '') }}">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputText" class="col-sm-2 col-form-label">Telepon</label>
        <div class="col-sm-10">
            <input type="text" name="telp" class="form-control" value="{{ old('telp', $user->telephone ?? '') }}">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
            <input type="password" name="password" class="form-control" placeholder="Isi untuk mengubah password">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputPassword" class="col-sm-2 col-form-label">Alamat</label>
        <div class="col-sm-10">
            <textarea class="form-control" name="address" style="height: 100px">{{ old('address', $user->address ?? '') }}</textarea>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Jabatan</label>
        <div class="col-sm-10">
            <select class="form-select" name="level" aria-label="Default select example">
                <option value="">- Pilih jabatan -</option>
                @foreach ($levels as $level)
                    <option value="{{ $level->id }}"
                        {{ isset($user) && $user->level_id == $level->id ? 'selected' : '' }}>{{ $level->level }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Divisi</label>
        <div class="col-sm-10">
            <select class="form-select" id="division-select" name="division">
                <option value="">- Pilih divisi -</option>
                @foreach ($divisions as $division)
                    <option value="{{ $division->id }}">
                        {{ $division->division }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Segmen</label>
        <div class="col-sm-10">
            <select class="form-select" id="segment-select" name="segment">
                <option value="">- Pilih segmen -</option>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputSalary" class="col-sm-2 col-form-label">Gaji</label>
        <div class="col-sm-10">
            <div class="input-group">
                <span class="input-group-text">Rp.</span><input type="number" name="salary" class="form-control"
                    value="{{ old('salary', $user->salary ?? '') }}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 text-center">
            <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update' : 'Simpan' }}</button>
        </div>
    </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#division-select').change(function() {
            var divisionId = $(this).val();
            if (divisionId) {
                $.ajax({
                    url: '/master/segmen/by_division/' + divisionId,
                    type: "GET",
                    success: function(data) {
                        $('#segment-select').empty();
                        $('#segment-select').append(
                            '<option value="">- Pilih segmen -</option>');
                        $.each(data, function(key, value) {
                            $('#segment-select').append('<option value="' + key +
                                '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('#segment-select').empty();
                $('#segment-select').append('<option value="">- Pilih segmen -</option>');
            }
        });
    });
</script>
