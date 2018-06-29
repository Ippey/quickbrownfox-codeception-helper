<?php

class QuickBrownFoxTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /** @var \Helper\QuickBrownFox */
    private $helper;

    /** @var \Doctrine\DBAL\Connection */
    private $dbal;

    /**
     * @throws Exception
     */
    protected function _before()
    {
        $config = [
            'dsn' => 'sqlite:tests/_data/test.db',
            'user' => 'testuser',
            'password' => 'testpass',
        ];
        /** @var \Codeception\Lib\ModuleContainer $moduleContainer */
        $moduleContainer = \Codeception\Stub::make(\Codeception\Lib\ModuleContainer::class);
        $this->helper = new \Helper\QuickBrownFox($moduleContainer, $config);
        $this->helper->_initialize();

        $this->dbal = \Doctrine\DBAL\DriverManager::getConnection([
            'pdo' => new PDO($config['dsn'], $config['user'], $config['password']),
        ]);
        $this->dbal->exec("
            DROP TABLE IF EXISTS qbf_test;
            CREATE TABLE qbf_test (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                col INTEGER NOT NULL
            );");

        /** @var \Codeception\TestInterface $test */
        $test = \Codeception\Stub::makeEmpty(\Codeception\TestInterface::class);
        $this->helper->_before($test);
    }

    protected function _after()
    {
    }

    // tests
    public function testNewFixtureSession()
    {
        $this->helper->newFixtureSession();
        $session = $this->helper->getFixtureSession();
        $this->assertInstanceOf(\Lapaz\QuickBrownFox\Database\FixtureSetupSession::class, $session);
    }

    public function testSetFixture()
    {
        $pks = $this->helper->setFixtures('qbf_test', [
            ['col' => 1],
            ['col' => 2],
        ]);

        $this->assertCount(2, $pks);

        $rowCount = $this->dbal->executeQuery("SELECT COUNT(*) FROM qbf_test;")->fetchColumn();
        $this->assertEquals(2, $rowCount);
    }

    public function testSetFixtureWithGenerator()
    {
        $pks = $this->helper->setFixtures('qbf_test', [
            [],
            [],
        ], [
            'col' => function ($i) { return $i; },
        ]);

        $this->assertCount(2, $pks);

        $col0 = $this->dbal->executeQuery("SELECT col FROM qbf_test WHERE id=?;", [$pks[0]])->fetchColumn();
        $this->assertEquals(0, $col0);

        $col1 = $this->dbal->executeQuery("SELECT col FROM qbf_test WHERE id=?;", [$pks[1]])->fetchColumn();
        $this->assertEquals(1, $col1);
    }

    public function testGenerateFixture()
    {
        $pks = $this->helper->generateFixtures('qbf_test', 100, [
            'col' => function ($i) { return $i; },
        ]);
        $this->assertCount(100, $pks);

        $rowCount = $this->dbal->executeQuery("SELECT COUNT(*) FROM qbf_test;")->fetchColumn();
        $this->assertEquals(100, $rowCount);

        $col0 = $this->dbal->executeQuery("SELECT col FROM qbf_test WHERE id=?;", [$pks[0]])->fetchColumn();
        $this->assertEquals(0, $col0);

        $col1 = $this->dbal->executeQuery("SELECT col FROM qbf_test WHERE id=?;", [$pks[1]])->fetchColumn();
        $this->assertEquals(1, $col1);

        $col99 = $this->dbal->executeQuery("SELECT col FROM qbf_test WHERE id=?;", [$pks[99]])->fetchColumn();
        $this->assertEquals(99, $col99);
    }

    public function testGenerateRandomFixture()
    {
        $this->helper->generateFixtures('qbf_test', 100);

        $rowCount = $this->dbal->executeQuery("SELECT COUNT(*) FROM qbf_test;")->fetchColumn();
        $this->assertEquals(100, $rowCount);
    }
}
