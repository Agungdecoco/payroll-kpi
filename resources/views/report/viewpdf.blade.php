<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji</title>
</head>

<body>
    <style>
        @page {
            size: A4;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
        }

        .container {
            width: 650px;
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

        .employee-info>div,
        .financials>div {
            display: inline-block;
            vertical-align: top;
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
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        footer {
            text-align: right;
        }
    </style>
    <header style="text-align: center">
        <h1>PT. BAKRI KARYA SARANA</h1>
        <p>Jl. Diponegoro. Ruko Global 22 No. 10 & 11</p>
        <p>Kel. Buliang Kec. Batu Aji - Batam</p>
        <p>Tel: 0778 - 326824</p>
    </header>
    <div class="employee-info">
        <div>
            <p>Nama: {{ $report->user->name }}</p>
            <p>BKS - 05882</p>
            <p>RS PON JAKARTA</p>
        </div>
        <div style="text-align: right">
            <p>Jabatan: {{ $report->user->level->level }} {{ $report->user->segment->division->division }} -
                {{ $report->user->segment->segment }}</p>
            <p>Periode / Bulan: {{ $periode }}</p>
            <p>Keterangan: Transfer</p>
        </div>
    </div>
    <div class="financials">
        <div class="income">
            <h2>Gaji / Income</h2>
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
            <h2>Potongan / Deduction</h2>
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
        <h2>Skor KPI / KPI Score</h2>
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
        <p>ACC & FINANCE DEPT.</p>
        <br>
        <br>
        <br>
        <br>
        <p>(......................................)</p>
    </footer>
</body>

</html>
