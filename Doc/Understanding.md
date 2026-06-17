What I need to make

i need to build a laravel api that lets authenticated users calculate and save daily macro targets for a body profile, then able to retrieve their own calculation history

I will be needing 2 api's 

Method  |	URI	                |   Purpose
        |                       |    
POST	|   /api/macro-targets  |	Calculate daily calories and macro grams, save the result, return the 
        |                       |   saved record
        |                       |
GET	    |   /api/macro-targets  |   Return the authenticated user's saved macro target history

Both api's will need Sanctum authentication

for the calculations we need to use the Mifflin-St Jeor equation not the older Harris-Benedict equation from the old spreadsheet.

---------------------------------------------------------------------------------------------------------

## The Mifflin-St Jeor formula

*BMR:*
- Male: `(10 × weight_kg) + (6.25 × height_cm) − (5 × age) + 5`
- Female: `(10 × weight_kg) + (6.25 × height_cm) − (5 × age) − 161`

*TDEE = BMR × activity multiplier:*

| Activity level | Multiplier |
|---|---|
| sedentary | 1.2 |
| light | 1.4 |
| moderate | 1.55 |
| active | 1.725 |
| very_active | 1.9 |

*Goal adjustment (applied to TDEE):*

| Goal | Adjustment |
|---|---|
| lose | −500 kcal |
| maintain | 0 kcal |
| gain | +300 kcal |

*Macro split by preset (percentage of adjusted daily calories):*

| Preset | Protein % | Carbs % | Fat % |
|---|---|---|---|
| standard | 30% | 40% | 30% |
| high_protein | 40% | 30% | 30% |
| keto | 25% | 5% | 70% |

*Calories per gram — from the existing spreadsheet tool:*

| Macro | kcal/g |
|---|---|
| Protein | 4 |
| Carbohydrates | 4 |
| Fat | 4 |

---------------------------------------------------------------------------------------------------------

Inputs the POST endpoint takes

The POST request requires these fields:

{
  "weight_kg": 80,
  "height_cm": 180,
  "age": 25,
  "sex": "male",
  "activity_level": "moderate",
  "goal": "maintain",
  "preset": "standard"
}

Validation rules:

Field	                Rule
weight_kg	            required, numeric, between 30 and 300
height_cm	            required, numeric, between 100 and 250
age	                    required, integer, between 15 and 100
sex	                    required, male or female
activity_level	        required, sedentary, light, moderate, active, or very_active
goal	                required, lose, maintain, or gain
preset	                required, standard, high_protein, or keto

The API must calculate these server-side:

BMR
TDEE
adjusted daily calories
protein grams
carbohydrate grams
fat grams

The API must not trust client-provided values for daily_calories, protein_g, carbs_g, or fat_g.


---------------------------------------------------------------------------------------------------------

What the POST endpoint returns

On success, POST /api/macro-targets returns 201 Created and a saved macro target resource:

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

The response should expose calculated integer macro grams, not floats.

---------------------------------------------------------------------------------------------------------

What the GET endpoint returns

GET /api/macro-targets returns the authenticated user's own saved calculation history.

Rules:

only the logged-in user's records
most recent first
paginated
10 records per page

It must not return records belonging to other users.

Example shape:

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

---------------------------------------------------------------------------------------------------------

Revised Formula reference

The correct standard macro calorie values are:

Macro	        |    Correct kcal/g     |
Protein	        |    4                  |
Carbohydrates	|    4                  |
Fat	            |    9                  |

---------------------------------------------------------------------------------------------------------

Working example

Input:

{
  "weight_kg": 80,
  "height_cm": 180,
  "age": 25,
  "sex": "male",
  "activity_level": "moderate",
  "goal": "maintain",
  "preset": "standard"
}

--------------------------------------------------------

Step 1 — Calculate BMR

Use Mifflin-St Jeor for male:

BMR = (10 × weight_kg) + (6.25 × height_cm) − (5 × age) + 5

Substitute the values:

BMR = (10 × 80) + (6.25 × 180) − (5 × 25) + 5

Calculate each part:

10 × 80 = 800
6.25 × 180 = 1125
5 × 25 = 125

So:

BMR = 800 + 1125 − 125 + 5
BMR = 1805

BMR is:

1805 kcal/day

--------------------------------------------------------

Step 2 — Apply activity multiplier

Activity level is moderate.

The moderate multiplier is:

1.55

TDEE: (Total Daily Energy Expenditure)

TDEE = BMR × activity multiplier
TDEE = 1805 × 1.55
TDEE = 2797.75

--------------------------------------------------------

Step 3 — Apply goal adjustment

Goal is maintain.

Maintain adjustment is:

0 kcal

Adjusted daily calories:

2797.75 + 0 = 2797.75

Rounded daily calories:

2798 kcal/day

--------------------------------------------------------

Step 4 — Apply macro preset

Preset is standard.

Standard preset split:

Macro	Percentage
Protein	30%
Carbs	40%
Fat	30%

Use adjusted daily calories of 2798 for the final displayed macro calculation.

Protein calories:

2798 × 0.30 = 839.4 kcal

Carb calories:

2798 × 0.40 = 1119.2 kcal

Fat calories:

2798 × 0.30 = 839.4 kcal

--------------------------------------------------------

Step 5 — Convert macro calories to grams

Protein uses 4 kcal/g:

839.4 / 4 = 209.85
rounded = 210g

Carbohydrates use 4 kcal/g:

1119.2 / 4 = 279.8
rounded = 280g

Fat uses 9 kcal/g:

839.4 / 9 = 93.266...
rounded = 93g

Final result:

{
  "daily_calories": 2798,
  "protein_g": 210,
  "carbs_g": 280,
  "fat_g": 93
}

---------------------------------------------------------------------------------------------------------

How the integers will be rounded 

- round daily calories to the nearest integer
- calculate macro calories from the rounded daily calorie target
- round macro grams to the nearest integer

---------------------------------------------------------------------------------------------------------

Since macro grams are rounded to integers, multiplying the final grams back may not exactly equal daily_calories.

Example:

protein: 210g × 4 = 840 kcal
carbs: 280g × 4 = 1120 kcal
fat: 93g × 9 = 837 kcal

Total:

840 + 1120 + 837 = 2797 kcal

---------------------------------------------------------------------------------------------------------

Decimal input fields as whole numbers

---------------------------------------

The database stores:

weight_kg decimal(5,2)
height_cm decimal(5,2)

---------------------------------------

The example shows:

"weight_kg": 80,
"height_cm": 180

not:

"weight_kg": "80.00",
"height_cm": "180.00"

Cast them to normalized numbers in the resource

---------------------------------------------------------------------------------------------------------

Extra client-provided calorie or macro fields are not part of the accepted input

API computes everything server-side and does not accept or use client-provided overrides.

So if the client sends:

{
  "daily_calories": 9999
}

alongside the valid fields, the API should ignore it and calculate the real value.

The safest implementation is to only pass validated/safe fields into the service and model creation.

---------------------------------------------------------------------------------------------------------

Coaches set targets for clients, but the data model only has user_id

For this task, each authenticated user owns their own calculation records. There is no separate client table or coach-client relationship in scope.

---------------------------------------------------------------------------------------------------------

Project set up

            1. install/configure Laravel API scaffolding
            2. install/configure Sanctum support
            3. Pest (for tests)

---------------------------------------------------------------------------------------------------------

Auth testing needs to prove both 401 and user isolation

- unauthenticated requests return 401
- authenticated user only sees their own records