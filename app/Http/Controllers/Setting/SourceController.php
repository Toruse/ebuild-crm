<?php

namespace App\Http\Controllers\Setting;

use App\Models\User\Source;
use App\Services\SourceService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Source\SourceCreateRequest;
use App\Http\Requests\Source\SourceUpdateRequest;

class SourceController extends Controller
{

    private $sourceService;

    public function __construct(SourceService $sourceService)
    {
        $this->sourceService = $sourceService;
    }

    public function index()
    {
        return view('setting.source.index', [
            'sources' => $this->sourceService->getSourcesPaginate()
        ]);
    }

    public function create() {
        return view('setting.source.create');
    }

    public function store(SourceCreateRequest $request)
    {
        $source = $this->sourceService->createNewSource($request->all());
        return redirect()->route('sources.show', $source);
    }

    public function show($sourceId) {
        return view('setting.source.show', [
            'source' => Source::findOrFail($sourceId)
        ]);
    }

    public function edit($sourceId) {
        return view('setting.source.edit', [
            'source' => Source::findOrFail($sourceId),
        ]);
    }

    public function update(SourceUpdateRequest $request, $sourceId) {
        $source = Source::findOrFail($sourceId);

        $this->sourceService->updateSource($source, $request->all());

        return redirect()->route('sources.show', $source);
    }

    public function destroy($id)
    {
        Source::destroy($id);
        return redirect(route('sources.index'));
    }

    public function addQuick(SourceCreateRequest $request) {
        $source = $this->sourceService->createNewSource($request->all());

        return response()->json([
            'status' => 'ok',
            'source' => $source
        ]);
    }
}