<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMacroTargetRequest;
use App\Http\Resources\MacroTargetResource;
use App\Services\MacroCalculatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MacroTargetController extends Controller
{
    public function __construct(private MacroCalculatorService $calculator) {}

    public function store(StoreMacroTargetRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $calculated = $this->calculator->calculate(
            weightKg:      $validated['weight_kg'],
            heightCm:      $validated['height_cm'],
            age:           $validated['age'],
            sex:           $validated['sex'],
            activityLevel: $validated['activity_level'],
            goal:          $validated['goal'],
            preset:        $validated['preset'] ?? null,
        );

        $macroTarget = $request->user()->macroTargets()->create(
            array_merge($validated, $calculated)
        );

        return (new MacroTargetResource($macroTarget))
            ->response()
            ->setStatusCode(201);
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $macroTargets = $request->user()
            ->macroTargets()
            ->latest()
            ->paginate(10);

        return MacroTargetResource::collection($macroTargets);
    }
}
