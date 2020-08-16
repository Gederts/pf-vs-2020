<?php
declare(strict_types=1);

namespace Project\Services;


use Project\Components\Session;
use Project\Exceptions\UserLoginException;
use Project\Exceptions\UserRegistrationValidationException;
use Project\Models\UserModel;
use Project\Repositories\UserRepository;
use Project\Structures\UserLoginItem;
use Project\Structures\UserRegisterItem;

class UserService
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    /**
     * @var Session
     */
    private Session $session;

    public function __construct(UserRepository $userRepository = null, Session $session = null)
    {

        $this->userRepository = $userRepository ?? new UserRepository();
        $this->session = $session ?? Session::getInstance();
    }

    public function signUp(UserRegisterItem $item): UserModel
    {
        //Validejam datus
        //Parbaudam vai lietotajs neeksiste
        $this->validateRegisterItemOrFail($item); //nevajag if jo metode pati metis ara exception

        $user = new UserModel();
        $user->email = $item->email;
        $user->password = password_hash($item->password, PASSWORD_DEFAULT);
        $user->name = $item->name;

        $user = $this->userRepository->saveModel($user);

        $this->session->regenerate();
        $this->session->set(Session::KEY_USER_ID, (int)$user->id);

        return $user;
    }

    /**
     * @param UserRegisterItem $item
     * @throws UserRegistrationValidationException
     */
    public function validateRegisterItemOrFail(UserRegisterItem $item): void
    {
        $errors = [];
        if (!filter_var($item->email, FILTER_VALIDATE_EMAIL)){   //FILTER_VALIDATE_EMAIL ir php builtin funkcija
            $errors[] = 'Please enter a valid email';
        }
        if ($this->userRepository->checkIsEmailRegistered($item->email)) {
            $errors[] = 'User with this email is already registered!';
        }
        if(!$item->password){
            $errors[] = 'Please enter the password';
        }
        elseif(mb_strlen($item->password) < 6 || strlen($item->password) > 72)  {   //password hash atbaalsta max 72 simbolus
          $errors[] = 'Password must be in reasonable length';
        }
        if (!$item->name){
            $errors[] = 'Please enter your name';
        }

        if($errors){
            $exception = new UserRegistrationValidationException();
            $exception->errorMessages = $errors;

            throw $exception;
        }

        //vai lietotajs neeksiste
        //vai ir derigs epasts

        //vai parole nav tukša vai parole nav par īsu vai par garu

        //vai vispar ir ievadits vārds

        //ja ir kaut viens error, exception
    }


    /**
     * @param UserLoginItem $item
     * @throws UserLoginException
     */
    public function signIn(UserLoginItem $item): ?UserModel
    {
       /* $errors = [];

        if(!$item->password || !$item->email){
            $errors[] = 'Incorrect email or password';
        }

        if($errors){
            $exception = new UserLoginException();
            $exception->errorMessages = $errors;

            throw $exception;
        }*/
        // 1. Validācija
        // - parbaudīt vai nav tukši lauki
        // --ja viens vai otrs lauks ir tukšs, meatm exception
        // - meginam dabut lietotaju pec epsata
        // - ja nav lietotaja, metam exception
        // - Pārbaudam vai parole lietotajam ir pareiza (ar password_verify)
        // - ja parole nav pareiza, metam exception
        // - exception: oops your email or password is incorrect

        // - reģenerējam sesijas id
        //2. ieliekam sesijā aktīvā usera id





        if($item->email && $item->password){
            $user = $this->userRepository->getUserByEmail($item->email);
            if(password_verify($item->password, $user->password)){
                $this->session->regenerate();
                $this->session->set(Session::KEY_USER_ID, (int)$user->id);
                return $user;
            }

        }
        throw new UserLoginException();
        return null;

    }

    public function signOut(): void //glabasies sesijaa
    {
        $this->session->destroy();
    }
}