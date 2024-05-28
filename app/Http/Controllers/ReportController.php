<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Report;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        if (auth()->user()->level_id == 1) {
            $users = User::where('deleted_at', null)->get();
        } elseif (auth()->user()->level_id == 2) {
            $users = User::where([['deleted_at', null], ['division_id', auth()->user()->segment->division_id]])->get();
        } elseif (auth()->user()->level_id == 3) {
            $users = User::where([['deleted_at', null], ['id', auth()->user()->id]])->get();
        }
        return view('report.index', compact('users'));
    }

    public function indexReport($id)
    {
        $reports = Report::with('tax')
            ->where('user_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('report.list', compact('reports'));
    }

    public function show($id)
    {
        $total_hari_kerja = date('t') - round(date('t') / 7);
        $report = Report::with('user')->where('id', $id)->first();
        $allowances_id = json_decode($report->tunjangan, true);
        $allowances = Allowance::whereIn('id', $allowances_id)->where('deleted_at', null)->get();
        $periode = date('F Y', strtotime($report->date));
        $tax = $report->salary_per_hour * $total_hari_kerja * ($report->tax->percentage / 100);
        $normal_salary = $report->salary_per_hour * $total_hari_kerja;
        $total_masuk_kerja = $total_hari_kerja - $report->absent_total;
        $salary_by_kpi = $normal_salary * (($report->skor_kedisiplinan / 100) + ($report->skor_sikap / 100) + ($report->skor_kesehatan / 100));
        return view('report.detail', compact('report', 'allowances', 'periode', 'tax', 'normal_salary', 'salary_by_kpi', 'total_masuk_kerja'));
    }

    public function viewPdf($id)
    {
        $total_hari_kerja = date('t') - round(date('t') / 7);
        $report = Report::with('user')->where('id', $id)->first();
        $allowances_id = json_decode($report->tunjangan, true);
        $allowances = Allowance::whereIn('id', $allowances_id)->where('deleted_at', null)->get();
        $periode = date('F Y', strtotime($report->date));
        $tax = $report->salary_per_hour * $total_hari_kerja * ($report->tax->percentage / 100);
        $normal_salary = $report->salary_per_hour * $total_hari_kerja;
        $total_masuk_kerja = $total_hari_kerja - $report->absent_total;
        $salary_by_kpi = $normal_salary * (($report->skor_kedisiplinan / 100) + ($report->skor_sikap / 100) + ($report->skor_kesehatan / 100));

        $data = [
            'report' => $report,
            'allowances' => $allowances,
            'periode' => $periode,
            'tax' => $tax,
            'normal_salary' => $normal_salary,
            'salary_by_kpi' => $salary_by_kpi,
            'total_masuk_kerja' => $total_masuk_kerja
        ];
        $pdf = \PDF::loadView('report.viewpdf', $data);

        // return view('report.viewpdf', compact('report', 'allowances', 'periode', 'tax', 'normal_salary', 'salary_by_kpi', 'total_masuk_kerja'));
        // return $pdf->download(date('Y_m', strtotime($report->date)) . '_slip_gaji_' . $report->user->name . '.pdf');
        return $pdf->stream();
    }
}
