<?php
class SessionController extends \Phalcon\Mvc\Controller
{

	// ...

	private function _registerSession($user)
	{
		$this->session->set('auth', array(
				'user_id' => $user->user_id,
				'user_name' => $user->user_name
		));
	}
	
	public function startAction()
	{
		if ($this->request->isPost()) {

			//Receiving the variables sent by POST
			$username = $this->request->getPost('username');
			$password = $this->request->getPost('password');

			$password = sha1($password);

			//Find the user in the database
			$user = Users::findFirst(array(
					"user_name = :username: AND password = :password: AND active = 1",
					"bind" => array('username' => $username, 'password' => $password)
			));
			if ($user != false) {

				$this->_registerSession($user);

				//Forward to the 'invoices' controller if the user is valid
				return $this->dispatcher->forward(array(
						'controller' => 'admin',
						'action' => 'baoming'
				));
			}
		}

		//Forward to the login form again
		return $this->dispatcher->forward(array(
				'controller' => 'admin',
				'action' => 'index'
		));
	}
	
	public function removeAction()
	{
		if ($this->session->has("auth")) {
			$this->session->remove("auth");
			return $this->dispatcher->forward(array(
					'controller' => 'admin',
					'action' => 'index'
			));
		}
	}

}