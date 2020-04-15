<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Settlement Controller
 *
 *
 * @method \App\Model\Entity\Settlement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SettlementController extends AppController
{
	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|null|void Renders view
	 */
	public function index()
	{
		$homeSettlementTable = TableRegistry::getTableLocator()->get('HomeSettlement');

		$homeSettlement = $homeSettlementTable
			->find()
			//->select(['id', 'date', 'summary' => 'SUM(ROUND(hsv.amount*hsv.price,2))'])
			->select(['id', 'date', 'summary' => 'SUM(ROUND(ROUND(hsv.amount,3)*ROUND(hsv.price,3),2))'])
			->join([
				'table' => 'home_settlement_value',
				'alias' => 'hsv',
				'type' => 'LEFT',
				'conditions' => 'hsv.settlement_id = HomeSettlement.id ',
			])
			->group(['HomeSettlement.id'])
			//->where(['HomeSettlementValue.settlement_id =' => $id])
			->order(['HomeSettlement.date' => 'ASC'])
			->limit(20)
    		->page(1)
		;

		$this->set('settlement', $homeSettlement);
	}

	/**
	 * View method
	 *
	 * @param string|null $id Settlement id.
	 * @return \Cake\Http\Response|null|void Renders view
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$homeSettlementTable = TableRegistry::getTableLocator()->get('HomeSettlement');
		$homeSettlement = $homeSettlementTable->get($id);

		$homeSettlementValueTable = TableRegistry::getTableLocator()->get('HomeSettlementValue');
		$homeSettlementValue = $homeSettlementValueTable
			->find()
			->select(['id', 'settlement_id', 'component_id', 'state', 'price', 'amount', 'name' => 'hsc.name', 'description' => 'hsc.description', 'unit' => 'hsc.unit'])
			->join([
				'table' => 'home_settlement_component',
				'alias' => 'hsc',
				'type' => 'LEFT',
				'conditions' => 'hsc.id = HomeSettlementValue.component_id ',
			])
			->where(['HomeSettlementValue.settlement_id =' => $id])
			->order(['hsc.orderby' => 'ASC'])
			->toArray()
		;

		$this->set([
			'settlement' => $homeSettlement,
			'settlementValue' => $homeSettlementValue
		]);
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
	 */
	public function new()
	{
		$post = null;
		$settlementId = null;

		if ($this->request->is('post')) {

			$successFlag = false;

			$homeSettlementTable = TableRegistry::getTableLocator()->get('HomeSettlement');
			$homeSettlementValueTable = TableRegistry::getTableLocator()->get('HomeSettlementValue');

			$homeSettlement = $homeSettlementTable->newEmptyEntity();
			$homeSettlement->date = $this->request->getData('settlement_date');

			if ($homeSettlementTable->save($homeSettlement)) {
				$homeSettlementValueSaved = [];
				$settlementId = $homeSettlement->id;
				$_data = $this->request->getData();

				foreach($_data as $key => $val){
					if(substr($key, 0, 9) == "component") {
						$count = explode("_", $key)[1];

						if( $_data["component_".$count] != "" && $_data["price_".$count] != "" && $_data["amount_".$count] != "" ) {
							$post[] = [$_data["component_".$count], $_data["price_".$count], $_data["amount_".$count]];

							$homeSettlementValue = $homeSettlementValueTable->newEmptyEntity();
							$homeSettlementValue->settlement_id  = $settlementId;
							$homeSettlementValue->component_id = $_data["component_".$count];
							$homeSettlementValue->state = floatval(str_replace(',', '.', $_data["state_".$count]));
							$homeSettlementValue->price = floatval(str_replace(',', '.', $_data["price_".$count]));
							$homeSettlementValue->amount = floatval(str_replace(',', '.', $_data["amount_".$count]));

							if($homeSettlementValueTable->save($homeSettlementValue)) {
								$successFlag = true;
							} else {
								$successFlag = false;
								break;
							}
						}
					}
				}

				if ($successFlag) {
					$this->Flash->success(__('The settlement has been saved.'));
				} else {
					$this->Flash->error(__('The settlement could not be saved. Please, try again.'));
				}

				return $this->redirect(['action' => 'view', $settlementId]);
			}
		}
		
		$settlementComponentTable = TableRegistry::getTableLocator()->get('HomeSettlementComponent');

		$settlementComponent = $settlementComponentTable->find()->order(['orderby' => 'ASC']);

		$this->set([
			'components' => $settlementComponent->toArray(),
			'request' => $post,
			'settlementId' => $settlementId
		]);
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Settlement id.
	 * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$homeSettlementTable = TableRegistry::getTableLocator()->get('HomeSettlement');
		$homeSettlement = $homeSettlementTable->get($id);

		$homeSettlementComponentTable = TableRegistry::getTableLocator()->get('HomeSettlementComponent');
		$homeSettlementComponent = $homeSettlementComponentTable->find()->order(['orderby' => 'ASC']);

		$homeSettlementValueTable = TableRegistry::getTableLocator()->get('HomeSettlementValue');

		$post = null;
		if ($this->request->is('post')) {

			$_data = $this->request->getData();
			$successFlag = false;

			foreach($_data as $key => $val){
				if(substr($key, 0, 9) == "component") {
					$count = explode("_", $key)[1];

					$post[] = $key;

					if( $_data["component_".$count] != "" && $_data["price_".$count] != "" && $_data["amount_".$count] != "" ) {

						if($_data["valueid_".$count] != "") {

							$homeSettlementValue = $homeSettlementValueTable->get($_data["valueid_".$count]);
							$homeSettlementValue->state = floatval(str_replace(',', '.', $_data["state_".$count]));
							$homeSettlementValue->price = floatval(str_replace(',', '.', $_data["price_".$count]));
							$homeSettlementValue->amount = floatval(str_replace(',', '.', $_data["amount_".$count]));

							if($homeSettlementValueTable->save($homeSettlementValue)) {
								$successFlag = true;
							} else {
								$successFlag = false;
								break;
							}

						} else {

							$homeSettlementValue = $homeSettlementValueTable->newEmptyEntity();
							$homeSettlementValue->settlement_id  = $id;
							$homeSettlementValue->component_id = $_data["component_".$count];
							$homeSettlementValue->state = floatval(str_replace(',', '.', $_data["state_".$count]));
							$homeSettlementValue->price = floatval(str_replace(',', '.', $_data["price_".$count]));
							$homeSettlementValue->amount = floatval(str_replace(',', '.', $_data["amount_".$count]));
							
							if($homeSettlementValueTable->save($homeSettlementValue)) {
								$successFlag = true;
							} else {
								$successFlag = false;
								break;
							}
	
						}
					}
				}
			}

			if ($successFlag) {
				$this->Flash->success(__('The settlement has been saved.'));
			} else {
				$this->Flash->error(__('The settlement could not be saved. Please, try again.'));
			}

			return $this->redirect(['action' => 'view', $id]);
		}

		$homeSettlementValue = $homeSettlementValueTable
			->find()
			->select(['id', 'settlement_id', 'component_id', 'state', 'price', 'amount', 'name' => 'hsc.name', 'description' => 'hsc.description', 'unit' => 'hsc.unit'])
			->join([
				'table' => 'home_settlement_component',
				'alias' => 'hsc',
				'type' => 'LEFT',
				'conditions' => 'hsc.id = HomeSettlementValue.component_id ',
			])
			->where(['HomeSettlementValue.settlement_id =' => $id])
			->order(['hsc.orderby' => 'ASC'])
			->toArray()
		;
		
		/* $homeSettlementValueByComponent = [];
		foreach($homeSettlementValue as $value) {
			$homeSettlementValueByComponent[$value->component_id]['id'] = $value->id;
			$homeSettlementValueByComponent[$value->component_id]['settlement_id'] = $value->settlement_id;
			$homeSettlementValueByComponent[$value->component_id]['component_id'] = $value->component_id;
			$homeSettlementValueByComponent[$value->component_id]['state'] = $value->state;
			$homeSettlementValueByComponent[$value->component_id]['price'] = $value->price;
			$homeSettlementValueByComponent[$value->component_id]['amount'] = $value->amount;
			$homeSettlementValueByComponent[$value->component_id]['name'] = $value->name;
			$homeSettlementValueByComponent[$value->component_id]['description'] = $value->description;
			$homeSettlementValueByComponent[$value->component_id]['unit'] = $value->unit;
		} */

		$usedComponents = [];
		foreach($homeSettlementValue as $value) {
			$usedComponents[] = $value->component_id;
		}

		$this->set([
			'settlementId' => $homeSettlement->id,
			'settlementDate' => $homeSettlement->date->i18nFormat('yyyy-MM-dd'),
			'components' => $homeSettlementComponent->toArray(),
			'values' => $homeSettlementValue,
			//'valbycomp' => $homeSettlementValueByComponent,
			'usedComponents' => $usedComponents,
			'post' => $post
		]);

	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Settlement id.
	 * @return \Cake\Http\Response|null|void Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$settlement = $this->Settlement->get($id);
		if ($this->Settlement->delete($settlement)) {
			$this->Flash->success(__('The settlement has been deleted.'));
		} else {
			$this->Flash->error(__('The settlement could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
