<?php

namespace App\Services;

class MacroCalculatorService
{
    private const ACTIVITY_MULTIPLIERS = [
        'sedentary'  => 1.2,
        'light'      => 1.375,
        'moderate'   => 1.55,
        'active'     => 1.725,
        'very_active' => 1.9,
    ];

    private const GOAL_ADJUSTMENTS = [
        'lose'     => -500,
        'maintain' => 0,
        'gain'     => 300,
    ];

    private const PRESET_SPLITS = [
        'balanced'     => ['protein' => 0.30, 'carbs' => 0.40, 'fat' => 0.30],
        'high_protein' => ['protein' => 0.40, 'carbs' => 0.30, 'fat' => 0.30],
        'keto'         => ['protein' => 0.25, 'carbs' => 0.05, 'fat' => 0.70],
        'low_carb'     => ['protein' => 0.35, 'carbs' => 0.10, 'fat' => 0.55],
    ];

    public function calculate(
        float $weightKg,
        float $heightCm,
        int $age,
        string $sex,
        string $activityLevel,
        string $goal,
        ?string $preset = null
    ): array {
        $dailyCalories = $this->tdee($weightKg, $heightCm, $age, $sex, $activityLevel)
            + self::GOAL_ADJUSTMENTS[$goal];

        [$proteinG, $carbsG, $fatG] = $preset
            ? $this->macrosFromPreset($dailyCalories, $preset)
            : $this->macrosFromDefault($weightKg, $dailyCalories);

        return [
            'daily_calories' => (int) round($dailyCalories),
            'protein_g'      => (int) round($proteinG),
            'carbs_g'        => (int) round($carbsG),
            'fat_g'          => (int) round($fatG),
        ];
    }

    private function bmr(float $weightKg, float $heightCm, int $age, string $sex): float
    {
        // Mifflin-St Jeor equation
        $base = (10 * $weightKg) + (6.25 * $heightCm) - (5 * $age);

        return $sex === 'male' ? $base + 5 : $base - 161;
    }

    private function tdee(float $weightKg, float $heightCm, int $age, string $sex, string $activityLevel): float
    {
        return $this->bmr($weightKg, $heightCm, $age, $sex)
            * self::ACTIVITY_MULTIPLIERS[$activityLevel];
    }

    private function macrosFromDefault(float $weightKg, float $dailyCalories): array
    {
        // Protein: 2g per kg bodyweight
        $proteinG = $weightKg * 2;
        // Fat: 25% of calories
        $fatG = ($dailyCalories * 0.25) / 9;
        // Carbs: remaining calories
        $carbsG = ($dailyCalories - ($proteinG * 4) - ($fatG * 9)) / 4;

        return [$proteinG, $carbsG, $fatG];
    }

    private function macrosFromPreset(float $dailyCalories, string $preset): array
    {
        $split = self::PRESET_SPLITS[$preset];

        $proteinG = ($dailyCalories * $split['protein']) / 4;
        $carbsG   = ($dailyCalories * $split['carbs']) / 4;
        $fatG     = ($dailyCalories * $split['fat']) / 9;

        return [$proteinG, $carbsG, $fatG];
    }
}
