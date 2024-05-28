@extends('layouts.main')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Laporan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item">Data</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">

                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Periode</th>
                                        <th>Gaji Total</th>
                                        <th>Pajak</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reports as $index => $report)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $report->date }}</td>
                                            <td>Rp {{ $report->salary_total }}</td>
                                            <td>{{ $report->tax->percentage }}%</td>
                                            <td>
                                                <a href="{{ route('report.detail', $report->id) }}"
                                                    class="btn btn-primary btn-sm">Detail</a>
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
