Step 1

    Project set up
                1. Start new Laravel project
                2. connect to Github repo
                                                                                                    10 mins

----------------------------------------------------------------------------------------------------------------

Step 2

    Documentation
                1. Write out the Understand.md
                2. Write out the Time Estimate.md
                3. Add the Ai Time estimate to the Estimate.md
                4. Write out the Aproach.md
                                                                                                        120 mins

----------------------------------------------------------------------------------------------------------------

Step 3

    Finish Project set up
                1. Install dependencies
                2. Install Sanctum
                3. Install Pest
                4. Confirm API/auth setup
                                                                                                    20 mins

----------------------------------------------------------------------------------------------------------------

Step 4

    Build Database
                1. Create migration
                2. Build macro_targets table
                        Columns:
                        id
                        user_id
                        weight_kg
                        height_cm
                        age
                        sex
                        activity_level
                        goal
                        preset
                        daily_calories
                        protein_g
                        carbs_g
                        fat_g
                        created_at
                        updated_at
                3. Add foreign key
                                                                                                    20 mins

----------------------------------------------------------------------------------------------------------------

Step 5 

    Create MacroTarget model
                1. fillable fields
                2. casts for numeric fields
                3. relationship to User
    
    Add relationship on User
                                                                                                        20 mins

----------------------------------------------------------------------------------------------------------------

Step 6

    Calculation Service
                1. Create service class
                2. Add constants/config arrays
                            activity multipliers
                            goal adjustments
                            macro presets
                            kcal per gram values
                3. Implement calculation method
                            [
                                'daily_calories' => 2798,
                                'protein_g' => 210,
                                'carbs_g' => 280,
                                'fat_g' => 93,
                            ]
                4. Implement BMR calculation
                5. Implement TDEE
                6. Implement goal adjustment
                7. Implement macro gram calculation
                8. Round consistently
                                                                                                    60 mins

----------------------------------------------------------------------------------------------------------------

Step 7

    Validation
                1. Create FormRequest
                2. Add validation rules
                            Rules:
                                weight_kg: required, numeric, min 30, max 300
                                height_cm: required, numeric, min 100, max 250
                                age: required, integer, min 15, max 100
                                sex: required, in male/female
                                activity_level: required, valid values
                                goal: required, valid values
                                preset: required, valid values
                3. Ensure calculated fields are not accepted
                            Do not validate or pass through:
                                daily_calories
                                protein_g
                                carbs_g
                                fat_g
                            Only use $request->validated().
                                                                                                    45 mins

----------------------------------------------------------------------------------------------------------------

Step 8

    API Resource
                1. Create resource
                2. Format response
                            Return:
                                id
                                weight_kg
                                height_cm
                                age
                                sex
                                activity_level
                                goal
                                preset
                                daily_calories
                                protein_g
                                carbs_g
                                fat_g
                                created_at
                3. Ensure integers remain integers
                            These should not return as strings/floats:
                                daily_calories
                                protein_g
                                carbs_g
                                fat_g
                                                                                                    40 mins

----------------------------------------------------------------------------------------------------------------

Step 9
    
    Controller
                1. Create controller
                2. Implement store
                            Require authenticated user.
                            Validate request using StoreMacroTargetRequest.
                            Pass validated input to service.
                            Merge calculated values with input.
                            Save using authenticated user relationship.
                            Return resource with 201.
                3. Implement index
                            Get authenticated user.
                            Query only their macro targets.
                            Order newest first.
                            Paginate 10 per page.
                            Return resource collection.
                                                                                                        30 mins

----------------------------------------------------------------------------------------------------------------

Step 10

    Routes
                1. Add routes in routes/api.php
                2. Confirm unauthenticated requests return 401
                                                                                                    20 mins

----------------------------------------------------------------------------------------------------------------

Step 11

    Tests: Failing Commit First
                1. Create feature test file
                2. Write known input/output test first
                            authenticated user posts example input
                            response status is 201
                            daily calories = 2798
                            protein_g = 210
                            carbs_g = 280
                            fat_g = 93
                            database has saved record
                3. Test user history
                            Create User A.
                            Create User B.
                            Create records for both.
                            Authenticate as User A.
                            Assert response only includes User A records.
                4. Test pagination
                            Create more than 10 records for one user.
                            Assert per_page is 10.
                            Assert only 10 records returned.
                            Assert newest first.
                5. Test validation
                            missing fields
                            invalid sex
                            invalid activity level
                            invalid goal
                            invalid preset
                            weight too low/high
                            height too low/high
                            age too low/high
                6. Test unauthenticated requests
                            Guest POST returns 401.
                            Guest GET returns 401.
                7. Test client override ignored
                8. Test macro grams are integers
                            daily_calories is integer
                            protein_g is integer
                            carbs_g is integer
                            fat_g is integer
                                                                                                    90 mins

----------------------------------------------------------------------------------------------------------------

Step 12

    Implementation Pass
                1. Make tests pass
                2. Run test suite
                3. Fix failures
                                                                                                    30 mins

----------------------------------------------------------------------------------------------------------------

Step 13

    Manual Verification
                1. Run migrations fresh
                2. Run tests
                3. Manually test API
                                                                                                    20 mins

----------------------------------------------------------------------------------------------------------------

Step 14
    
    Before/After Evidence
                1. Create BEFORE-AFTER.md
                            failing test run before implementation
                            passing test run after implementation
                            migration output if useful
                            manual endpoint check if useful
                                                                                                    30 mins

----------------------------------------------------------------------------------------------------------------

                                                                                                    9.25 hrs

----------------------------------------------------------------------------------------------------------------                                                                                                    
AI Time Estimate

My current estimate says 9.25 hours total for Steps 1–14. I think that is a good safe/manual estimate, but AI estimates it would be slightly lower: 7.5–8.5 hours for someone comfortable with Laravel APIs and Pest. My higher number is still defendable because the workflow requires documentation, failing commits, manual verification, and before/after evidence.

Step	Task	                            My estimate	    Ai estimate
1	    Project setup + GitHub	            10 min	            15 min
2	    Documentation: understanding,       120 min	            90–120 min
        estimate, AI estimate, approach
3	    Finish setup: API, Sanctum, Pest	20 min	            20–30 min
4	    Database migration	                20 min	            20 min
5	    Model + User relationship	        20 min	            15–20 min
6	    Calculation service	                60 min	            45–60 min
7	    Validation/FormRequest	            45 min	            30–40 min
8	    API Resource	                    40 min	            25–35 min
9	    Controller	                        30 min	            30–40 min
10	    Routes/auth check	                20 min	            15–20 min
11	    Tests	                            90 min	            90–120 min
12	    Implementation pass/fix failures	30 min	            45–60 min
13	    Manual verification	                20 min	            20–30 min
14	    Before/After evidence	            30 min	            20–30 min

AI estimated Time: 7.5–8.5 hours.

----------------------------------------------------------------------------------------------------------------           