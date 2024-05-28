@extends('layouts.main')

@section('content')
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
        }

        .container {
            /* width: 770px; */
            border: 1px solid #000;
            padding: 20px;
        }

        header,
        .employee-info,
        .financials,
        .kpi,
        footer {
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 22px;
            margin: 0;
        }

        .employee-info,
        .financials {
            display: flex;
            justify-content: space-between;
        }

        .employee-info div,
        .financials div,
        .kpi {
            width: 49%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            /* text-align: left; */
        }

        th {
            background-color: #f2f2f2;
        }

        footer {
            text-align: right;
        }
    </style>
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Detail Laporan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item">Data</li>
                    <li class="breadcrumb-item">Detail</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <a href="{{ route('report.view', $report->id) }}" type="button"
                                    class="btn btn-primary">Download Laporan</a>
                            </div>
                            <div class="container">
                                <div class="employee-info">
                                    <div>
                                        <p>Nama: {{ $report->user->name }}</p>
                                        <p>BKS - 05882</p>
                                        <p>RS PON JAKARTA</p>
                                    </div>
                                    <div style="text-align: end">
                                        <p>Jabatan: {{ $report->user->level->level }}
                                            {{ $report->user->segment->division->division }} -
                                            {{ $report->user->segment->segment }}</p>
                                        <p>Periode / Bulan: {{ $periode }}</p>
                                        <p>Keterangan: Transfer</p>
                                    </div>
                                </div>
                                <div class="financials">
                                    <div class="income">
                                        <h5>Gaji / Income</h5>
                                        <table>
                                            <tr>
                                                <th>No</th>
                                                <th>Rincian</th>
                                                <th>Jumlah (Rp.)</th>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Gaji Berdasarkan KPI</td>
                                                <td align="right">{{ round($salary_by_kpi) }}</td>
                                            </tr>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($allowances as $allowance)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $allowance->allowance . ' (' . $allowance->amount . ')' }}</td>
                                                    <td align="right">{{ $allowance->amount * $total_masuk_kerja }}</td>
                                                </tr>
                                            @endforeach
                                            <!-- Lainnya -->
                                        </table>
                                    </div>
                                    <div class="deductions">
                                        <h5>Potongan / Deduction</h5>
                                        <table>
                                            <tr>
                                                <th>No</th>
                                                <th>Rincian</th>
                                                <th>Jumlah (Rp.)</th>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>BPJS Tenaga Kerja</td>
                                                <td align="right">{{ $report->bpjs_tk }}</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>BPJS Jaminan Pensiun</td>
                                                <td align="right">{{ $report->bpjs_jp }}</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>BPJS Kesehatan</td>
                                                <td align="right">{{ $report->bpjs_kes }}</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Pajak</td>
                                                <td align="right">{{ $tax }}</td>
                                            </tr>
                                            <!-- Lainnya -->
                                        </table>
                                    </div>
                                </div>
                                <div class="kpi">
                                    <h5>Skor KPI / KPI Score</h5>
                                    <table>
                                        <tr>
                                            <th>No</th>
                                            <th>Rincian</th>
                                            <th>Skor</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Kedisiplinan</td>
                                            <td align="right">{{ round($report->skor_kedisiplinan) }} / 50</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Sikap</td>
                                            <td align="right">{{ round($report->skor_sikap) }} / 40</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Kesehatan</td>
                                            <td align="right">{{ round($report->skor_kesehatan) }} / 10</td>
                                        </tr>
                                        <!-- Lainnya -->
                                    </table>
                                </div>
                                <footer>
                                    <p>Total Potongan: Rp {{ $report->deduction_total }}</p>
                                    <p>Total Gaji: Rp {{ $report->salary_total }}</p>
                                </footer>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
