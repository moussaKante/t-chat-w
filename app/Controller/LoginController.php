<?php 

namespace Controller;

use \W\Controller\Controller;
use \W\Security\AuthentificationModel;
use \W\Model\UsersModel;

class LoginController extends \W\Controller\Controller{

	public function form() {
		var_dump('hello xdebug');
		// si un post a bien ete envoyer, on effectue le traitement du formulaire 

		//je créer un tableau d'erreur
		$errors = array();

		//var_dump('Contenu de $_POST',$_POST);
		if ( $_POST) {
			// on verifie du'un pseudo et un mot de passe ont bien ete saisi
			if(empty($_POST['pseudo']) ){
				$errors['pseudo'] = 'Vous devez renseigner un pseudo';
			}

			if(empty($_POST['mot_de_passe']) ){
				$errors['mot_de_passe'] = 'Vous devez renseigner un mot de passe';
			}
			//var_dump('contenu de $error',$errors);
			$auth = new AuthentificationModel();

			//on fait appel à isValidLoginInfo qui va verifier que la combinaison
			// pseudo/mdp entre par lutilisateur est bien en base de donne
			$pseudo = ! empty($_POST['pseudo']) ? $_POST['pseudo'] : '';
			$motDePasse = ! empty($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : '';
			$userId = $auth->isValidLoginInfo($pseudo,$motDePasse);

			//var_dump($userId);
			//var_dump($motDePasse);


			if ($userId === 0) {
				$errors['pseudo/motdepasse'] = 'Les informations de connexions entrées sont incorrectes';
			}

			if (empty($errors)) {
				//var_dump('contenu de $error',$errors);
				$usersModel = new UsersModel();
				$userInfos = $usersModel->find($userId);
				//var_dump('information : ',$userInfos);
				$auth->logUserIn($userInfos);

				$this->redirectToRoute('default_home');
			}
		}
		$this->show('login/form',array('errors'=>$errors));
	}
}