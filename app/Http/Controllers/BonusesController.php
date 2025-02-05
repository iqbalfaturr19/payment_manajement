<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Bonus;
use App\BonusDetail;
use App\Employee;
use Carbon\Carbon;

class BonusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bonuses = Bonus::get();
        $title = "Bonus Page";
        return view('bonus.index')->with([
            'bonuses' => $bonuses,
            'title' => $title
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::get();
        $title = "Bonus Page";
        return view('bonus.create')->with([
            'employees' => $employees,
            'title' => $title
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $totalPercentage = array_sum($data['percentage']);

        if ($totalPercentage > 100) {
            return back()->with('error','Total persentase tidak boleh lebih dari 100%');
        }

        $bonus = new Bonus();
        $bonus->total_bonus = $data['total_bonus'];
        $bonus->created_at = Carbon::now();
        $bonus->updated_at = Carbon::now();
        $bonus->save();
        foreach ($data['employee_id'] as $index => $employeeId) {
            DB::table('bonus_details')->insert([
                'bonuses_id' => $bonus->id,
                'employee_id' => $employeeId,
                'persentase' => $data['percentage'][$index],
                'nominal' => ($data['total_bonus'] * $data['percentage'][$index]) / 100,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    
        return back()->with('success', 'Data bonus berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employees = Employee::get();
        $bonus = Bonus::find($id);
        $bonus_details = BonusDetail::where('bonuses_id',$id)->get();
        $title = "Bonus Page";
        return view('bonus.detail')->with([
            'employees' => $employees,
            'bonus' => $bonus,
            'bonus_details' => $bonus_details,
            'title' => $title
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employees = Employee::get();
        $bonus = Bonus::find($id);
        $bonus_details = BonusDetail::where('bonuses_id',$id)->get();
        $title = "Bonus Page";
        return view('bonus.edit')->with([
            'employees' => $employees,
            'bonus' => $bonus,
            'bonus_details' => $bonus_details,
            'title' => $title
        ]);
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
        $data = $request->all();

        $totalPercentage = array_sum($data['percentage']);

        if ($totalPercentage > 100) {
            return back()->with('error','Total persentase tidak boleh lebih dari 100%');
        }

        $bonus = Bonus::find($id);
        $bonus->total_bonus = $data['total_bonus'];
        $bonus->created_at = Carbon::now();
        $bonus->updated_at = Carbon::now();
        $bonus->save();

        foreach ($data['employee_id'] as $index => $employeeId) {
            $bonusDetail = BonusDetail::where('bonuses_id', $id)->where('employee_id', $employeeId)->first();

            if ($bonusDetail) {
                // Update existing record
                $bonusDetail->persentase = $data['percentage'][$index];
                $bonusDetail->nominal = ($data['total_bonus'] * $data['percentage'][$index]) / 100;
                $bonusDetail->updated_at = Carbon::now();
                $bonusDetail->save();
            } else {
                // Create new record if not exists
                DB::table('bonus_details')->insert([
                    'bonuses_id' => $bonus->id,
                    'employee_id' => $employeeId,
                    'persentase' => $data['percentage'][$index],
                    'nominal' => ($data['total_bonus'] * $data['percentage'][$index]) / 100,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    
        return back()->with('success', 'Data bonus berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bonuses = Bonus::find($id);
        if (!$bonuses) {
            return redirect()->route('bonuses.index')->with('error', 'Data tidak ditemukan.');
        }
        $bonusDetail = BonusDetail::where('bonuses_id', $id)->delete();
        $bonuses->delete();

        return redirect()->route('bonuses.index')->with('success', 'Data berhasil dihapus.');
    }
}
