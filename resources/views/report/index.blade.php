@extends('layouts.main')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Laporan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item">Laporan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Segmen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->level->level }}</td>
                                    <td>{{ $user->segment->segment }}</td>
                                    <td>
                                        <a href="{{ route('report.list', $user->id) }}" class="btn btn-primary btn-sm">Lihat
                                            Laporan</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
