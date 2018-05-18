<?php

namespace Helper;


use Codeception\TestInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Lapaz\QuickBrownFox\Database\FixtureSetupSession;
use Lapaz\QuickBrownFox\FixtureManager;

class QuickBrownFox extends \Codeception\Module\WebDriver
{
    /** @var Connection */
    protected $connection;

    /** @var FixtureSetupSession */
    protected $fixtureSession;

    /**
     * @param TestInterface $test
     * @throws DBALException
     */
    public function _before(TestInterface $test)
    {
        parent::_before($test);

        $this->connection = \Doctrine\DBAL\DriverManager::getConnection([
            'url' => $this->config['url'],
        ]);
        $this->connection->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        // Generate FixtureSession
        $this->newFixtureSession();
    }

    public function _after(TestInterface $test)
    {
        $this->connection->close();

        parent::_after($test);
    }

    /**
     * Generate FixtureSession
     *
     */
    public function newFixtureSession()
    {
        $fixtureManager = new FixtureManager();
        $this->fixtureSession = $fixtureManager->createSessionManager($this->connection)->newSession();
    }

    /**
     * Reset FixtureSession
     * (Alias newFixtureSession())
     */
    public function resetFixtureSession()
    {
        $this->newFixtureSession();
    }

    /**
     * Get FixtureSession
     *
     * @return FixtureSetupSession
     */
    public function getFixtureSession()
    {
        return $this->fixtureSession;
    }

    /**
     * Load fixtures to specific table.
     *
     * @param $table
     * @param $fixtures
     */
    public function setFixtures($table, $fixtures)
    {
        $session = $this->getFixtureSession();
        $session->into($table)->load($fixtures);
    }
}
