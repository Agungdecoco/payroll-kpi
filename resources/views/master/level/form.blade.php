<form method="POST" action="{{ isset($level) ? route('level.update', $level->id) : route('level.store') }}">
    @csrf
    @if (isset($level))
        @method('PUT')
    @endif

    <div class="row mb-3">
        <label for="inputText" class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-10">
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $level->level ?? '') }}">
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 text-center">
            <button type="submit" class="btn btn-primary">{{ isset($level) ? 'Update' : 'Simpan' }}</button>
        </div>
    </div>
</form>
