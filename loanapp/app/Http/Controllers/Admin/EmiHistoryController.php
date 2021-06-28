<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEmiHistoryRequest;
use App\Http\Requests\StoreEmiHistoryRequest;
use App\Http\Requests\UpdateEmiHistoryRequest;
use App\EmiHistory;
use App\User;
use App\PostLoan;
use DB;

class EmiHistoryController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('loan_access'), 403);
        DB::enableQueryLog();

        $emiHistory = EmiHistory::join('users','users.id','=','emi_history.user_id')->select('emi_history.*','users.name','users.first_name','users.last_name')->get();
       
        $laQuery = DB::getQueryLog();

        $lcWhatYouWant = $laQuery[0]['query']; # <-------
        // dd($laQuery);
        # optionally disable the query log:
        DB::disableQueryLog();
        // dd($incomeSources);

        return view('admin.emi_history.index', compact('emiHistory'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $users = User::all();
        $loan_id = PostLoan::all();
        // dd($users);

        return view('admin.emi_history.create',compact('users','loan_id'));
    }

    public function store(StoreEmiHistoryRequest $request)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $emiHistory = EmiHistory::create($request->all());

        return redirect()->route('admin.emi_history.index');
    }

    public function edit(EmiHistory $emiHistory)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $users = User::all();
        $loan_id = PostLoan::all();

        return view('admin.emi_history.edit', compact('users','loan_id','emiHistory'));
    }

    public function update(UpdateEmiHistoryRequest $request, EmiHistory $emiHistory)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $emiHistory->update($request->all());

        return redirect()->route('admin.emi_history.index');
    }

    public function show(EmiHistory $emiHistory)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.emi_history.show', compact('emiHistory'));
    }

    public function destroy(EmiHistory $emiHistory)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $emiHistory->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmiHistoryRequest $request)
    {
        EmiHistory::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}