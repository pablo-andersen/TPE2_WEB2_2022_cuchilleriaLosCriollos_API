 <?php

 require_once 'app/views/loginView.php';
 require_once 'app/models/userModel.php';
 require_once 'app/helpers/AuthHelper.php';
 require_once 'app/views/homeView.php';

 class LoginApiController {
    private $userModel;
    private $homeView;
    private $loginView;
    private $authHelper;

    function __construct(){
        $this->userModel = new UserModel();
        $this->loginView = new LoginView();
        $this->homeView = new HomeView();
        $this->authHelper = new AuthHelper();
    }

    function showLogin(){
        $admin = $this->authHelper->checkLoggedIn();
        $this->loginView->showLogin($admin);
    }

    function logout(){
        $admin = $this->authHelper->checkLoggedIn();
        if ($admin) {
            $this->authHelper->logout();
            $this->loginView->showLogin('El usuario ha sido deslogueado correctamente.');
        }
    }

    function verifyLogin(){
        if(!empty($_POST['email']) && !empty($_POST['password'])){
            $email = $_POST['email'];
            $password = $_POST['password'];

            //Se obtiene el user de la DB
            $user = $this->userModel->getUser($email);

            //Se verifica que el usuario existe en DB y la contaseña coincide
            if($user && password_verify($password, $user->password)){
                session_start();
                $_SESSION['email']=$email;
                $admin= true;
                $this->homeView->showHome($admin, $_SESSION['email']);
            }
            else {
                $admin = false;
                $this->loginView->showLogin($admin,'Acceso denegado');
            }
        }
    }
 }