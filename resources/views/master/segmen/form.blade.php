<form method="POST" action="{{ isset($segment) ? route('segmen.update', $segment->id) : route('segmen.store') }}">
    @csrf
    @if (isset($segment))
        @method('PUT')
    @endif

    <div class="row mb-3">
        <label for="inputText" class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-10">
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $segment->segment ?? '') }}">
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Divisi</label>
        <div class="col-sm-10">
            <select class="form-select" name="division" aria-label="Default select example">
                <option value="">- Pilih divisi -</option>
                @foreach ($divisions as $division)
                    <option value="{{ $division->id }}"
                        {{ isset($segment) && $segment->division_id == $division->id ? 'selected' : '' }}>
                        {{ $division->division }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 text-center">
            <button type="submit" class="btn btn-primary">{{ isset($segment) ? 'Update' : 'Simpan' }}</button>
        </div>
    </div>
</form>
