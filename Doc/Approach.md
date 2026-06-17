# APPROACH.md — MA02 Macro Target Calculator

## Goal

Build a Laravel JSON API that lets authenticated users calculate and save daily macro targets, then retrieve their own calculation history.

The API will:

1. Accept body profile inputs.
2. Calculate BMR, TDEE (Total Daily Energy Expenditure), daily calories, and macro grams server-side.
3. Save the calculated result to the database.
4. Return the authenticated user's calculation history.
5. Prevent users from seeing other users' records.

The calculation must use the **Mifflin-St Jeor equation**.

---

## Project setup

The project will be created from a fresh Laravel app:

```bash
composer create-project laravel/laravel macro-calculator
cd macro-calculator
php artisan install:api
```

I will configure SQLite for local development and testing.

Expected setup work:

* create the Laravel project
* configure `.env` for SQLite
* create `database/database.sqlite`
* run migrations
* confirm API routes exist
* confirm Sanctum authentication works
* install/configure Pest if needed for the test suite

---

## Libraries and packages

### Laravel

Laravel will be used for the API, routing, validation, migrations, models, resources, and testing.

### Laravel Sanctum

Sanctum will be used because both endpoints require authenticated users.

Both routes will be protected by:

```php
auth:sanctum
```

### Pest

Pest will be used for feature tests.

The tests need to prove:

* authenticated POST works
* unauthenticated POST fails with 401
* authenticated GET works
* unauthenticated GET fails with 401
* users only see their own macro target records
* validation failures return 422
* calculation output is correct for a known input
* client-provided override fields are ignored

---

## Data model

I will create a `macro_targets` table.

### Table: `macro_targets`

| Column           | Type                   | Notes                                     |
| ---------------- | ---------------------- | ----------------------------------------- |
| `id`             | `bigIncrements`        | Primary key                               |
| `user_id`        | `foreignId`            | References `users.id`, cascades on delete |
| `weight_kg`      | `decimal(5,2)`         | Input weight                              |
| `height_cm`      | `decimal(5,2)`         | Input height                              |
| `age`            | `unsignedTinyInteger`  | Input age                                 |
| `sex`            | `string(6)`            | `male` or `female`                        |
| `activity_level` | `string(20)`           | Activity preset                           |
| `goal`           | `string(10)`           | `lose`, `maintain`, or `gain`             |
| `preset`         | `string(20)`           | Macro split preset                        |
| `daily_calories` | `unsignedSmallInteger` | Calculated server-side                    |
| `protein_g`      | `unsignedSmallInteger` | Calculated server-side                    |
| `carbs_g`        | `unsignedSmallInteger` | Calculated server-side                    |
| `fat_g`          | `unsignedSmallInteger` | Calculated server-side                    |
| `created_at`     | `timestamp`            | Laravel timestamp                         |
| `updated_at`     | `timestamp`            | Laravel timestamp                         |

### Constraints

The `user_id` column will use a foreign key:

```php
$table->foreignId('user_id')->constrained()->cascadeOnDelete();
```

This means if a user is deleted, their saved macro target records are also deleted.

---

## Model structure

### `MacroTarget` model

The model will include fillable fields for the saved inputs and calculated outputs.

Expected fillable fields:

```php
[
    'user_id',
    'weight_kg',
    'height_cm',
    'age',
    'sex',
    'activity_level',
    'goal',
    'preset',
    'daily_calories',
    'protein_g',
    'carbs_g',
    'fat_g',
]
```

The model will belong to a user:

