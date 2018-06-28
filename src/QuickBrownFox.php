<?php

namespace Helper;


use Codeception\TestInterface;
use Lapaz\QuickBrownFox\Database\FixtureSetupSession;
use Lapaz\QuickBrownFox\FixtureManager;

class QuickBrownFox extends \Codeception\Module
{
    /** @var \PDO */
    protected $connection;

    /** @var FixtureSetupSession */
    protected $fixtureSession;

    /**
     * @param TestInterface $test
     */
    public function _before(TestInterface $test)
    {
        parent::_before($test);

        $this->createConnection();

        // Generate FixtureSession
        $this->newFixtureSession();
    }

    public function _after(TestInterface $test)
    {
        $this->connection = null;

    }

    protected function createConnection()
    {
        $this->connection = new \PDO($this->config['dsn'], $this->config['user'], $this->config['password']);
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
