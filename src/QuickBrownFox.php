<?php

namespace Helper;


use Codeception\Exception\ModuleConfigException;
use Codeception\TestInterface;
use Doctrine\DBAL\DriverManager;
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
     * @throws ModuleConfigException
     */
    public function _initialize()
    {
        try {
            $fixtureManager = new FixtureManager();

            $connection = DriverManager::getConnection([
                'pdo' => new \PDO($this->config['dsn'], $this->config['user'], $this->config['password'])
            ]);

            // Allow extra initialization via user script here.
            // if (isset($this->config['initScript']) {
            //     require $this->config['initScript'];
            // }

            $this->sessionManager = $fixtureManager->createSessionManager($connection);
        } catch (\Exception $e) {
            throw new ModuleConfigException($this, $e->getMessage(), $e);
        }
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
     * @param string $table
     * @param array $fixtures
     * @param callable|string|null $generator
     * @param int $baseIndex
     * @return array Primary keys
     */
    public function setFixtures($table, $fixtures, $generator = null, $baseIndex = 0)
    {
        $loading = $this->currentSession->into($table);
        if ($generator) {
            $loading = $loading->with($generator);
        }
        return $loading->load($fixtures, $baseIndex);
    }

    /**
     * Generate fixtures and load them to specific table.
     *
     * @param string $table
     * @param int $amount
     * @param callable|string|null $generator
     * @param int $baseIndex
     * @return array Primary keys
     */
    public function generateFixtures($table, $amount, $generator = null, $baseIndex = 0)
    {
        $loading = $this->currentSession->into($table);
        if ($generator) {
            $loading = $loading->with($generator);
        }
        return $loading->generate($amount, $baseIndex);
    }
}
