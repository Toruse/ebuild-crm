<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\User\SkillSpecialty;
use App\Services\SkillSpecialtyService;
use App\Http\Requests\SkillSpecialty\SkillSpecialtyCreateRequest;
use App\Http\Requests\SkillSpecialty\SkillSpecialtyUpdateRequest;

class SkillSpecialtyController extends Controller
{

    private $skillSpecialtyService;

    public function __construct(SkillSpecialtyService $skillSpecialtyService)
    {
        $this->skillSpecialtyService = $skillSpecialtyService;
    }

    public function index()
    {
        return view('setting.skill-specialty.index', [
            'skillSpecialtys' => $this->skillSpecialtyService->getSkillSpecialtysPaginate()
        ]);
    }

    public function create() {
        return view('setting.skill-specialty.create');
    }

    public function store(SkillSpecialtyCreateRequest $request)
    {
        $skillSpecialty = $this->skillSpecialtyService->createNewSkillSpecialty($request->all());
        return redirect()->route('skill-specialtys.show', $skillSpecialty);
    }

    public function show($skillSpecialtyId) {
        return view('setting.skill-specialty.show', [
            'skillSpecialty' => SkillSpecialty::findOrFail($skillSpecialtyId)
        ]);
    }

    public function edit($skillSpecialtyId) {
        return view('setting.skill-specialty.edit', [
            'skillSpecialty' => SkillSpecialty::findOrFail($skillSpecialtyId),
        ]);
    }

    public function update(SkillSpecialtyUpdateRequest $request, $skillSpecialtyId) {
        $skillSpecialty = SkillSpecialty::findOrFail($skillSpecialtyId);

        $this->skillSpecialtyService->updateSkillSpecialty($skillSpecialty, $request->all());

        return redirect()->route('skill-specialtys.show', $skillSpecialty);
    }

    public function destroy($id)
    {
        SkillSpecialty::destroy($id);
        return redirect(route('skill-specialtys.index'));
    }

    public function addQuick(SkillSpecialtyCreateRequest $request) {
        $skillSpecialty = $this->skillSpecialtyService->createNewSkillSpecialty($request->all());

        return response()->json([
            'status' => 'ok',
            'skillSpecialty' => $skillSpecialty
        ]);
    }
}