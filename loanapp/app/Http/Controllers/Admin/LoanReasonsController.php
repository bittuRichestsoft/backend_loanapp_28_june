<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLoanReasonsRequest;
use App\Http\Requests\StoreLoanReasonsRequest;
use App\Http\Requests\UpdateLoanReasonsRequest;
use App\LoanReasons;
use DB;

class LoanReasonsController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('loan_access'), 403);
        DB::enableQueryLog();

        $loanReasons = LoanReasons::all();

        $laQuery = DB::getQueryLog();

        $lcWhatYouWant = $laQuery[0]['query']; # <-------
        // dd($laQuery);
        # optionally disable the query log:
        DB::disableQueryLog();
        // dd($incomeSources);

        return view('admin.loan_reasons.index', compact('loanReasons'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.loan_reasons.create');
    }

    public function store(StoreLoanReasonsRequest $request)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $loanReason = LoanReasons::create($request->all());

        return redirect()->route('admin.loan_reason.index');
    }

    public function edit(LoanReasons $loanReason)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.loan_reasons.edit', compact('loanReason'));
    }

    public function update(UpdateLoanReasonsRequest $request, LoanReasons $loanReason)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $loanReason->update($request->all());

        return redirect()->route('admin.loan_reason.index');
    }

    public function show(LoanReasons $loanReason)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.loan_reasons.show', compact('loanReason'));
    }

    public function destroy(LoanReasons $loanReason)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $loanReason->delete();

        return back();
    }

    public function massDestroy(MassDestroyLoanReasonsRequest $request)
    {
        LoanReasons::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}