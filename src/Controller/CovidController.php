<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Covid Controller
 *
 *
 * @method \App\Model\Entity\Covid[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CovidController extends AppController
{
	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|null|void Renders view
	 */
	public function index()
	{
		$this->poland();
		$this->render('poland');
	}

	public function poland()
	{
		$covidPolandTable = TableRegistry::getTableLocator()->get('CovidPoland');

		$covid = $covidPolandTable
			->find()
			->order(["date" => "ASC"])
			->toArray()
		;
		
		$current = $covid[count($covid)-1];

		$this->set([
			'covid' => $covid,
			'current' => $current
		]);
	}

	public function polandCharts()
	{
		$covidPolandTable = TableRegistry::getTableLocator()->get('CovidPoland');

		$covidPoland = $covidPolandTable
			->find()
			->order(["date" => "ASC"])
			->toArray()
		;
		
		$current = $covidPoland[count($covidPoland)-1];

		$this->set([
			'covid' => $covidPoland,
			'current' => $current
		]);
	}

	public function polandTable()
	{
		$covidPolandTable = TableRegistry::getTableLocator()->get('CovidPoland');

		$covidPoland = $covidPolandTable
			->find()
			->order(["date" => "ASC"])
			->toArray()
		;

		$this->set([
			'covid' => $covidPoland
		]);
	}

	public function polandMap()
	{
		$covidPlCaseByRegionTable = TableRegistry::getTableLocator()->get('CovidPlCaseByRegion');

		$covidPlCaseByRegion = $covidPlCaseByRegionTable
			->find()
			->toArray()
		;

		$this->set([
			'covid' => $covidPlCaseByRegion
		]);
	}

	public function global()
	{
		$covidGlobalTable = TableRegistry::getTableLocator()->get('CovidGlobal');

		$covidGlobal = $covidGlobalTable
			->find()
			->select(['nation_id', 'nation_name' => 'cgn.name', 'nation_short' => 'cgn.short', 'nation_code' => 'cgn.code', 'infected', 'dead', 'recover'])
			->join([
				'table' => 'covid_global_nations',
				'alias' => 'cgn',
				'type' => 'LEFT',
				'conditions' => 'cgn.id = CovidGlobal.nation_id ',
			])
			->where(["CovidGlobal.date" => date("Y-m-d")])
			->order(["CovidGlobal.infected" => "DESC"])
			->toArray()
		;
		
		$query = $covidGlobalTable->find();
		$covidGlobalToday = $query->select([
				'infected' => $query->func()->sum('infected'),
				'dead' => $query->func()->sum('dead'), 
				'recover' => $query->func()->sum('recover')
			])
			->where(["CovidGlobal.date" => date("Y-m-d")])
			->first()
		;

		$query = $covidGlobalTable->find();
		$covidGlobalYesterday = $query->select([
				'infected' => $query->func()->sum('infected'),
				'dead' => $query->func()->sum('dead'), 
				'recover' => $query->func()->sum('recover')
			])
			->where(["CovidGlobal.date" => date("Y-m-d", strtotime('-1 day'))])
			->first()
		;

		$this->set([
			'covid' => $covidGlobal,
			'summary_today' => $covidGlobalToday,
			'summary_yesterday' => $covidGlobalYesterday
		]);
	}

	public function globalCharts()
	{
		$covidGlByRegionTable = TableRegistry::getTableLocator()->get('CovidGlByRegion');

		$worldByRegion = $covidGlByRegionTable
		->find()
		->where(["CovidGlByRegion._date" => date("Y-m-d")])
		->toArray();

		$this->set([
			'global_by_region' => $worldByRegion
		]);
	}

	public function globalMap()
	{
		$covidGlobalTable = TableRegistry::getTableLocator()->get('CovidGlobal');

		$covidIt = $covidGlobalTable
			->find()
			->select(['nation_id', 'nation_name' => 'cgn.name', 'nation_code' => 'cgn.code', 'infected', 'dead', 'recover'])
			->join([
				'table' => 'covid_global_nations',
				'alias' => 'cgn',
				'type' => 'LEFT',
				'conditions' => 'cgn.id = CovidGlobal.nation_id ',
			])
			->where(["CovidGlobal.date" => date("Y-m-d")])
			->order(["CovidGlobal.infected" => "DESC"])
			->toArray()
		;

		$this->set([
			'covid' => $covidIt
		]);
	}

	public function globalDashboard()
	{
		$covidGlByRegionTable = TableRegistry::getTableLocator()->get('CovidGlByRegion');

		$globalByRegion = $covidGlByRegionTable
		->find()
		->where(["CovidGlByRegion._date" => date("Y-m-d")])
		->toArray();

		$this->set([
			'global_by_region' => $globalByRegion
		]);

		$covidGlobalTable = TableRegistry::getTableLocator()->get('CovidGlobal');

		$query = $covidGlobalTable->find();
		$covidGlobal = $query->select([
				'date',
				'infected' => $query->func()->sum('infected'),
				'dead' => $query->func()->sum('dead'), 
				'recover' => $query->func()->sum('recover')
			])
			//->where(['date' => date("Y-m-d", strtotime('-1 day'))])
			->group(['date'])
			->order(['date' => 'ASC'])
			->toArray()
		;

		$covidGlobalMap = $covidGlobalTable
			->find()
			->select(['nation_id', 'nation_name' => 'cgn.name', 'nation_code' => 'cgn.code', 'infected', 'dead', 'recover'])
			->join([
				'table' => 'covid_global_nations',
				'alias' => 'cgn',
				'type' => 'LEFT',
				'conditions' => 'cgn.id = CovidGlobal.nation_id ',
			])
			->where(["CovidGlobal.date" => date("Y-m-d")])
			->order(["CovidGlobal.infected" => "ASC"])
			->toArray()
		;

		$this->set([
			'global_by_date' => $covidGlobal,
			'global_map' => $covidGlobalMap,
			'global_by_region' => $globalByRegion
		]);
	}
}
