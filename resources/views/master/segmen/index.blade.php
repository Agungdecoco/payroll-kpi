@extends('layouts.main')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Segmen</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Segmen</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-10">

                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <a class="btn btn-success" href="{{ route('segmen.create') }}">
                                    + Buat Baru
                                </a>
                            </div>

                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Divisi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($segments as $index => $segment)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $segment->segment }}</td>
                                            <td>{{ $segment->division->division }}</td>
                                            <td>
                                                <a href="{{ route('segmen.edit', $segment->id) }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="deleteSegment({{ $segment->id }})">Hapus</button>
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

@section('script')
    <script>
        function deleteSegment(id) {
            if (confirm('Apakah Anda yakin ingin menghapus segmen ini?')) {
                fetch(`/master/segmen/` + id, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                    })
                    .then(data => {
                        console.log(data.message);
                        window.location.reload();
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            }
        }
    </script>
@endsection
