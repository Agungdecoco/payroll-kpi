<form method="POST"
    action="{{ isset($allowance) ? route('tunjangan.update', $allowance->id) : route('tunjangan.store') }}">
    @csrf
    @if (isset($allowance))
        @method('PUT')
    @endif

    <div class="row mb-3">
        <label for="inputText" class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-10">
            <input type="text" name="nama" class="form-control"
                value="{{ old('nama', $allowance->allowance ?? '') }}">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputNumber" class="col-sm-2 col-form-label">Jumlah</label>
        <div class="col-sm-10">
            <input type="number" name="amount" class="form-control"
                value="{{ old('amount', $allowance->amount ?? '') }}">
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 text-center">
            <button type="submit" class="btn btn-primary">{{ isset($allowance) ? 'Update' : 'Simpan' }}</button>
        </div>
    </div>
</form>
