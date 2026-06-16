---------------------------------------------------------------------------------------------------------------

Before:

---------------------------------------------------------------------------------------------------------------

 PASS  Tests\Unit\ExampleTest
  ✓ that true is true                                                                                             0.01s  

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response                                                                 0.15s  

   FAIL  Tests\Feature\MacroTargetTest
  ⨯ it returns 201 and correct calculated values                                                                  0.05s  
  ⨯ it saves the record to the database                                                                           0.01s  
  ⨯ it ignores client-supplied calculated fields                                                                  0.01s  
  ⨯ it returns macro grams as integers                                                                            0.01s  
  ⨯ it returns only the authenticated users records                                                               0.01s  
  ⨯ it paginates at 10 per page                                                                                   0.01s  
  ⨯ it returns records newest first                                                                               0.01s  
  ✓ it returns 401 for unauthenticated POST                                                                       0.02s  
  ✓ it returns 401 for unauthenticated GET                                                                        0.01s  
  ⨯ it returns 422 when required fields are missing                                                               0.01s  
  ⨯ it rejects invalid sex value                                                                                  0.01s  
  ⨯ it rejects invalid activity level                                                                             0.01s  
  ⨯ it rejects invalid goal                                                                                       0.01s  
  ⨯ it rejects invalid preset                                                                                     0.01s  
  ⨯ it rejects weight out of range                                                                                0.01s  
  ⨯ it rejects height out of range                                                                                0.01s  
  ⨯ it rejects age out of range                                                                                   0.01s  
  ───────────────────────────────────────────────────────────────────────────────────────────────────────────────
   FAILED  Tests\Feature\MacroTargetTest > it returns 201 and correct calculated values                 QueryException   
  SQLSTATE[HY000]: General error: 1 no such table: users (Connection: sqlite, Database: :memory:, SQL: insert into "users" ("name", "email", "email_verified_at", "password", "remember_token", "updated_at", "created_at") values (Willie Maggio, abruen@example.net, 2026-06-16 02:08:56, $2y$04$V/Yg.hMH0jXVtwwARSsFaOWG4BUF9KDv7a6fu9K5j.nNSZY5tHrqm, x0KbyTRYRK, 2026-06-16 02:08:56, 2026-06-16 02:08:56))

  at vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
    574▕             if ($this->pretending()) {
    575▕                 return true;
    576▕             }
    577▕ 
  ➜ 578▕             $statement = $this->getPdo()->prepare($query);
    579▕ 
    580▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    581▕ 
    582▕             $this->recordsHaveBeenModified();

  1   vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
  2   vendor\laravel\framework\src\Illuminate\Database\Connection.php:827

  ───────────────────────────────────────────────────────────────────────────────────────────────────────────────
   FAILED  Tests\Feature\MacroTargetTest > it saves the record to the database                          QueryException   
  SQLSTATE[HY000]: General error: 1 no such table: users (Connection: sqlite, Database: :memory:, SQL: insert into "users" ("name", "email", "email_verified_at", "password", "remember_token", "updated_at", "created_at") values (Terry Koss, kshlerin.neva@example.com, 2026-06-16 02:08:56, $2y$04$V/Yg.hMH0jXVtwwARSsFaOWG4BUF9KDv7a6fu9K5j.nNSZY5tHrqm, Wrzv8ie6W0, 2026-06-16 02:08:56, 2026-06-16 02:08:56))

  at vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
    574▕             if ($this->pretending()) {
    575▕                 return true;
    576▕             }
    577▕ 
  ➜ 578▕             $statement = $this->getPdo()->prepare($query);
    579▕ 
    580▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    581▕ 
    582▕             $this->recordsHaveBeenModified();

  1   vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
  2   vendor\laravel\framework\src\Illuminate\Database\Connection.php:827

  ───────────────────────────────────────────────────────────────────────────────────────────────────────────────
   FAILED  Tests\Feature\MacroTargetTest > it ignores client-supplied calculated fields                 QueryException   
  SQLSTATE[HY000]: General error: 1 no such table: users (Connection: sqlite, Database: :memory:, SQL: insert into "users" ("name", "email", "email_verified_at", "password", "remember_token", "updated_at", "created_at") values (Trent Kulas, dickens.edwin@example.org, 2026-06-16 02:08:56, $2y$04$V/Yg.hMH0jXVtwwARSsFaOWG4BUF9KDv7a6fu9K5j.nNSZY5tHrqm, 4BIsYFEvWL, 2026-06-16 02:08:56, 2026-06-16 02:08:56))

  at vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
    574▕             if ($this->pretending()) {
    575▕                 return true;
    576▕             }
    577▕ 
  ➜ 578▕             $statement = $this->getPdo()->prepare($query);
    579▕ 
    580▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    581▕ 
    582▕             $this->recordsHaveBeenModified();

  1   vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
  2   vendor\laravel\framework\src\Illuminate\Database\Connection.php:827

  ───────────────────────────────────────────────────────────────────────────────────────────────────────────────
   FAILED  Tests\Feature\MacroTargetTest > it returns macro grams as integers                           QueryException   
  SQLSTATE[HY000]: General error: 1 no such table: users (Connection: sqlite, Database: :memory:, SQL: insert into "users" ("name", "email", "email_verified_at", "password", "remember_token", "updated_at", "created_at") values (Tatum Kautzer, wiza.fabiola@example.org, 2026-06-16 02:08:56, $2y$04$V/Yg.hMH0jXVtwwARSsFaOWG4BUF9KDv7a6fu9K5j.nNSZY5tHrqm, jbO3Tc7Fyw, 2026-06-16 02:08:56, 2026-06-16 02:08:56))

  at vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
    574▕             if ($this->pretending()) {
    575▕                 return true;
    576▕             }
    577▕ 
  ➜ 578▕             $statement = $this->getPdo()->prepare($query);
    579▕ 
    580▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    581▕ 
    582▕             $this->recordsHaveBeenModified();

  1   vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
  2   vendor\laravel\framework\src\Illuminate\Database\Connection.php:827

  ───────────────────────────────────────────────────────────────────────────────────────────────────────────────
   FAILED  Tests\Feature\MacroTargetTest > it returns only the authenticated users records              QueryException   
  SQLSTATE[HY000]: General error: 1 no such table: users (Connection: sqlite, Database: :memory:, SQL: insert into "users" ("name", "email", "email_verified_at", "password", "remember_token", "updated_at", "created_at") values (Mrs. Jane Gusikowski, nicholas82@example.net, 2026-06-16 02:08:56, $2y$04$V/Yg.hMH0jXVtwwARSsFaOWG4BUF9KDv7a6fu9K5j.nNSZY5tHrqm, 8Kqjlo628X, 2026-06-16 02:08:56, 2026-06-16 02:08:56))

  at vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
    574▕             if ($this->pretending()) {
    575▕                 return true;
    576▕             }
    577▕ 
  ➜ 578▕             $statement = $this->getPdo()->prepare($query);
    579▕ 
    580▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    581▕ 
    582▕             $this->recordsHaveBeenModified();

  1   vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
  2   vendor\laravel\framework\src\Illuminate\Database\Connection.php:827

  ───────────────────────────────────────────────────────────────────────────────────────────────────────────────
   FAILED  Tests\Feature\MacroTargetTest > it paginates at 10 per page                                  QueryException   
  SQLSTATE[HY000]: General error: 1 no such table: users (Connection: sqlite, Database: :memory:, SQL: insert into "users" ("name", "email", "email_verified_at", "password", "remember_token", "updated_at", "created_at") values (Devyn Hane, albin.cormier@example.org, 2026-06-16 02:08:56, $2y$04$V/Yg.hMH0jXVtwwARSsFaOWG4BUF9KDv7a6fu9K5j.nNSZY5tHrqm, 87O00sqFcI, 2026-06-16 02:08:56, 2026-06-16 02:08:56))

  at vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
    574▕             if ($this->pretending()) {
    575▕                 return true;
    576▕             }
    577▕ 
  ➜ 578▕             $statement = $this->getPdo()->prepare($query);
    579▕ 
    580▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    581▕ 
    582▕             $this->recordsHaveBeenModified();

  1   vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
  2   vendor\laravel\framework\src\Illuminate\Database\Connection.php:827

  ───────────────────────────────────────────────────────────────────────────────────────────────────────────────
   FAILED  Tests\Feature\MacroTargetTest > it returns records newest first                              QueryException   
  SQLSTATE[HY000]: General error: 1 no such table: users (Connection: sqlite, Database: :memory:, SQL: insert into "users" ("name", "email", "email_verified_at", "password", "remember_token", "updated_at", "created_at") values (Carmen Becker, cristal.donnelly@example.net, 2026-06-16 02:08:56, $2y$04$V/Yg.hMH0jXVtwwARSsFaOWG4BUF9KDv7a6fu9K5j.nNSZY5tHrqm, MR8Q8iuJbF, 2026-06-16 02:08:56, 2026-06-16 02:08:56))

  at vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
    574▕             if ($this->pretending()) {
    575▕                 return true;
    576▕             }
    577▕ 
  ➜ 578▕             $statement = $this->getPdo()->prepare($query);
    579▕ 
    580▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    581▕ 
    582▕             $this->recordsHaveBeenModified();

  1   vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
  2   vendor\laravel\framework\src\Illuminate\Database\Connection.php:827

  ────────────────────────────────────────────────────────────────────────────────────────────────────────────── 
   FAILED  Tests\Feature\MacroTargetTest > it returns 422 when required fields are missing              QueryException   
  SQLSTATE[HY000]: General error: 1 no such table: users (Connection: sqlite, Database: :memory:, SQL: insert into "users" ("name", "email", "email_verified_at", "password", "remember_token", "updated_at", "created_at") values (Prof. Bertram Kertzmann, mellie43@example.com, 2026-06-16 02:08:56, $2y$04$V/Yg.hMH0jXVtwwARSsFaOWG4BUF9KDv7a6fu9K5j.nNSZY5tHrqm, rL2VCdhe7I, 2026-06-16 02:08:56, 2026-06-16 02:08:56))

  at vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
    574▕             if ($this->pretending()) {
    575▕                 return true;
    576▕             }
    577▕ 
  ➜ 578▕             $statement = $this->getPdo()->prepare($query);
    579▕ 
    580▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    581▕ 
    582▕             $this->recordsHaveBeenModified();

  1   vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
  2   vendor\laravel\framework\src\Illuminate\Database\Connection.php:827

  ───────────────────────────────────────────────────────────────────────────────────────────────────────────────
   FAILED  Tests\Feature\MacroTargetTest > it rejects invalid sex value                                 QueryException   
  SQLSTATE[HY000]: General error: 1 no such table: users (Connection: sqlite, Database: :memory:, SQL: insert into "users" ("name", "email", "email_verified_at", "password", "remember_token", "updated_at", "created_at") values (Willard Collier, okon.libby@example.org, 2026-06-16 02:08:56, $2y$04$V/Yg.hMH0jXVtwwARSsFaOWG4BUF9KDv7a6fu9K5j.nNSZY5tHrqm, hbqxD7jK4I, 2026-06-16 02:08:56, 2026-06-16 02:08:56))

  at vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
    574▕             if ($this->pretending()) {
    575▕                 return true;
    576▕             }
    577▕ 
  ➜ 578▕             $statement = $this->getPdo()->prepare($query);
    579▕ 
    580▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    581▕ 
    582▕             $this->recordsHaveBeenModified();

  1   vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
  2   vendor\laravel\framework\src\Illuminate\Database\Connection.php:827

  ───────────────────────────────────────────────────────────────────────────────────────────────────────────────
   FAILED  Tests\Feature\MacroTargetTest > it rejects invalid activity level                            QueryException   
  SQLSTATE[HY000]: General error: 1 no such table: users (Connection: sqlite, Database: :memory:, SQL: insert into "users" ("name", "email", "email_verified_at", "password", "remember_token", "updated_at", "created_at") values (Domenica Kub DVM, josephine.nienow@example.org, 2026-06-16 02:08:56, $2y$04$V/Yg.hMH0jXVtwwARSsFaOWG4BUF9KDv7a6fu9K5j.nNSZY5tHrqm, oyqI0fQATA, 2026-06-16 02:08:56, 2026-06-16 02:08:56))

  at vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
    574▕             if ($this->pretending()) {
    575▕                 return true;
    576▕             }
    577▕ 
  ➜ 578▕             $statement = $this->getPdo()->prepare($query);
    579▕ 
    580▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    581▕ 
    582▕             $this->recordsHaveBeenModified();

  1   vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
  2   vendor\laravel\framework\src\Illuminate\Database\Connection.php:827

  ───────────────────────────────────────────────────────────────────────────────────────────────────────────────
   FAILED  Tests\Feature\MacroTargetTest > it rejects invalid goal                                      QueryException   
  SQLSTATE[HY000]: General error: 1 no such table: users (Connection: sqlite, Database: :memory:, SQL: insert into "users" ("name", "email", "email_verified_at", "password", "remember_token", "updated_at", "created_at") values (Derrick Klocko, davon16@example.com, 2026-06-16 02:08:56, $2y$04$V/Yg.hMH0jXVtwwARSsFaOWG4BUF9KDv7a6fu9K5j.nNSZY5tHrqm, ls6iYOPYlB, 2026-06-16 02:08:56, 2026-06-16 02:08:56))

  at vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
    574▕             if ($this->pretending()) {
    575▕                 return true;
    576▕             }
    577▕ 
  ➜ 578▕             $statement = $this->getPdo()->prepare($query);
    579▕ 
    580▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    581▕ 
    582▕             $this->recordsHaveBeenModified();

  1   vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
  2   vendor\laravel\framework\src\Illuminate\Database\Connection.php:827

  ────────────────────────────────────────────────────────────────────────────────────────────────────────────── 
   FAILED  Tests\Feature\MacroTargetTest > it rejects invalid preset                                    QueryException   
  SQLSTATE[HY000]: General error: 1 no such table: users (Connection: sqlite, Database: :memory:, SQL: insert into "users" ("name", "email", "email_verified_at", "password", "remember_token", "updated_at", "created_at") values (Missouri O'Reilly, kassandra69@example.com, 2026-06-16 02:08:56, $2y$04$V/Yg.hMH0jXVtwwARSsFaOWG4BUF9KDv7a6fu9K5j.nNSZY5tHrqm, UG92lYlVJ5, 2026-06-16 02:08:56, 2026-06-16 02:08:56))

  at vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
    574▕             if ($this->pretending()) {
    575▕                 return true;
    576▕             }
    577▕ 
  ➜ 578▕             $statement = $this->getPdo()->prepare($query);
    579▕ 
    580▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    581▕ 
    582▕             $this->recordsHaveBeenModified();

  1   vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
  2   vendor\laravel\framework\src\Illuminate\Database\Connection.php:827

  ───────────────────────────────────────────────────────────────────────────────────────────────────────────────
   FAILED  Tests\Feature\MacroTargetTest > it rejects weight out of range                               QueryException   
  SQLSTATE[HY000]: General error: 1 no such table: users (Connection: sqlite, Database: :memory:, SQL: insert into "users" ("name", "email", "email_verified_at", "password", "remember_token", "updated_at", "created_at") values (Drew Kreiger, dgutmann@example.org, 2026-06-16 02:08:56, $2y$04$V/Yg.hMH0jXVtwwARSsFaOWG4BUF9KDv7a6fu9K5j.nNSZY5tHrqm, Gq4TSIp1pt, 2026-06-16 02:08:56, 2026-06-16 02:08:56))

  at vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
    574▕             if ($this->pretending()) {
    575▕                 return true;
    576▕             }
    577▕ 
  ➜ 578▕             $statement = $this->getPdo()->prepare($query);
    579▕ 
    580▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    581▕ 
    582▕             $this->recordsHaveBeenModified();

  1   vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
  2   vendor\laravel\framework\src\Illuminate\Database\Connection.php:827

  ───────────────────────────────────────────────────────────────────────────────────────────────────────────────
   FAILED  Tests\Feature\MacroTargetTest > it rejects height out of range                               QueryException   
  SQLSTATE[HY000]: General error: 1 no such table: users (Connection: sqlite, Database: :memory:, SQL: insert into "users" ("name", "email", "email_verified_at", "password", "remember_token", "updated_at", "created_at") values (Deondre Lynch, raquel.wyman@example.org, 2026-06-16 02:08:56, $2y$04$V/Yg.hMH0jXVtwwARSsFaOWG4BUF9KDv7a6fu9K5j.nNSZY5tHrqm, llAwCQXqKF, 2026-06-16 02:08:56, 2026-06-16 02:08:56))

  at vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
    574▕             if ($this->pretending()) {
    575▕                 return true;
    576▕             }
    577▕ 
  ➜ 578▕             $statement = $this->getPdo()->prepare($query);
    579▕ 
    580▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    581▕ 
    582▕             $this->recordsHaveBeenModified();

  1   vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
  2   vendor\laravel\framework\src\Illuminate\Database\Connection.php:827

  ────────────────────────────────────────────────────────────────────────────────────────────────────────────── 
   FAILED  Tests\Feature\MacroTargetTest > it rejects age out of range                                  QueryException   
  SQLSTATE[HY000]: General error: 1 no such table: users (Connection: sqlite, Database: :memory:, SQL: insert into "users" ("name", "email", "email_verified_at", "password", "remember_token", "updated_at", "created_at") values (Alfonso McLaughlin, ulices97@example.org, 2026-06-16 02:08:56, $2y$04$V/Yg.hMH0jXVtwwARSsFaOWG4BUF9KDv7a6fu9K5j.nNSZY5tHrqm, KMgcWluN2m, 2026-06-16 02:08:56, 2026-06-16 02:08:56))

  at vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
    574▕             if ($this->pretending()) {
    575▕                 return true;
    576▕             }
    577▕ 
  ➜ 578▕             $statement = $this->getPdo()->prepare($query);
    579▕ 
    580▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    581▕ 
    582▕             $this->recordsHaveBeenModified();

  1   vendor\laravel\framework\src\Illuminate\Database\Connection.php:578
  2   vendor\laravel\framework\src\Illuminate\Database\Connection.php:827


  Tests:    15 failed, 4 passed (4 assertions)
  Duration: 0.56s

---------------------------------------------------------------------------------------------------------------

After:

---------------------------------------------------------------------------------------------------------------

  PS C:\Users\mccor\Desktop\Projects\MacroActive\MA02\MacroTargetCalculator> php artisan test

   PASS  Tests\Unit\ExampleTest
  ✓ that true is true                                                                                             0.01s  

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response                                                                 0.15s  

   PASS  Tests\Feature\MacroTargetTest
  ✓ it returns 201 and correct calculated values                                                                  0.13s  
  ✓ it saves the record to the database                                                                           0.01s  
  ✓ it ignores client-supplied calculated fields                                                                  0.01s  
  ✓ it returns macro grams as integers                                                                            0.01s  
  ✓ it returns only the authenticated users records                                                               0.02s  
  ✓ it paginates at 10 per page                                                                                   0.03s  
  ✓ it returns records newest first                                                                               0.02s  
  ✓ it returns 401 for unauthenticated POST                                                                       0.01s  
  ✓ it returns 401 for unauthenticated GET                                                                        0.01s  
  ✓ it returns 422 when required fields are missing                                                               0.01s  
  ✓ it rejects invalid sex value                                                                                  0.01s  
  ✓ it rejects invalid activity level                                                                             0.01s  
  ✓ it rejects invalid goal                                                                                       0.01s  
  ✓ it rejects invalid preset                                                                                     0.01s  
  ✓ it rejects weight out of range                                                                                0.01s  
  ✓ it rejects height out of range                                                                                0.01s  
  ✓ it rejects age out of range                                                                                   0.01s  

  Tests:    19 passed (60 assertions)
  Duration: 0.69s