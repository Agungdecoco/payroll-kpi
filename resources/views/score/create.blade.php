@extends('layouts.main')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Form Layouts</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item">KPI</li>
                    <li class="breadcrumb-item">Score</li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">

                <form class="row g-3" action="{{ route('kpi.store') }}" method="POST">
                    @csrf
                    <div class="col-lg-6">
                        <input type="hidden" class="form-control" name="user_id" value="{{ $id }}">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Kedisiplinan</h5>

                                @if ($discipline->count() > 0)
                                    @foreach ($discipline as $index => $param)
                                        <input type="hidden" class="form-control" name="disciplineId[{{ $index }}]"
                                            value="{{ $param->id }}">
                                        <div class="col-12">
                                            <label for="inputDiscipline{{ $index + 1 }}"
                                                class="form-label">{{ $param->parameter }}</label>
                                            <input type="number" class="form-control"
                                                name="discipline[{{ $index }}]"
                                                id="inputDiscipline{{ $index + 1 }}">
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Kedisiplinan</h5>

                                @if ($attitude->count() > 0)
                                    @foreach ($attitude as $index => $param)
                                        <input type="hidden" class="form-control" name="attitudeId[{{ $index }}]"
                                            value="{{ $param->id }}">
                                        <div class="col-12">
                                            <label for="inputAttitude{{ $index + 1 }}"
                                                class="form-label">{{ $param->parameter }}</label>
                                            <input type="number" class="form-control" name="attitude[{{ $index }}]"
                                                id="inputAttitude{{ $index + 1 }}">
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Kedisiplinan</h5>

                                @if ($performance->count() > 0)
                                    @foreach ($performance as $index => $param)
                                        <input type="hidden" class="form-control"
                                            name="performanceId[{{ $index }}]" value="{{ $param->id }}">
                                        <div class="col-12">
                                            <label for="inputPerformance{{ $index + 1 }}"
                                                class="form-label">{{ $param->parameter }}</label>
                                            <input type="number" class="form-control"
                                                name="performance[{{ $index }}]"
                                                id="inputPerformance{{ $index + 1 }}">
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
