<?php

namespace Helper;


use Codeception\TestInterface;
use Lapaz\QuickBrownFox\Database\FixtureSetupSession;
use Lapaz\QuickBrownFox\Database\SessionManager;
use Lapaz\QuickBrownFox\FixtureManager;

class QuickBrownFox extends \Codeception\Module
{
    /** @var SessionManager */
    protected $sessionManager;

    /** @var FixtureSetupSession */
    protected $currentSession;

    /**
     * @inheritdoc
     */
    public function _initialize()
    {
        $fixtureManager = new FixtureManager();
        $connection = new \PDO($this->config['dsn'], $this->config['user'], $this->config['password']);

        // Allow extra initialization via user script here.
        // if (isset($this->config['initScript']) {
        //     require $this->config['initScript'];
        // }

        $this->sessionManager = $fixtureManager->createSessionManager($connection);
    }

    /**
     * @inheritdoc
     */
    public function _before(TestInterface $test)
    {
        parent::_before($test);

        // Generate FixtureSession
        $this->newFixtureSession();
    }

    /**
     * Generate FixtureSession
     *
     */
    public function newFixtureSession()
    {
        $this->currentSession = $this->sessionManager->newSession();
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
        return $this->currentSession;
    }

    /**
     * Load fixtures to specific table.
     *
     * @param $table
     * @param $fixtures
     */
    public function setFixtures($table, $fixtures)
    {
        $this->currentSession->into($table)->load($fixtures);
    }
}
