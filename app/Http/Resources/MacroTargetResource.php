<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MacroTargetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'weight_kg'      => (float) $this->weight_kg,
            'height_cm'      => (float) $this->height_cm,
            'age'            => $this->age,
            'sex'            => $this->sex,
            'activity_level' => $this->activity_level,
            'goal'           => $this->goal,
            'preset'         => $this->preset,
            'daily_calories' => $this->daily_calories,
            'protein_g'      => (float) $this->protein_g,
            'carbs_g'        => (float) $this->carbs_g,
            'fat_g'          => (float) $this->fat_g,
            'created_at'     => $this->created_at->toISOString(),
        ];
    }
}
