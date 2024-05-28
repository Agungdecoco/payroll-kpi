@extends('layouts.main')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Parameter KPI</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('parameter.create') }}">Home</a></li>
                    <li class="breadcrumb-item">Parameter KPI</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <a class="btn btn-success" href="{{ route('parameter.create') }}">
                                    + Buat Baru
                                </a>
                            </div>

                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Bobot</th>
                                        <th>Divisi</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($parameters as $index => $parameter)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $parameter->parameter }}</td>
                                            <td>{{ $parameter->category }}</td>
                                            <td>{{ $parameter->weight }}</td>
                                            <td>{{ $parameter->division->division }}</td>
                                            <td>{{ $parameter->description }}</td>
                                            <td>
                                                <a href="{{ route('parameter.edit', $parameter->id) }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="deleteParameter({{ $parameter->id }})">Hapus</button>
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
        function deleteParameter(id) {
            if (confirm('Apakah Anda yakin ingin menghapus parameter ini ini?')) {
                fetch(`/master/parameter/` + id, {
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
