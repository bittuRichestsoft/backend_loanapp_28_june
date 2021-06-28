<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIncomeSourcesRequest;
use App\Http\Requests\StoreIncomeSourcesRequest;
use App\Http\Requests\UpdateIncomeSourcesRequest;
use App\IncomeSources;
use DB;

class IncomeSourcesController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('loan_access'), 403);
        DB::enableQueryLog();

        $incomeSources = IncomeSources::all();

        $laQuery = DB::getQueryLog();

        $lcWhatYouWant = $laQuery[0]['query']; # <-------
        // dd($laQuery);
        # optionally disable the query log:
        DB::disableQueryLog();
        // dd($incomeSources);

        return view('admin.income_sources.index', compact('incomeSources'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.income_sources.create');
    }

    public function store(StoreIncomeSourcesRequest $request)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $incomeSource = IncomeSources::create($request->all());

        return redirect()->route('admin.income_sources.index');
    }

    public function edit(IncomeSources $incomeSource)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.income_sources.edit', compact('incomeSource'));
    }

    public function update(UpdateIncomeSourcesRequest $request, IncomeSources $incomeSource)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $incomeSource->update($request->all());

        return redirect()->route('admin.income_sources.index');
    }

    public function show(IncomeSources $incomeSource)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        return view('admin.income_sources.show', compact('incomeSource'));
    }

    public function destroy(IncomeSources $incomeSource)
    {
        abort_unless(\Gate::allows('loan_access'), 403);

        $incomeSource->delete();

        return back();
    }

    public function massDestroy(MassDestroyIncomeSourcesRequest $request)
    {
        IncomeSources::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}