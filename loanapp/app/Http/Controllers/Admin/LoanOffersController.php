<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLoanOffersRequest;
use App\Http\Requests\StoreLoanOffersRequest;
use App\Http\Requests\UpdateLoanOffersRequest;
use App\LoanOffers;
use DB;

class LoanOffersController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('loan_access'), 403);
        DB::enableQueryLog();

        $loanOffers = LoanOffers::all();

        $laQuery = DB::getQueryLog();

        $lcWhatYouWant = $laQuery[0]['query']; # <-------
        // dd($laQuery);
        # optionally disable the query log:
        DB::disableQueryLog();
        // dd($incomeSources);

        return view('admin.loan_offers.index', compact('loanOffers'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.loan_offers.create');
    }

    public function store(StoreLoanOffersRequest $request)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $loanOffer = LoanOffers::create($request->all());

        return redirect()->route('admin.loan_offers.index');
    }

    public function edit(LoanOffers $loanOffer)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.loan_offers.edit', compact('loanOffer'));
    }

    public function update(UpdateLoanOffersRequest $request, LoanOffers $loanOffer)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $loanOffer->update($request->all());

        return redirect()->route('admin.loan_offers.index');
    }

    public function show(LoanOffers $loanOffer)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.loan_offers.show', compact('loanOffer'));
    }

    public function destroy(LoanOffers $loanOffer)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $loanOffer->delete();

        return back();
    }

    public function massDestroy(MassDestroyLoanOffersRequest $request)
    {
        LoanOffers::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}