```php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

### `User` model

The `User` model will have a relationship to macro targets:

```php
public function macroTargets(): HasMany
{
    return $this->hasMany(MacroTarget::class);
}
```

The controller should save through this relationship so ownership is always attached to the authenticated user.

---

## Endpoints and routes

There will be two API routes.

| Method | URI                  | Purpose                                                           |
| ------ | -------------------- | ----------------------------------------------------------------- |
| `POST` | `/api/macro-targets` | Calculate macro targets, save the result, return the saved record |
| `GET`  | `/api/macro-targets` | Return the authenticated user's calculation history               |

Routes will be protected with Sanctum:

```php
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/macro-targets', [MacroTargetController::class, 'store']);
    Route::get('/macro-targets', [MacroTargetController::class, 'index']);
});
```

---

## POST `/api/macro-targets`

### Purpose

Calculate and save a new macro target record for the authenticated user.

### Request body

```json
{
  "weight_kg": 80,
  "height_cm": 180,
  "age": 25,
  "sex": "male",
  "activity_level": "moderate",
  "goal": "maintain",
  "preset": "standard"
}
```

### Validation

Validation will live in a FormRequest:

```text
StoreMacroTargetRequest
```

Rules:

| Field            | Rule                                                                   |
| ---------------- | ---------------------------------------------------------------------- |
| `weight_kg`      | required, numeric, min 30, max 300                                     |
| `height_cm`      | required, numeric, min 100, max 250                                    |
| `age`            | required, integer, min 15, max 100                                     |
| `sex`            | required, in `male`, `female`                                          |
| `activity_level` | required, in `sedentary`, `light`, `moderate`, `active`, `very_active` |
| `goal`           | required, in `lose`, `maintain`, `gain`                                |
| `preset`         | required, in `standard`, `high_protein`, `keto`                        |

The API will only use `$request->validated()`.

This prevents client-provided calculated fields from being trusted.

### Response

On success, return `201 Created`.

Example:

```json
{
  "data": {
    "id": 1,
    "weight_kg": 80,
    "height_cm": 180,
    "age": 25,
    "sex": "male",
    "activity_level": "moderate",
    "goal": "maintain",
    "preset": "standard",
    "daily_calories": 2798,
    "protein_g": 210,
    "carbs_g": 280,
    "fat_g": 93,
    "created_at": "2026-06-15T14:00:00.000000Z"
  }
}
```

---

## GET `/api/macro-targets`

### Purpose

Return the authenticated user's own calculation history.

### Query behavior

The query will:

* use the authenticated user's relationship
* only return that user's records
* order newest first
* paginate 10 per page

Example query logic:

```php
$request->user()
    ->macroTargets()
    ->latest()
    ->paginate(10);
