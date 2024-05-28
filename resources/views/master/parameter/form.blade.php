<form method="POST"
    action="{{ isset($parameter) ? route('parameter.update', $parameter->id) : route('parameter.store') }}">
    @csrf
    @if (isset($parameter))
        @method('PUT')
    @endif

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Divisi</label>
        <div class="col-sm-10">
            <select class="form-select" name="division" aria-label="Default select example">
                <option value="">- Pilih divisi -</option>
                @foreach ($divisions as $division)
                    <option value="{{ $division->id }}"
                        {{ isset($parameter) && $parameter->division_id == $division->id ? 'selected' : '' }}>
                        {{ $division->division }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Kategori</label>
        <div class="col-sm-10">
            <select class="form-select" name="category" aria-label="Default select example">
                <option value="">- Pilih kategori -</option>
                <option value="kedisiplinan"
                    {{ isset($parameter) && $parameter->category == 'kedisiplinan' ? 'selected' : '' }}>Kedisiplinan
                </option>
                <option value="sikap" {{ isset($parameter) && $parameter->category == 'sikap' ? 'selected' : '' }}>
                    Sikap</option>
                <option value="kesehatan"
                    {{ isset($parameter) && $parameter->category == 'kesehatan' ? 'selected' : '' }}>Kesehatan
                </option>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputText" class="col-sm-2 col-form-label">Nama Parameter</label>
        <div class="col-sm-10">
            <input type="text" name="nama" class="form-control"
                value="{{ old('nama', $parameter->parameter ?? '') }}">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputNumber" class="col-sm-2 col-form-label">Bobot</label>
        <div class="col-sm-10">
            <input type="text" name="weight" class="form-control"
                value="{{ old('weight', $parameter->weight ?? '') }}">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputDescription" class="col-sm-2 col-form-label">Deskripsi</label>
        <div class="col-sm-10">
            <textarea class="form-control" name="description" style="height: 100px">{{ old('description', $parameter->description ?? '') }}</textarea>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 text-center">
            <button type="submit" class="btn btn-primary">{{ isset($parameter) ? 'Update' : 'Simpan' }}</button>
        </div>
    </div>
</form>
