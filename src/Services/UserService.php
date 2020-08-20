<?php
declare(strict_types=1);

namespace Project\Services;


use Project\Components\Session;
use Project\Exceptions\AdminValidationException;
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
        if (!filter_var($item->email, FILTER_VALIDATE_EMAIL)) {   //FILTER_VALIDATE_EMAIL ir php builtin funkcija
            $errors[] = 'Please enter a valid email';
        }
        if ($this->userRepository->checkIsEmailRegistered($item->email)) {
            $errors[] = 'User with this email is already registered!';
        }
        if (!$item->password) {
            $errors[] = 'Please enter the password';
        } elseif (mb_strlen($item->password) < 6 || strlen($item->password) > 72) {   //password hash atbaalsta max 72 simbolus
            $errors[] = 'Password must be in reasonable length';
        }
        if (!$item->name) {
            $errors[] = 'Please enter your name';
        }

        if ($errors) {
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
     * @param UserLoginItem $loginItem
     * @return UserModel
     * @throws UserLoginException
     */
    public function signIn(UserLoginItem $loginItem): UserModel
    {
        if (!$loginItem->email || !$loginItem->password) {
            throw new UserLoginException();
        }
        $user = $this->userRepository->getUserByEmail($loginItem->email);
        if (!$user) {
            throw new UserLoginException();
        }
        if (!password_verify($loginItem->password, $user->password)) {
            throw new UserLoginException();
        }
        $this->session->regenerate();
        $this->session->set(Session::KEY_USER_ID, (int)$user->id);
        return $user;
    }

    public function signOut(): void //glabasies sesijaa
    {
        $this->session->destroy();
    }

    public function makeAdmin(int $id, int $activeUserId): void
    {
        if ($activeUserId === $id) {
            Session::getInstance()->setErrorMessage("You can't toggle your own admin status!");
        } else {
            /** @var UserModel $user */
            $user = $this->userRepository->getUserById($id);
            if (!$user) {
                Session::getInstance()->setErrorMessage("User not found");
            } else if ($user->email === null) {
                Session::getInstance()->setErrorMessage("This user has been deleted");
            } else {
                $user->is_admin = !$user->is_admin;
                $this->userRepository->saveModel($user);
                Session::getInstance()->setSuccessMessage("Admin status successfully toggled");
            }
        }
    }

    public function deleteUser(int $id, int $activeUserId): void
    {
        if ($activeUserId === $id) {
            Session::getInstance()->setErrorMessage("You can't delete yourself!");
        }
        /** @var UserModel $user */
        $user = $this->userRepository->getUserById($id);
        if (!$user) {
            Session::getInstance()->setErrorMessage("User not found");
        } else if ($user->email === null && $user->$id === null) {
            Session::getInstance()->setErrorMessage("User has already been deleted");
        } else {
            $user->email = null;
            $user->password = null;
            $user->is_admin = null;
            $user->name = 'Former user';
            $this->userRepository->saveModel($user);
            Session::getInstance()->setSuccessMessage("User successfully deleted");
        }
    }

}