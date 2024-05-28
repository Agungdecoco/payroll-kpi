@extends('layouts.main')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Form Penggajian</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Penggajian</li>
                    <li class="breadcrumb-item active">Form</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-10">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Gaji Periode - {{ $periode }}</h5>

                            <form method="POST" action="{{ route('payroll.store', $id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <legend class="col-form-label col-sm-2 pt-0">Tunjangan BPJS</legend>
                                    <div class="col-sm-10">

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="bpjstk" id="bpjstk">
                                            <label class="form-check-label" for="bpjstk">
                                                BPJS Tenaga Kerja
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="bpjsjp" id="bpjsjp">
                                            <label class="form-check-label" for="bpjsjp">
                                                BPJS Jaminan Sosial
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="bpjskes" id="bpjskes">
                                            <label class="form-check-label" for="bpjskes">
                                                BPJS Kesehatan
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <legend class="col-form-label col-sm-2 pt-0">Tunjangan Lainnya</legend>
                                    <div class="col-sm-10">

                                        @foreach ($allowances as $allowance)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="allowances[]"
                                                    id="allowance{{ $allowance->id }}" value="{{ $allowance->id }}">
                                                <label class="form-check-label" for="allowance{{ $allowance->id }}">
                                                    {{ $allowance->allowance . ' (' . $allowance->amount . ')' }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <legend class="col-form-label col-sm-2 pt-0">Pajak</legend>
                                    <div class="col-sm-10">


                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="tax" id="tax"
                                                value="{{ $tax->id }}" checked>
                                            <label class="form-check-label" for="tax">
                                                {{ $tax->percentage . '%' }}
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary">Gaji</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
