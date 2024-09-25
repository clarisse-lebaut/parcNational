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
                    $this->redirect('');
                }else if($dbUser['role'] == 2){
                    $this->redirect('homePageAdmin');
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
            'redirect_url' => $google_redirect_url,
            'grant_type' => 'authorization_code'//We tell Google that we want an authorization code
        ];
        //Request configuration
        $curl = curl_init();//Initialises sending the request that allows PHP to communicate with external services using protocols like HTTP or HTTPS
        curl_setopt($curl, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        var_dump(curl_error($curl));
        curl_close($curl);
       

    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_role']);
        $this->redirect('');
    }
}

