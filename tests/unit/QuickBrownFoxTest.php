<?php

class QuickBrownFoxTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /** @var \Helper\QuickBrownFox */
    private $helper;

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
}