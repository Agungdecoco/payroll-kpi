@extends('layouts.main')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Pajak</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Pajak</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Persentase Pajak
                                Perusahaan</h5>

                            <!-- General Form Elements -->
                            <form method="POST"
                                action="{{ $tax != null ? route('pajak.update', $tax->id) : route('pajak.update') }}">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-sm-8">
                                        <input type="number" name="percentage" class="form-control"
                                            value="{{ $tax != null ? $tax->percentage : '' }}">
                                    </div>

                                    <div class="col-sm-4">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>

                            </form><!-- End General Form Elements -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
