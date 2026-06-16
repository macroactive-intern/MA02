<?php

use App\Models\MacroTarget;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

$validPayload = [
    'weight_kg'      => 80,
    'height_cm'      => 180,
    'age'            => 25,
    'sex'            => 'male',
    'activity_level' => 'moderate',
    'goal'           => 'maintain',
    'preset'         => 'balanced',
];

// ── Store ─────────────────────────────────────────────────────────────────────

it('returns 201 and correct calculated values', function () use ($validPayload) {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson('/api/macro-targets', $validPayload)
        ->assertStatus(201)
        ->assertJsonFragment([
            'daily_calories' => 2798,
            'protein_g'      => 210,
            'carbs_g'        => 280,
            'fat_g'          => 93,
        ]);
});

it('saves the record to the database', function () use ($validPayload) {
    $user = User::factory()->create();

    actingAs($user)->postJson('/api/macro-targets', $validPayload);

    $this->assertDatabaseHas('macro_targets', [
        'user_id'        => $user->id,
        'weight_kg'      => 80,
        'daily_calories' => 2798,
    ]);
});

it('ignores client-supplied calculated fields', function () use ($validPayload) {
    $user = User::factory()->create();

    $payload = array_merge($validPayload, [
        'daily_calories' => 9999,
        'protein_g'      => 9999,
        'carbs_g'        => 9999,
        'fat_g'          => 9999,
    ]);

    actingAs($user)
        ->postJson('/api/macro-targets', $payload)
        ->assertJsonFragment(['daily_calories' => 2798]);
});

it('returns macro grams as integers', function () use ($validPayload) {
    $user = User::factory()->create();

    $response = actingAs($user)
        ->postJson('/api/macro-targets', $validPayload)
        ->assertStatus(201);

    $data = $response->json('data');

    expect($data['daily_calories'])->toBeInt();
    expect($data['protein_g'])->toBeInt();
    expect($data['carbs_g'])->toBeInt();
    expect($data['fat_g'])->toBeInt();
});

// ── Index ─────────────────────────────────────────────────────────────────────

it('returns only the authenticated users records', function () use ($validPayload) {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    actingAs($userA)->postJson('/api/macro-targets', $validPayload);
    actingAs($userB)->postJson('/api/macro-targets', $validPayload);

    $response = actingAs($userA)->getJson('/api/macro-targets');

    $response->assertStatus(200);
    expect($response->json('data'))->toHaveCount(1);
});

it('paginates at 10 per page', function () use ($validPayload) {
    $user = User::factory()->create();

    for ($i = 0; $i < 12; $i++) {
        actingAs($user)->postJson('/api/macro-targets', $validPayload);
    }

    $response = actingAs($user)->getJson('/api/macro-targets');

    $response->assertStatus(200);
    expect($response->json('data'))->toHaveCount(10);
    expect($response->json('meta.per_page'))->toBe(10);
});

it('returns records newest first', function () use ($validPayload) {
    $user = User::factory()->create();

    actingAs($user)->postJson('/api/macro-targets', $validPayload);

    $second = MacroTarget::factory()->create([
        'user_id'    => $user->id,
        'weight_kg'  => 90,
        'created_at' => now()->addMinute(),
    ]);

    $response = actingAs($user)->getJson('/api/macro-targets');

    expect($response->json('data.0.id'))->toBe($second->id);
});

// ── Unauthenticated ───────────────────────────────────────────────────────────

it('returns 401 for unauthenticated POST', function () use ($validPayload) {
    postJson('/api/macro-targets', $validPayload)->assertStatus(401);
});

it('returns 401 for unauthenticated GET', function () {
    getJson('/api/macro-targets')->assertStatus(401);
});

// ── Validation ────────────────────────────────────────────────────────────────

it('returns 422 when required fields are missing', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson('/api/macro-targets', [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['weight_kg', 'height_cm', 'age', 'sex', 'activity_level', 'goal']);
});

it('rejects invalid sex value', function () use ($validPayload) {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson('/api/macro-targets', array_merge($validPayload, ['sex' => 'other']))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['sex']);
});

it('rejects invalid activity level', function () use ($validPayload) {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson('/api/macro-targets', array_merge($validPayload, ['activity_level' => 'extreme']))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['activity_level']);
});

it('rejects invalid goal', function () use ($validPayload) {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson('/api/macro-targets', array_merge($validPayload, ['goal' => 'bulk']))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['goal']);
});

it('rejects invalid preset', function () use ($validPayload) {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson('/api/macro-targets', array_merge($validPayload, ['preset' => 'carnivore']))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['preset']);
});

it('rejects weight out of range', function () use ($validPayload) {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson('/api/macro-targets', array_merge($validPayload, ['weight_kg' => 10]))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['weight_kg']);

    actingAs($user)
        ->postJson('/api/macro-targets', array_merge($validPayload, ['weight_kg' => 400]))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['weight_kg']);
});

it('rejects height out of range', function () use ($validPayload) {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson('/api/macro-targets', array_merge($validPayload, ['height_cm' => 50]))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['height_cm']);

    actingAs($user)
        ->postJson('/api/macro-targets', array_merge($validPayload, ['height_cm' => 300]))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['height_cm']);
});

it('rejects age out of range', function () use ($validPayload) {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson('/api/macro-targets', array_merge($validPayload, ['age' => 10]))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['age']);

    actingAs($user)
        ->postJson('/api/macro-targets', array_merge($validPayload, ['age' => 150]))
        ->assertStatus(422)
        ->assertJsonValidationErrors(['age']);
});
