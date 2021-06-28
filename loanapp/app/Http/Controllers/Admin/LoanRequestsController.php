<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRequestLoanRequest;
use App\Http\Requests\StoreRequestLoanRequest;
use App\Http\Requests\UpdateRequestLoanRequest;
use App\RequestLoan;
use DB;

class LoanRequestsController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('loan_access'), 403);
        DB::enableQueryLog();

        $requestLoans = RequestLoan::all();

        $laQuery = DB::getQueryLog();

        $lcWhatYouWant = $laQuery[0]['query']; # <-------
        // dd($laQuery);
        # optionally disable the query log:
        DB::disableQueryLog();
        // dd($incomeSources);

        return view('admin.request_loan.index', compact('requestLoans'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.request_loan.create');
    }

    public function store(StoreRequestLoanRequest $request)
    {
        abort_unless(\Gate::allows('loan_access'), 403);
        $requestLoan = RequestLoan::create($request->all());

        return redirect()->route('admin.loan_requests.index');
    }

    public function edit(RequestLoan $requestLoan)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.request_loan.edit', compact('requestLoan'));
    }

    public function update(UpdateRequestLoanRequest $request, RequestLoan $requestLoan)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $requestLoan->update($request->all());

        return redirect()->route('admin.loan_requests.index');
    }

    public function show(RequestLoan $requestLoan)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.request_loan.show', compact('requestLoan'));
    }

    public function destroy(RequestLoan $requestLoan)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $requestLoan->delete();

        return back();
    }

    public function massDestroy(MassDestroyRequestLoanRequest $request)
    {
        RequestLoan::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}