<?php

namespace App\Http\Controllers\Setting;

use App\Models\Billing\Priced;
use App\Services\PricedService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Priced\PricedCreateRequest;
use App\Http\Requests\Priced\PricedUpdateRequest;

class PricedController extends Controller
{

    private $pricedService;

    public function __construct(PricedService $pricedService)
    {
        $this->pricedService = $pricedService;
    }

    public function index()
    {
        return view('setting.priced.index', [
            'priceds' => $this->pricedService->getPricedsPaginate()
        ]);
    }

    public function create() {
        return view('setting.priced.create', [
            'listPeriodType' => Priced::getListPeriodType(),
            'listType' => Priced::getListType(),
        ]);
    }

    public function store(PricedCreateRequest $request)
    {
        $priced = $this->pricedService->createPriced($request->all());
        return redirect()->route('priceds.show', $priced);
    }

    public function show($pricedId) {
        return view('setting.priced.show', [
            'priced' => Priced::findOrFail($pricedId),
            'listPeriodType' => Priced::getListPeriodType(),
            'listType' => Priced::getListType(),
        ]);
    }

    public function edit($pricedId) {
        return view('setting.priced.edit', [
            'priced' => Priced::findOrFail($pricedId),
            'listPeriodType' => Priced::getListPeriodType(),
            'listType' => Priced::getListType(),
        ]);
    }

    public function update(PricedUpdateRequest $request, $pricedId) {
        $priced = Priced::findOrFail($pricedId);

        $this->pricedService->updatePriced($priced, $request->all());

        return redirect()->route('priceds.show', $priced);
    }

    public function destroy($id)
    {
        Priced::destroy($id);
        return redirect(route('priceds.index'));
    }

    public function accessClosed() {
        return view('billing.priced.access-closed');
    }
}