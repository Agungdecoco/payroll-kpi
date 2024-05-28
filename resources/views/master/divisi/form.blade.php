<form method="POST" action="{{ isset($division) ? route('divisi.update', $division->id) : route('divisi.store') }}">
    @csrf
    @if (isset($division))
        @method('PUT')
    @endif

    <div class="row mb-3">
        <label for="inputText" class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-10">
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $division->division ?? '') }}">
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 text-center">
            <button type="submit" class="btn btn-primary">{{ isset($division) ? 'Update' : 'Simpan' }}</button>
        </div>
    </div>
</form>
