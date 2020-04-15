<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RegionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RegionsTable Test Case
 */
class RegionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RegionsTable
     */
    protected $Regions;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Regions',
        'app.CaseByRegion',
        'app.CovidPl',
        'app.CovidPl2',
        'app.TmpCovidPl',
        'app.TmpCovidPl2',
        'app.TmpDeath',
        'app.TmpInfected',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Regions') ? [] : ['className' => RegionsTable::class];
        $this->Regions = TableRegistry::getTableLocator()->get('Regions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Regions);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
