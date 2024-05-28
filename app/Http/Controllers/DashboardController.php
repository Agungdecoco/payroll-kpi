<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $salary = auth()->user()->salary;
        $year_now = date('Y');
        $month_now = date('M');
        $get_laporan = Report::where([['user_id', auth()->user()->id], ['deleted_at', null]])->whereYear('date', $year_now)->get();
        for ($month = 1; $month <= 12; $month++) {
            $formattedMonth = sprintf("%04d-%02d", $year_now, $month);
            $kpi_data[$formattedMonth] = ['date' => $formattedMonth, 'score' => 0];
        }

        $get_laporan = Report::where([['user_id', auth()->user()->id], ['deleted_at', null]])
            ->whereYear('date', $year_now)
            ->get();

        foreach ($get_laporan as $report) {
            $date = date('Y-m', strtotime($report->date));
            $total_score = $report->skor_kedisiplinan + $report->skor_kesehatan + $report->skor_sikap;
            $kpi_data[$date] = ['date' => $date, 'score' => $total_score];
        }

        $kpi_data = array_values($kpi_data);
        return view('dashboard.index', compact('salary', 'year_now', 'month_now', 'kpi_data'));
    }
}
