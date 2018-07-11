# QuickBrownFox with Codeception Demo

See [Table schema](tests/_data/dump.sql) and [DemoCest](tests/unit/DemoCest.php).

Then run below steps:

```
$ composer install

$ vendor/bin/codecept build

Building Actor classes for suites: unit
 -> UnitTesterActions.php generated successfully. 0 methods added
\UnitTester includes modules: Asserts, Db, \Helper\QuickBrownFox


$ vendor/bin/codecept run --steps

Codeception PHP Testing Framework v2.4.3
Powered by PHPUnit 7.1.5 by Sebastian Bergmann and contributors.

Unit Tests (1) -------------------------------------------------------------
DemoCest: Try to test
Signature: DemoCest:tryToTest
Test: tests/unit/DemoCest.php:tryToTest
Scenario --
 I am going to test book titles, but I don't want to manage other columns
 I set fixtures "books",[{"title":"Perfect PHP"},{"title":"Perfect Ruby"}]
 I expect to have 2 books properly
 I see num records 2,"books"
 I see in database "books",{"title":"Perfect PHP"}
 I see in database "books",{"title":"Perfect Ruby"}
 I expect to be filled not-null columns with dummy data
 I grab column from database "books","price"
 I assert not null "4"
 I assert not null "918"
 I grab column from database "books","description"
 I assert not null "Nostrum et temporibus fugiat incidunt omnis. Voluptas quasi ullam illum i..."
 I assert not null "Sit quibusdam recusandae eum dignissimos. Necessitatibus et ipsum repudia..."
 I expect to have an author implicitly via foreign key constraint
 I see num records 1,"authors"
 PASSED 

DemoCest: Try to test the next scenario
Signature: DemoCest:tryToTestTheNextScenario
Test: tests/unit/DemoCest.php:tryToTestTheNextScenario
Scenario --
 I am going to test a book price
 I set fixtures "books",[{"price":39.8}]
 I expect to be removed previous test results
 I see num records 1,"books"
 PASSED 

-------------------------------------------------------------------------------------------------


Time: 167 ms, Memory: 14.00MB

OK (2 tests, 9 assertions)
```

If you want to switch to Codeception 2.2:

```
$ composer install --prefer-lowest
```

and see `*.yml` comments.
