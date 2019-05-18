<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use App\Lib\ShellTask;
use Cake\Routing\Router;
use Cake\Network\Exception\MethodNotAllowedException;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Exception\InternalErrorException;

/**
 * Api Controller
 *
 * @property \App\Model\Table\ApiTable $Api
 */
class ApiController extends AppController
{
    public function initialize()
    {
        $this->loadComponent('RequestHandler');
        // $this->loadComponent('Auth', [
        //     // 'authorize' => ['Controller'],
        //     // 'authenticate' => ['Token'],
        //     // 'storage' => 'Memory',
        //     'unauthorizedRedirect' => false
        // ]);

        if (Configure::read('EnableCORS'))
            $this->preflight();

        $this->RequestHandler->renderAs($this, 'json');
    }

    protected function preflight()
    {
        header('Access-Control-Allow-Origin: *');
        if ($this->request->is('options'))
        {
            $this->response->cors($this->request)
                ->allowOrigin(['*'])
                ->allowMethods(['GET, POST, PUT, DELETE'])
                ->allowHeaders([$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']])
                ->build();

            $this->response->send();

            exit(0);
        }
    }

    public function isAuthorized( $user = NULL )
    {
        return true; //any request that successfully authenticates is automatically authorized
    }

   
    public function hello(){
        $success = false;
        $message = 'Failed attempt to retrive information';
        $response = [];
        $this->loadModel('Users');
        if($this->request->is('get')){
            $users = $this->Users->find()->toArray();
            $response = $users;
            pr($users);die;
        }
        $this->set('success', $success);
        $this->set('message', $message);
        $this->set('response', $response);


    }
}
