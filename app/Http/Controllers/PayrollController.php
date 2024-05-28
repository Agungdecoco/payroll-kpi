<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Report;
use App\Models\Score;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('segment', 'report')->get();
        $periode = now()->format('F Y');
        return view('payroll.index', compact('users', 'periode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pay($id)
    {
        $allowances = Allowance::all();
        $periode = now()->format('F Y');
        $tax = Tax::where('deleted_at', null)->latest('created_at')->first();
        return view('payroll.pay', compact('allowances', 'periode', 'id', 'tax'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $allowanceTotal = 0;
        $totalHari  = date('t') - round(date('t') / 7);
        $totalAbsent = 0;
        $skorKedisiplinanPembilang = 0;
        $skorKedisiplinanPembagi = 0;
        $skorKedisiplinan = 0;
        $skorSikapSementara = 0;
        $skorSikap = 0;
        $skorKesehatanSementara = 0;
        $skorKesehatan = 0;
        $year = now()->format('Y');
        $month = now()->format('m');

        $user = User::where([['id', $id], ['deleted_at', null]])->first();
        $scores = Score::with('parameter')->select('scores.*')
            ->from(DB::raw('(SELECT * FROM scores ORDER BY id DESC) scores'))
            ->where([['scores.user_id', $id], ['scores.deleted_at', null]])
            ->whereYear('scores.created_at', $year)
            ->whereMonth('scores.created_at', $month)
            ->groupBy('scores.parameter_id')
            ->get();
        foreach ($scores as $index => $score) {
            if ($score->parameter->category == 'kedisiplinan') {
                $skorKedisiplinanPembilang += ($score->score * $score->parameter->weight);
                $skorKedisiplinanPembagi += ($totalHari * $score->parameter->weight);
                $totalAbsent += $score->score;
            }

            if ($score->parameter->category == 'sikap') {
                $skorSikapSementara += ($score->score * $score->parameter->weight);
            }

            if ($score->parameter->category == 'kesehatan') {
                $skorKesehatanSementara += ($score->score * $score->parameter->weight);
            }
        }
        $skorKedisiplinan = (1 - ($skorKedisiplinanPembilang / $skorKedisiplinanPembagi)) * 100;
        $skorSikap = 100 - $skorSikapSementara < 0 ? 0 : 100 - $skorSikapSementara;
        $skorKesehatan = 100 - $skorKesehatanSementara < 0 ? 0 : 100 - $skorKesehatanSementara;

        $bpjstk = $request->bpjstk == null ? 0 : (($user->salary * $totalHari) * (2 / 100));
        $bpjsjp = $request->bpjsjp == null ? 0 : (($user->salary * $totalHari) * (1 / 100));
        $bpjskes = $request->bpjskes == null ? 0 : (($user->salary * $totalHari) * (1 / 100));

        $totalMasuk = $totalHari - $totalAbsent;
        if ($request->allowances != null) {
            foreach ($request->allowances as $allowanceId) {
                $amount = Allowance::where('id', $allowanceId)->first()->amount;
                $allowanceTotal += ($amount * $totalMasuk);
            }
        }

        // dd($totalAbsent);
        $get_tax = Tax::where('id', $request->tax)->first()->percentage;
        $tax = $user->salary * $totalHari * ($get_tax / 100);

        $skorTotal = (($skorKedisiplinan * 50) / 100) + (($skorSikap * 40) / 100) + (($skorKesehatan * 10) / 100);
        $salaryTotal = (($user->salary * $totalHari) * ($skorTotal / 100)) + $allowanceTotal - $bpjstk - $bpjsjp - $bpjskes - $tax;

        $insert = Report::create([
            'user_id' => $user->id,
            'tunjangan' => json_encode($request->allowances),
            'tax_id' => $request->tax,
            'bpjs_tk' => $bpjstk,
            'bpjs_jp' => $bpjsjp,
            'bpjs_kes' => $bpjskes,
            'skor_kedisiplinan' => ($skorKedisiplinan * 50) / 100,
            'skor_sikap' => ($skorSikap * 40) / 100,
            'skor_kesehatan' => ($skorKesehatan * 10) / 100,
            'deduction_total' => $bpjstk + $bpjsjp + $bpjskes + $tax,
            'salary_per_hour' => $user->salary,
            'salary_total' => $salaryTotal,
            'absent_total' => $totalAbsent,
            'date' => now()->format('Y-m-d'),
        ]);

        return redirect()->route('payroll.index')->with('succees', 'Slip gaji karyawan telah dibuat');
    }
}