```

### Response

The response will be a resource collection with Laravel pagination metadata:

```json
{
  "data": [
    {
      "id": 1,
      "weight_kg": 80,
      "height_cm": 180,
      "age": 25,
      "sex": "male",
      "activity_level": "moderate",
      "goal": "maintain",
      "preset": "standard",
      "daily_calories": 2798,
      "protein_g": 210,
      "carbs_g": 280,
      "fat_g": 93,
      "created_at": "2026-06-15T14:00:00.000000Z"
    }
  ],
  "links": {
    "first": "...",
    "last": "...",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "per_page": 10,
    "total": 1
  }
}
```

---

## Calculation service design

The calculation logic will live in a dedicated service class, not the controller.

Expected class:

```text
app/Services/MacroTargetCalculator.php
```

The controller should only handle:

* authentication
* validation
* calling the service
* saving the result
* returning resources

The service should handle:

* BMR calculation
* activity multiplier lookup
* TDEE calculation
* goal adjustment
* macro preset lookup
* macro gram calculation
* rounding

This keeps the controller thin and makes the calculation easier to test.

---

## Formula choice

The API will use the **Mifflin-St Jeor equation**.

### Male BMR

```text
BMR = (10 × weight_kg) + (6.25 × height_cm) − (5 × age) + 5
```

### Female BMR

```text
BMR = (10 × weight_kg) + (6.25 × height_cm) − (5 × age) − 161
```

---

## Activity multipliers

The service will use this lookup table:

| Activity level | Multiplier |
| -------------- | ---------: |
| `sedentary`    |        1.2 |
| `light`        |        1.4 |
| `moderate`     |       1.55 |
| `active`       |      1.725 |
| `very_active`  |        1.9 |

Calculation:

```text
TDEE = BMR × activity multiplier
```

---

## Goal adjustments

The service will use this lookup table:

| Goal       | Adjustment |
| ---------- | ---------: |
| `lose`     |  -500 kcal |
| `maintain` |     0 kcal |
| `gain`     |  +300 kcal |

Calculation:

```text
adjusted calories = TDEE + goal adjustment
```

---

## Macro preset handling

The service will use this lookup table:

| Preset         | Protein | Carbs | Fat |
| -------------- | ------: | ----: | --: |
| `standard`     |     30% |   40% | 30% |
| `high_protein` |     40% |   30% | 30% |
| `keto`         |     25% |    5% | 70% |

The preset percentages will be stored as decimals in the service:

```php
'standard' => [
    'protein' => 0.30,
    'carbs' => 0.40,
    'fat' => 0.30,
],
```

---

## Correct macro calories per gram

The old spreadsheet used:

| Macro         | Old spreadsheet kcal/g |
| ------------- | ---------------------: |
| Protein       |                      4 |
| Carbohydrates |                      4 |
| Fat           |                      4 |

This project needs the accurate version.

I will use:

| Macro         | Correct kcal/g |
| ------------- | -------------: |
| Protein       |              4 |
| Carbohydrates |              4 |
| Fat           |              9 |

This means fat grams are calculated with `9 kcal/g`, not `4 kcal/g`.

---

## Rounding decision

The brief says macro gram values must be returned as integers, but leaves the rounding method up to me.

I will use this rounding approach:

1. Calculate BMR as a decimal.
2. Calculate TDEE as a decimal.
3. Apply the goal adjustment.
4. Round daily calories to the nearest integer.
5. Use the rounded daily calorie value to calculate macro calories.
6. Convert macro calories to grams.
7. Round macro grams to the nearest integer.

This matches the provided example:

```text
daily_calories = 2798
protein_g = 210
carbs_g = 280
fat_g = 93
```

---

## Worked calculation example

Input:

```json
{
  "weight_kg": 80,
  "height_cm": 180,
  "age": 25,
  "sex": "male",
  "activity_level": "moderate",
  "goal": "maintain",
  "preset": "standard"
}
```

### Step 1 — BMR

```text
BMR = (10 × 80) + (6.25 × 180) − (5 × 25) + 5
BMR = 800 + 1125 − 125 + 5
BMR = 1805
```

### Step 2 — TDEE

Moderate activity multiplier:

```text
1.55
```

```text
TDEE = 1805 × 1.55
TDEE = 2797.75
```

### Step 3 — Goal adjustment

Maintain goal adjustment:

```text
0 kcal
```

```text
adjusted calories = 2797.75 + 0
adjusted calories = 2797.75
```

Rounded daily calories:

```text
2798
```

### Step 4 — Macro split

Standard preset:

```text
Protein = 30%
Carbs = 40%
Fat = 30%
```

Protein calories:

```text
2798 × 0.30 = 839.4
```

Carb calories:

```text
2798 × 0.40 = 1119.2
```

Fat calories:

```text
2798 × 0.30 = 839.4
```

### Step 5 — Convert to grams

Protein:

```text
839.4 ÷ 4 = 209.85
rounded = 210g
```

Carbs:

```text
1119.2 ÷ 4 = 279.8
rounded = 280g
```

Fat:

```text
839.4 ÷ 9 = 93.266...
rounded = 93g
```

Final calculated result:

```json
{
  "daily_calories": 2798,
  "protein_g": 210,
  "carbs_g": 280,
  "fat_g": 93
}
```

---

## API Resource formatting

I will create:

```text
MacroTargetResource
```

The resource will return:

* `id`
* `weight_kg`
* `height_cm`
* `age`
* `sex`
* `activity_level`
* `goal`
* `preset`
* `daily_calories`
* `protein_g`
* `carbs_g`
* `fat_g`
* `created_at`

The database stores `weight_kg` and `height_cm` as decimals, but the example response shows numbers, not decimal strings.

Decision:

* return `weight_kg` and `height_cm` as normalized numeric values
* return calculated calorie and macro fields as integers

This avoids responses like:

```json
"weight_kg": "80.00"
```

when the expected style is closer to:

```json
"weight_kg": 80
```

---

## Server-side calculation and ignored override fields

The API must not accept calorie or macro overrides from the client.

If the client sends:

```json
{
  "daily_calories": 9999,
  "protein_g": 9999,
  "carbs_g": 9999,
  "fat_g": 9999
}
```

alongside the valid body profile fields, those values will be ignored.

The controller will only use:

```php
$request->validated()
```

Then it will pass the validated body profile fields to the calculation service.

The calculated fields saved to the database will always come from the service, not from the request body.

---

## User ownership

The brief mentions coaches and clients, but the database only includes `user_id`.

There is no `client_id`, `coach_id`, or client table in scope.

Decision:

* each authenticated user owns their own macro target records
* `GET /api/macro-targets` only returns records for the current authenticated user
* `POST /api/macro-targets` saves records against the current authenticated user

This will be enforced by saving and querying through the authenticated user's relationship.

---

## Edge cases and handling

### 1. Unauthenticated requests

Both endpoints require authentication.

Expected behavior:

| Request                         | Result |
| ------------------------------- | ------ |
| Guest `POST /api/macro-targets` | 401    |
| Guest `GET /api/macro-targets`  | 401    |

This will be handled by `auth:sanctum`.

---

### 2. Invalid or missing input

Invalid or missing fields should return `422`.

Examples:

* missing `weight_kg`
* invalid `sex`
* invalid `activity_level`
* invalid `goal`
* invalid `preset`
* weight below 30
* weight above 300
* height below 100
* height above 250
* age below 15
* age above 100

This will be handled by `StoreMacroTargetRequest`.

---

### 3. Client sends calculated fields

The client might try to send:

```json
{
  "daily_calories": 9999
}
```

This should not affect the result.

Handling:

* do not validate those fields
* do not mass-assign request body directly
* only use validated input fields
* merge in service-calculated values manually

---

### 4. User A should not see User B's records

The history endpoint must only return the authenticated user's records.

Handling:

```php
$request->user()->macroTargets()->latest()->paginate(10);
```

Tests will create records for two users and confirm each user only sees their own data.

---

### 5. Macro grams may not add back exactly to daily calories

Because macro grams are rounded to whole integers, multiplying them back by kcal/g may not exactly equal `daily_calories`.

Example:

```text
protein: 210g × 4 = 840 kcal
carbs: 280g × 4 = 1120 kcal
fat: 93g × 9 = 837 kcal
total = 2797 kcal
```

But `daily_calories` is:

```text
2798 kcal
```

This 1 kcal difference is acceptable because macro grams are rounded integers.

---

### 6. Decimal database values may return as strings

Laravel/database decimal values can come back as strings depending on casts and database behavior.

Handling:

* cast or normalize `weight_kg` and `height_cm` in the resource
* ensure response values look like numbers
* ensure calculated macro values are integers

---

### 7. History order

The history must return most recent records first.

Handling:

```php
latest()
```

Tests will create multiple records with different timestamps and assert newest appears first.

---

### 8. Pagination

History must paginate 10 per page.

Handling:

```php
paginate(10)
```

Tests will create more than 10 records and assert:

* `meta.per_page` is 10
* only 10 records are returned on the first page

---

### 9. Maximum calculation values

The input limits are high but still realistic for this task.

The database uses `unsignedSmallInteger` for calculated calorie and macro fields. This should be enough for the allowed validation range because the maximum likely calorie result is far below 65,535.

---

## Testing approach

I will create a feature test file for the macro target API.

Expected test file:

```text
tests/Feature/MacroTargetApiTest.php
```

The tests will cover:

1. authenticated user can calculate and save a macro target
2. known example returns:

   * `daily_calories = 2798`
   * `protein_g = 210`
   * `carbs_g = 280`
   * `fat_g = 93`
3. record is saved to `macro_targets`
4. unauthenticated POST returns 401
5. unauthenticated GET returns 401
6. validation errors return 422
7. history only returns the authenticated user's records
8. history is paginated at 10 per page
9. history is ordered most recent first
10. client-provided calculated values are ignored
11. macro grams are returned as integers

I will write the known-input/known-output test before implementation so there is a failing test first.

---

## Files I expect to create or edit

Expected new files:

```text
app/Models/MacroTarget.php
app/Services/MacroTargetCalculator.php
app/Http/Requests/StoreMacroTargetRequest.php
app/Http/Resources/MacroTargetResource.php
app/Http/Controllers/Api/MacroTargetController.php
database/migrations/xxxx_xx_xx_xxxxxx_create_macro_targets_table.php
tests/Feature/MacroTargetApiTest.php
APPROACH.md
```

Expected edited files:

```text
routes/api.php
app/Models/User.php
.env
```

Possibly edited for testing:

```text
phpunit.xml
```

---

## Final implementation flow

I will build in this order:

1. Finish setup and confirm SQLite/API auth.
2. Create migration for `macro_targets`.
3. Create `MacroTarget` model.
4. Add `User` relationship.
5. Create calculation service.
6. Create FormRequest validation.
7. Create API Resource.
8. Create controller.
9. Add routes.
10. Write failing feature tests.
11. Implement until tests pass.
12. Run full test suite.
13. Manually verify the endpoints.
14. Paste terminal evidence into `BEFORE-AFTER.md`.

---

## Acceptance checklist

Before submitting, I will confirm:

* [ ] `POST /api/macro-targets` returns correct calorie and macro targets for the known input
* [ ] `POST /api/macro-targets` saves the result to the database
* [ ] `POST /api/macro-targets` returns `201`
* [ ] `GET /api/macro-targets` only returns the authenticated user's records
* [ ] history is paginated at 10 per page
* [ ] history is ordered most recent first
* [ ] validation errors return `422`
* [ ] unauthenticated requests return `401`
* [ ] macro gram values are integers
* [ ] calculated fields are computed server-side
* [ ] client-provided calorie or macro overrides are ignored
* [ ] calculation logic lives in a dedicated service class
