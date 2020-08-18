<?php


namespace Project\Controllers;


use Project\Components\ActiveUser;
use Project\Components\Controller;
use Project\Exceptions\UserLoginException;
use Project\Exceptions\UserRegistrationValidationException;
use Project\Services\UserService;
use Project\Structures\UserLoginItem;
use Project\Structures\UserRegisterItem;

class AuthController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService = null)
    {
        $this->userService = $userService ?? new UserService();
    }

    public function login(): ?string
    {
        if(ActiveUser::isLoggedIn()){
            return $this->redirect('/dashboard');
        }
        $loginItem = UserLoginItem::fromArray($_POST);
        $error = '';
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            try {
                $this->userService->signIn($loginItem);
                return $this->redirect('/dashboard');
            }catch (UserLoginException $exception){
                $error = "Credentials don't match our records!";
            }


        }
        return $this->view('login', ['loginItem' => $loginItem, 'error'=>$error]);
    }

    public function register(): ?string //atgriež string vai null (gadijuma ja notiek redirects)
    {
        if(ActiveUser::isLoggedIn()){
            return $this->redirect('/dashboard');   //redirect atgriež null
        }
        $registerItem = UserRegisterItem::fromarray($_POST);
        $errors = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            try {
                $this->userService->signUp($registerItem);

                return $this->redirect('/');
            }   catch(UserRegistrationValidationException $exception){
                   $errors = $exception->errorMessages;
            }
        }
        return $this->view('register', ['registerItem' => $registerItem, 'errors'=>$errors]);
    }

    public function logout(): ?string
    {
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){  //neļaus izlogoties ja nav post metode
            return $this->redirect('/');
        }
        if(!ActiveUser::isLoggedIn()){
            return $this->redirect('/login');
        }

        $this->userService->signOut();


        return $this->redirect('/');
    }
}