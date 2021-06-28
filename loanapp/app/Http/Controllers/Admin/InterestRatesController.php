<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyInterestRatesRequest;
use App\Http\Requests\StoreInterestRatesRequest;
use App\Http\Requests\UpdateInterestRatesRequest;
use App\InterestRates;
use DB;

class InterestRatesController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('loan_access'), 403);
        DB::enableQueryLog();

        $interestRates = InterestRates::all();

        $laQuery = DB::getQueryLog();

        $lcWhatYouWant = $laQuery[0]['query']; # <-------
        // dd($laQuery);
        # optionally disable the query log:
        DB::disableQueryLog();
        // dd($incomeSources);

        return view('admin.interest_rates.index', compact('interestRates'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.interest_rates.create');
    }

    public function store(StoreInterestRatesRequest $request)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $interestRate = InterestRates::create($request->all());

        return redirect()->route('admin.interest_rates.index');
    }

    public function edit(InterestRates $interestRate)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.interest_rates.edit', compact('interestRate'));
    }

    public function update(UpdateInterestRatesRequest $request, InterestRates $interestRate)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $interestRate->update($request->all());

        return redirect()->route('admin.interest_rates.index');
    }

    public function show(InterestRates $interestRate)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.interest_rates.show', compact('interestRate'));
    }

    public function destroy(InterestRates $interestRate)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $interestRate->delete();

        return back();
    }

    public function massDestroy(MassDestroyInterestRatesRequest $request)
    {
        InterestRates::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}