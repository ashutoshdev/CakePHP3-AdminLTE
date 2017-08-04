<?php

namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Error\Debugger;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;

/**
 * AssoProducts Controller
 *
 * @property \App\Model\Table\AssoProductsTable $AssoProducts
 */
class AssoProductsController extends AppController
{



 public function beforeFilter(Event $event) {
        $this->Auth->allow(['view']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['AssoCategories']
        ];
        $assoProducts = $this->paginate($this->AssoProducts);

        $this->set(compact('assoProducts'));
        $this->set('_serialize', ['assoProducts']);
    }

    /**
     * View method
     *
     * @param string|null $id Asso Product id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        Configure::write("debug", 2);
        $data = $this->CrOrgn();
        $this->filewrite($data);
        $pid=$data->pid;//=40;
        if($data)
        {
		$this->loadModel('Products');
	        $product=$this->Products->find('all',['conditions'=>['Products.id'=>$pid]]);
                if($product)
                {
		        $assoid=$product->first()->assopro_id;
		        $assoid=unserialize($assoid);
		        $assoprod=$this->AssoProducts->find('all',['contain'=>['AssoCategories']])->where(['AssoProducts.id IN'=>$assoid]);
                        $p['asso']=$assoprod;
		        $alergy=$product->first()->alergy_id;
		        $alergy=unserialize($alergy);
		        $this->loadModel('Alergies');
		        $p['alergy']=$this->Alergies->find('all')->where(['Alergies.id IN'=>$alergy]);        
                }
        }
        $this->set('Assoproduct', $p);
        $this->set('_serialize', ['Assoproduct']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $assoProduct = $this->AssoProducts->newEntity();
        if ($this->request->is('post')) {
            $assoProduct = $this->AssoProducts->patchEntity($assoProduct, $this->request->data);
            if ($this->AssoProducts->save($assoProduct)) {
                $this->Flash->success(__('The asso product has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The asso product could not be saved. Please, try again.'));
            }
        }
        $assoCategories = $this->AssoProducts->AssoCategories->find('list', ['limit' => 200]);
        $this->set(compact('assoProduct', 'assoCategories'));
        $this->set('_serialize', ['assoProduct']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Asso Product id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $assoProduct = $this->AssoProducts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $assoProduct = $this->AssoProducts->patchEntity($assoProduct, $this->request->data);
            if ($this->AssoProducts->save($assoProduct)) {
                $this->Flash->success(__('The asso product has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The asso product could not be saved. Please, try again.'));
            }
        }
        $assoCategories = $this->AssoProducts->AssoCategories->find('list', ['limit' => 200]);
        $this->set(compact('assoProduct', 'assoCategories'));
        $this->set('_serialize', ['assoProduct']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Asso Product id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $assoProduct = $this->AssoProducts->get($id);
        if ($this->AssoProducts->delete($assoProduct)) {
            $this->Flash->success(__('The asso product has been deleted.'));
        } else {
            $this->Flash->error(__('The asso product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
