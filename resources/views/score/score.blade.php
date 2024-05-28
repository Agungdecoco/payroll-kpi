@extends('layouts.main')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Score</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item">KPI</li>
                    <li class="breadcrumb-item">Score</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <a class="btn btn-success" href="{{ route('kpi.create', ['id' => $id]) }}">
                                    + Buat Penilaian Baru
                                </a>
                            </div>

                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Periode</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($periodes as $index => $periode)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $periode['month'] }} - {{ $periode['year'] }}</td>
                                            <td>
                                                <a href="{{ route('kpi.edit', [$id, 'year' => $periode['year'], 'month' => $periode['month']]) }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
