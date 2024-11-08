<?php //To make the test happen, the 'protected function' should be replaced with the 'public function', 'exit;' should be remove. 

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../controllers/Controller.php';

class ControllerTest extends TestCase {
    private $controller;
    //Standard function 'setup' to prepare the test envirenement, 'void' indicates that the function doesn't return any value.
    protected function setUp(): void {
        //By mocking an object of the Controller class we can simulate its behavior, which help to 
        //focus just on the specific part of the function without redirect action.
        $this->controller = $this->getMockBuilder(Controller::class)
                                 ->onlyMethods(['redirect'])// Only the 'redirect' method will be mocked.
                                 ->getMock();
    }

    public function testCheckAdmin_RedirectsWhenNotLoggedIn() {
        //The session and role of the user are ignored
        unset($_SESSION['user_id']);
        $_SESSION['user_role'] = null;
        //Checking if the method redirect was called exactly once and if the method had the argument 'login'
        $this->controller->expects($this->once())
                         ->method('redirect')
                         ->with('login');
        //Here method checkAdmin is starting to play
        $this->controller->checkAdmin();
    }

    public function testCheckAdmin_RedirectsWhenNotAdmin() {
        $_SESSION['user_id'] = 1; 
        $_SESSION['user_role'] = 1; 
        $this->controller->expects($this->once())
                         ->method('redirect')
                         ->with('login');
        $this->controller->checkAdmin();
    }

    public function testCheckAdmin_AllowsAccessForAdmin() {
        $_SESSION['user_id'] = 1; // User is connected
        $_SESSION['user_role'] = 2; // User is an Admin
        // We are expecting that 'redirect' is not going to be called.
        $this->controller->expects($this->never())
                         ->method('redirect');
        $this->controller->checkAdmin();
    }
}
