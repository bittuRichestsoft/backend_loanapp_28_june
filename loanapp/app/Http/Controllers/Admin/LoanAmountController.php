<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLoanAmountRequest;
use App\Http\Requests\StoreLoanAmountRequest;
use App\Http\Requests\UpdateLoanAmountRequest;
use App\LoanAmount;
use DB;

class LoanAmountController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('loan_access'), 403);
        DB::enableQueryLog();

        $loanAmounts = LoanAmount::all();

        $laQuery = DB::getQueryLog();

        $lcWhatYouWant = $laQuery[0]['query']; # <-------
        // dd($laQuery);
        # optionally disable the query log:
        DB::disableQueryLog();
        // dd($incomeSources);

        return view('admin.loan_amount.index', compact('loanAmounts'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.loan_amount.create');
    }

    public function store(StoreLoanAmountRequest $request)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $loanAmount = LoanAmount::create($request->all());

        return redirect()->route('admin.loan_amount.index');
    }

    public function edit(LoanAmount $loanAmount)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.loan_amount.edit', compact('loanAmount'));
    }

    public function update(UpdateLoanAmountRequest $request, LoanAmount $loanAmount)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $loanAmount->update($request->all());

        return redirect()->route('admin.loan_amount.index');
    }

    public function show(LoanAmount $loanAmount)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.loan_amount.show', compact('loanAmount'));
    }

    public function destroy(LoanAmount $loanAmount)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $loanAmount->delete();

        return back();
    }

    public function massDestroy(MassDestroyLoanAmountRequest $request)
    {
        LoanAmount::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}