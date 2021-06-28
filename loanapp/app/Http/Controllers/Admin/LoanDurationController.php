<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLoanDurationRequest;
use App\Http\Requests\StoreLoanDurationRequest;
use App\Http\Requests\UpdateLoanDurationRequest;
use App\LoanDuration;
use DB;

class LoanDurationController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('loan_access'), 403);
        DB::enableQueryLog();

        $loanDurations = LoanDuration::all();

        $laQuery = DB::getQueryLog();

        $lcWhatYouWant = $laQuery[0]['query']; # <-------
        // dd($laQuery);
        # optionally disable the query log:
        DB::disableQueryLog();
        // dd($incomeSources);

        return view('admin.loan_duration.index', compact('loanDurations'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.loan_duration.create');
    }

    public function store(StoreLoanDurationRequest $request)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $loanDuration = LoanDuration::create($request->all());

        return redirect()->route('admin.loan_duration.index');
    }

    public function edit(LoanDuration $loanDuration)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.loan_duration.edit', compact('loanDuration'));
    }

    public function update(UpdateLoanDurationRequest $request, LoanDuration $loanDuration)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $loanDuration->update($request->all());

        return redirect()->route('admin.loan_duration.index');
    }

    public function show(LoanDuration $loanDuration)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.loan_duration.show', compact('loanDuration'));
    }

    public function destroy(LoanDuration $loanDuration)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $loanDuration->delete();

        return back();
    }

    public function massDestroy(MassDestroyLoanDurationRequest $request)
    {
        LoanDuration::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}