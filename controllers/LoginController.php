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
        var_dump($_POST);
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
        var_dump($response);
        $responseData = json_decode($response);
        var_dump($responseData);

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
    public function loginUsingFacebook(){//ta metoda ie uruchomi kiedy fb przekieruje nas spowrotem do nas
        $facebook_client_id = '3791602837821452';
        $facebook_client_secret = '8a4de4f4eff05528f18801e6bdb75e76';
        $facebook_redirect_url = 'http://localhost/parcNational/facebook-login';

        $params = [
            'code' => $_GET['code'],
            'client_id' => $facebook_client_id,
            'client_secret' => $facebook_client_secret,
            'redirect_uri' => $facebook_redirect_url
        ];
        //Request configuration PObieramy klucz do pobrania danych
        $curl = curl_init();//Initialises sending the request that allows PHP to communicate with external services using protocols like HTTP or HTTPS
        curl_setopt($curl, CURLOPT_URL, 'https://graph.facebook.com/oauth/access_token');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $responseData = json_decode($response);
        // Pobranie danych 
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://graph.facebook.com/me?fields=name,email,picture');//sciezka z dokumentacji fb
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $responseData->access_token]);
        $response = curl_exec($curl);
        curl_close($curl);
        $responseData = json_decode($response);
        var_dump($responseData);


        $userObject = new User('users');
        $user = $userObject->getByFacebookId($responseData->id);
        if($user){
            $_SESSION['id'] = $user['user_id'];
            $_SESSION['user_role'] = $user['role'];
            if($user['user_role'] != 1){
                $this->redirect('homePageAdmin');
            }else{
                $this->redirect('');
            }
        }else{

            $userObject->saveUserFromFacebook($responseData);
            $newUser = $userObject->getByFacebookId($responseData->id);
            $_SESSION['id'] = $newUser['user_id'];
            $_SESSION['user_role'] = $newUser['role'];
            $this->redirect('');
        }

    }
    
    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_role']);
        $this->redirect('');
    }
}
//National Parc
//http://localhost/parcNational/facebook-login---Valid OAuth Redirect URI musi być bardziej specyficzny i powinien zawierać pełny adres endpointu obsługującego logowanie
//http://localhost redirects are automatically allowed while in development mode only and do not need to be added here.

//http://localhost/parcNational/ --- Ten adres będzie używany jako główny URL Twojej aplikacji i może być wykorzystany przez Facebooka do różnych celów, np. podczas weryfikacji Twojej aplikacji czy przy integracji innych funkcji.
//AppleId : 3791602837821452
//App secret : 8a4de4f4eff05528f18801e6bdb75e76