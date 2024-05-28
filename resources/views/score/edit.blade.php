@extends('layouts.main')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Edit KPI Score</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item">KPI</li>
                    <li class="breadcrumb-item">Score</li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">

                <form class="row g-3" action="{{ route('kpi.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-lg-6">
                        <input type="hidden" class="form-control" name="user_id" value="{{ $user->id }}">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Kedisiplinan</h5>

                                @foreach ($disciplineScores as $index => $score)
                                    <input type="hidden" class="form-control" name="disciplineId[{{ $index }}]"
                                        value="{{ $score->parameter_id }}">
                                    <div class="col-12">
                                        <label for="inputDiscipline{{ $index + 1 }}"
                                            class="form-label">{{ $score->parameter->parameter }}</label>
                                        <input type="number" class="form-control" name="discipline[{{ $index }}]"
                                            id="inputDiscipline{{ $index + 1 }}" value="{{ $score->score }}">
                                    </div>
                                @endforeach

                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Sikap</h5>

                                @foreach ($attitudeScores as $index => $score)
                                    <input type="hidden" class="form-control" name="attitudeId[{{ $index }}]"
                                        value="{{ $score->parameter_id }}">
                                    <div class="col-12">
                                        <label for="inputAttitude{{ $index + 1 }}"
                                            class="form-label">{{ $score->parameter->parameter }}</label>
                                        <input type="number" class="form-control" name="attitude[{{ $index }}]"
                                            id="inputAttitude{{ $index + 1 }}" value="{{ $score->score }}">
                                    </div>
                                @endforeach

                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Performa</h5>

                                @foreach ($performanceScores as $index => $score)
                                    <input type="hidden" class="form-control" name="performanceId[{{ $index }}]"
                                        value="{{ $score->parameter_id }}">
                                    <div class="col-12">
                                        <label for="inputPerformance{{ $index + 1 }}"
                                            class="form-label">{{ $score->parameter->parameter }}</label>
                                        <input type="number" class="form-control" name="performance[{{ $index }}]"
                                            id="inputPerformance{{ $index + 1 }}" value="{{ $score->score }}">
                                    </div>
                                @endforeach

                            </div>
                        </div>

                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
