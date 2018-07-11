<?php


class DemoCest
{
    public function tryToTest(UnitTester $I)
    {
        $I->amGoingTo("test book titles, but I don't want to manage other columns");

        $I->setFixtures('books', [
            ['title' => 'Perfect PHP'],
            ['title' => 'Perfect Ruby'],
        ]);

        $I->expectTo("have 2 books properly");

        $I->seeNumRecords(2, 'books');
        $I->seeInDatabase('books', ['title' => 'Perfect PHP']);
        $I->seeInDatabase('books', ['title' => 'Perfect Ruby']);

        $I->expectTo("be filled not-null columns with dummy data");

        $prices = $I->grabFromDatabase('books', 'price');
        $I->assertNotNull($prices[0]);
        $I->assertNotNull($prices[1]);

        $descriptions = $I->grabFromDatabase('books', 'description');
        $I->assertNotNull($descriptions[0]);
        $I->assertNotNull($descriptions[1]);

        $I->expectTo("have an author implicitly via foreign key constraint");

        $I->seeNumRecords(1, 'authors');

        // Your tests here!!
    }

    public function tryToTestTheNextScenario(UnitTester $I)
    {
        $I->amGoingTo("test a book price");

        $I->setFixtures('books', [
            ['price' => 39.80],
        ]);

        $I->expectTo("be removed previous test results");

        $I->seeNumRecords(1, 'books');
    }
}
