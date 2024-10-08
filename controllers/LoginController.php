<?php
require_once 'Controller.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class LoginController extends Controller{
    public function login(){
        $this->render('login');
    }

    public function loginSaveForm(){
        $user = new User('users');
        $dbUser = $user->getUserByEmail($_POST['email']);
        if($dbUser != false){
            if(password_verify($_POST['password'], $dbUser['password'])){
                $_SESSION['user_id'] = $dbUser['user_id'];
                $_SESSION['user_role'] = $dbUser['role'];
                if($dbUser['role'] == 1){
                    $this->redirect('home');
                }else if($dbUser['role'] == 2){
                    $this->redirect('home');
                }
            }else{
                $this->render('login', ['error' => 'Data incorrect']);
            }
            
        }else{
            $this->render('login', ['error' => 'Data incorrect']);
        }
    }

    public function loginUsingGoogle(){
        $google_client_id = $_ENV['GOOGLE_CLIENT_ID'];
        $google_client_secret = $_ENV['GOOGLE_CLIENT_SECRET'];
        $google_redirect_url = 'http://localhost/parcNational/google-login';
        //App performs a user browser redirect sending an authorization to google request with this below parameters
        $params = [
            'response_type' => 'code',
            'client_id' => $google_client_id,
            'redirect_uri' => $google_redirect_url,
            'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
            'access_type' => 'offline',
            'prompt' => 'consent'
            //https://accounts.google.com/o/oauth2/auth
        ];
        header('Location: https://accounts.google.com/o/oauth2/auth?' . http_build_query($params));// converts an associative array into a link (a string with GET parameters)
    }

    public function getDataFromGoogle(){
        //phpinfo();
        $google_client_id = $_ENV['GOOGLE_CLIENT_ID'];
        $google_client_secret = $_ENV['GOOGLE_CLIENT_SECRET'];
        $google_redirect_url = 'http://localhost/parcNational/google-login';
        $params = [
            'code' => $_GET['code'],
            'client_id' => $google_client_id,
            'client_secret' => $google_client_secret,
            'redirect_uri' => $google_redirect_url,
            'grant_type' => 'authorization_code'//We tell Google that we want an authorization code
        ];
        //Request configuration
        $curl = curl_init();//Initialises sending the request that allows PHP to communicate with external services using protocols like HTTP or HTTPS
        curl_setopt($curl, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        if ($response === false) {
            $error = curl_error($curl);
            $this->render('login', ['error' => $error]);
            return;
        }
        $responseData = json_decode($response);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v3/userinfo');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $responseData->access_token]);
        $response = curl_exec($curl);
  
        $responseData = json_decode($response);

        $userObject = new User('users');
        $user = $userObject->getByGoogleId($responseData->sub);
        if($user){
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_role'] = $user['role'];
            if($user['role'] != 1){
                $this->redirect('homePageAdmin');
            }else{
                $this->redirect('');
            }
            
        }else{
            $userObject->saveUserFromGoogle($responseData);
            $newUser = $userObject->getByGoogleId($responseData->sub);
            $_SESSION['user_id'] = $newUser['user_id'];
            $this->redirect('');
        }
    }

    public function loginUsingFacebook(){//// This method will be triggered when Facebook redirects back to us
        $facebook_client_id = $_ENV['FACEBOOK_CLIENT_ID'];
        $facebook_client_secret = $_ENV['FACEBOOK_CLIENT_SECRET'];
        $facebook_redirect_url = 'http://localhost/parcNational/facebook-login';

        $params = [
            'code' => $_GET['code'],
            'client_id' => $facebook_client_id,
            'client_secret' => $facebook_client_secret,
            'redirect_uri' => $facebook_redirect_url
        ];

        //Request configuration We retrieve the key to fetch the data
        $curl = curl_init();//Initialises sending the request that allows PHP to communicate with external services using protocols like HTTP or HTTPS
        curl_setopt($curl, CURLOPT_URL, 'https://graph.facebook.com/oauth/access_token');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $responseData = json_decode($response);

        // Data download 
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://graph.facebook.com/me?fields=name,email,picture');//FB documentations link
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $responseData->access_token]);
        $response = curl_exec($curl);
        curl_close($curl);
        $responseData = json_decode($response);

        $userObject = new User('users');
        $user = $userObject->getByFacebookId($responseData->id);
        if($user){
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_role'] = $user['role'];
            if($user['role'] != 1){
                $this->redirect('admin_home');
            }else{
                $this->redirect('home');
            }
        }else{
            $userObject->saveUserFromFacebook($responseData);
            $newUser = $userObject->getByFacebookId($responseData->id);
            $_SESSION['user_id'] = $newUser['user_id'];
            $_SESSION['user_role'] = $newUser['role'];
            $this->redirect('');
        }
    }
    

    public function logout(){
        // Démarrer la session pour accéder aux variables de session
        session_start();

        // Vide toutes les variables de session
        $_SESSION = [];

        // Si un cookie de session existe, le supprimer en le rendant expiré
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Détruire la session
        session_destroy();

        // Rediriger vers la page d'accueil
        $this->redirect('home');
    }
}
