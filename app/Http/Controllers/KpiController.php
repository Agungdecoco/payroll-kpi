<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\User;
use App\Models\Parameter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KpiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->level_id == 1) {
            $users = User::where('deleted_at', null)->get();
        } elseif (auth()->user()->level_id == 2) {
            $users = User::where([['deleted_at', null], ['division_id', auth()->user()->segment->division_id]])->get();
        }
        return view('score.index', compact('users'));
    }

    public function indexScore($id)
    {
        $scores = Score::where('user_id', $id)
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
            ->groupBy('year', 'month')
            ->orderBy('year', 'DESC')
            ->orderBy('month', 'DESC')
            ->get();

        $periodes = $scores->map(function ($item) {
            return [
                'user_id' => $item->user_id,
                'year' => $item->year,
                'month' => Carbon::create()->month($item->month)->format('F'),
            ];
        });
        return view('score.score', compact('periodes', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->input('id');
        $discipline = Parameter::where('category', 'Kedisiplinan')->get();
        $attitude = Parameter::where('category', 'Sikap')->get();
        $performance = Parameter::where('category', 'Performa')->get();
        return view('score.create', compact('discipline', 'attitude', 'performance', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'discipline.*' => 'numeric|min:0|max:100',
            'attitude.*' => 'numeric|min:0|max:100',
            'performance.*' => 'numeric|min:0|max:100',
        ]);

        $userId = $request->input('user_id');
        $currentDate = Carbon::now()->format('Y-m-d');

        if ($request->has('discipline')) {
            foreach ($request->input('discipline') as $index => $score) {
                Score::create([
                    'user_id' => $userId,
                    'parameter_id' => $request->input('disciplineId.' . $index),
                    'score' => $score,
                    'date' => $currentDate,
                ]);
            }
        }
        if ($request->has('attitude')) {
            foreach ($request->input('attitude') as $index => $score) {
                Score::create([
                    'user_id' => $userId,
                    'parameter_id' => $request->input('attitudeId.' . $index),
                    'score' => $score,
                    'date' => $currentDate,
                ]);
            }
        }
        if ($request->has('performance')) {
            foreach ($request->input('performance') as $index => $score) {
                Score::create([
                    'user_id' => $userId,
                    'parameter_id' => $request->input('performanceId.' . $index),
                    'score' => $score,
                    'date' => $currentDate,
                ]);
            }
        }

        return redirect()->route('kpi.index')->with('success', 'Data KPI berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $year = $request->year;
        $month = Carbon::parse($request->month)->format('m');
        $user = User::findOrFail($id);
        $disciplineScores = Score::select('scores.*')
            ->from(DB::raw('(SELECT * FROM scores ORDER BY id DESC) scores'))
            ->where([['scores.user_id', $id], ['scores.deleted_at', null]])
            ->whereYear('scores.created_at', $year)
            ->whereMonth('scores.created_at', $month)
            ->whereHas('parameter', function ($query) {
                $query->where('category', 'Kedisiplinan');
            })
            ->groupBy('scores.parameter_id')
            ->get();

        $attitudeScores = Score::select('scores.*')
            ->from(DB::raw('(SELECT * FROM scores ORDER BY id DESC) scores'))
            ->where([['scores.user_id', $id], ['scores.deleted_at', null]])
            ->whereYear('scores.created_at', $year)
            ->whereMonth('scores.created_at', $month)
            ->whereHas('parameter', function ($query) {
                $query->where('category', 'Sikap');
            })
            ->groupBy('scores.parameter_id')
            ->get();

        $performanceScores = Score::select('scores.*')
            ->from(DB::raw('(SELECT * FROM scores ORDER BY id DESC) scores'))
            ->where([['scores.user_id', $id], ['scores.deleted_at', null]])
            ->whereYear('scores.created_at', $year)
            ->whereMonth('scores.created_at', $month)
            ->whereHas('parameter', function ($query) {
                $query->where('category', 'Performa');
            })
            ->groupBy('scores.parameter_id')
            ->get();

        return view('score.edit', compact('user', 'disciplineScores', 'attitudeScores', 'performanceScores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'discipline.*' => 'nullable|numeric|min:0|max:100',
            'attitude.*' => 'nullable|numeric|min:0|max:100',
            'performance.*' => 'nullable|numeric|min:0|max:100',
            'disciplineId.*' => 'nullable|exists:parameters,id',
            'attitudeId.*' => 'nullable|exists:parameters,id',
            'performanceId.*' => 'nullable|exists:parameters,id',
        ]);

        // Mendapatkan ID user
        $userId = $request->input('user_id');
        $currentDate = Carbon::now()->format('Y-m-d');

        // Perbarui data kedisiplinan jika ada
        if ($request->has('discipline')) {
            foreach ($request->input('discipline') as $index => $score) {
                $scoreRecord = Score::where('user_id', $userId)
                    ->where('parameter_id', $request->input('disciplineId.' . $index))
                    ->first();
                if ($scoreRecord) {
                    $scoreRecord->update([
                        'score' => $score,
                        'date' => $currentDate,
                    ]);
                }
            }
        }

        // Perbarui data sikap jika ada
        if ($request->has('attitude')) {
            foreach ($request->input('attitude') as $index => $score) {
                $scoreRecord = Score::where('user_id', $userId)
                    ->where('parameter_id', $request->input('attitudeId.' . $index))
                    ->first();
                if ($scoreRecord) {
                    $scoreRecord->update([
                        'score' => $score,
                        'date' => $currentDate,
                    ]);
                }
            }
        }

        // Perbarui data performa jika ada
        if ($request->has('performance')) {
            foreach ($request->input('performance') as $index => $score) {
                $scoreRecord = Score::where('user_id', $userId)
                    ->where('parameter_id', $request->input('performanceId.' . $index))
                    ->first();
                if ($scoreRecord) {
                    $scoreRecord->update([
                        'score' => $score,
                        'date' => $currentDate,
                    ]);
                }
            }
        }

        return redirect()->route('kpi.index')->with('success', 'Data KPI berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
