<?php


namespace Project\Controllers;


use Project\Components\ActiveUser;
use Project\Components\Controller;
use Project\Components\Session;
use Project\Exceptions\AdminValidationException;
use Project\Exceptions\Http\HttpForbiddenException;
use Project\Models\UserModel;
use Project\Repositories\QuizRepository;
use Project\Repositories\UserRepository;
use Project\Services\UserService;

class AdminController extends Controller
{
    /**
     * @var UserRepository
     * @var QuizRepository
     */
    private UserRepository $userRepository;
    private QuizRepository $quizRepository;
    private UserService $userService;

    public function __construct(UserRepository $userRepository = null, QuizRepository $quizRepository = null, UserService $userService = null)
    {
        $this->userRepository = $userRepository ?? new UserRepository();
        $this->quizRepository = $quizRepository ?? new QuizRepository();
        $this->userService = $userService ?? new UserService();
    }
    /**
     * @return string|null
     * @throws HttpForbiddenException
     */
    public function index(): ?string
    {
        if (!ActiveUser::getUser()->is_admin) {
            throw new HttpForbiddenException();
        }
        $users = $this->userRepository->getAll();
        $quizzes = $this->quizRepository->getAll();
        return $this->view('admin/index', ['users' => $users, 'quizzes' => $quizzes]);
    }
    /**
     * @return string|null
     * @throws HttpForbiddenException
     */
    public function viewUser(): ?string
    {
        if (!ActiveUser::getUser()->is_admin) {
            throw new HttpForbiddenException();
        }
        $id = (int)($_GET['id'] ?? null);
        if (!$id) {
            Session::getInstance()->setErrorMessage("User ID missing");
            return $this->redirect('/admin');
        }
        // TODO: Pārcelt uz a tbilstošu UserRepository metodi
        $user = $this->userRepository->getUserById($id);
        return $this->view('admin/view-user', ['user' => $user]);
    }
//  mēģināju ieviest parametrus caur routes, bet tas nebija vislabākais variants
//    public function deleteUser($id): ?string
//    {
//        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
//            return $this->redirect('/');
//        }
//        if (!ActiveUser::getUser()->is_admin) {
//            return $this->redirect('/dashboard');
//        }
//        $this->userRepository->deleteUser($id);
//        return $this->redirect('/admin');
//    }
//
//    public function editUser($id): ?string
//    {
//        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
//            return $this->redirect('/');
//        }
//        if (!ActiveUser::getUser()->is_admin) {
//            return $this->redirect('/dashboard');
//        }
//        $this->userRepository->changeUserPrivilege($id);
//        return $this->redirect('/admin');
//    }
    public function toggleUserAdmin(): ?string
    {
        if (!ActiveUser::getUser()->is_admin) {
            throw new HttpForbiddenException();
        }
        $id = (int)($_POST['id'] ?? null);
        // TODO: Pārcelt visu no [start] līdz [end] uz servisu.
        // TODO: Visam starp start un end vajadzētu būt try catch blokā
        // TODO: Repozitoriju loģiku (kur ir vaicājums lietotāja atrašanai vai izmaiņas lietotāja modelim) pārcelt uz UserRepository::getUserById, UserRepository::saveModel un izsaukt caur servisu
        // TODO: Ja ir kāds errors (piem. userId === id), metam AdminException ar ziņu iekšā
        // TODO: Tad kļūdas ziņojumu iestatam sesijā caur kontrolieri
        // TODO: Citādāk (ja viss ok), izvadam success message arī caur sesiju un taisam redirect atpakaļ
        // TODO: [start]
        try {
            $this->userService->makeAdmin($id, ActiveUser::getUser()->id);

        } catch (AdminValidationException $exception) {
            Session::getInstance()->setErrorMessage($exception->getMessage());
        }

        // TODO: [end]
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
    /**
     * @return string|null
     * @throws HttpForbiddenException
     */

    public function deleteUser(): ?string
    {
        if (!ActiveUser::getUser()->is_admin) {
            throw new HttpForbiddenException();
        }
        $id = (int)($_POST['id'] ?? null);
        // TODO: Pārcelt visu no [start] līdz [end] uz servisu.
        // TODO: Visam starp start un end vajadzētu būt try catch blokā
        // TODO: Repozitoriju loģiku (kur ir vaicājums lietotāja atrašanai vai izmaiņas lietotāja modelim) pārcelt uz UserRepository::getUserById, UserRepository::saveModel un izsaukt caur servisu
        // TODO: Ja ir kāds errors (piem. userId === id), metam AdminException ar ziņu iekšā
        // TODO: Tad kļūdas ziņojumu iestatam sesijā caur kontrolieri
        // TODO: Citādāk (ja viss ok), izvadam success message arī caur sesiju un taisam redirect atpakaļ
        // TODO: [start]
        try {
            $this->userService->deleteUser($id, ActiveUser::getUser()->id);
        } catch (AdminValidationException $exception) {
            Session::getInstance()->setErrorMessage($exception->getMessage());
        }

        // TODO: [end]
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function viewQuiz()
    {
        if (!ActiveUser::getUser()->is_admin) {
            throw new HttpForbiddenException();
        }
        $id = (int)($_GET['id'] ?? null);
        if (!$id) {
            Session::getInstance()->setErrorMessage("User ID missing");
            return $this->redirect('/admin');
        }

        $quiz = $this->quizRepository->getQuizById($id);
        $questions = $this->quizRepository->getQuestionsByQuizId($id);
        $correctAnswers = $this->quizRepository->getCorrectAnswersByQuizId($id);

        return $this->view('admin/view-quiz', ['quiz' => $quiz, 'questions' => $questions, 'correctAnswers' => $correctAnswers]);
    }
}