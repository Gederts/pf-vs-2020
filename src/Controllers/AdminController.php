<?php


namespace Project\Controllers;


use Project\Components\ActiveUser;
use Project\Components\Controller;
use Project\Repositories\QuizRepository;
use Project\Repositories\UserRepository;

class AdminController extends Controller
{
    /**
     * @var UserRepository
     * @var QuizRepository
     */
    private UserRepository $userRepository;
    private QuizRepository $quizRepository;

    public function __construct(UserRepository $userRepository = null, QuizRepository $quizRepository = null)
    {
        $this->userRepository = $userRepository ?? new UserRepository();
        $this->quizRepository = $quizRepository ?? new QuizRepository();
    }
    public function index(): ?string
    {
        if (!ActiveUser::getUser()->is_admin) {
            return $this->redirect('/dashboard');
        }
        $users = $this->userRepository->getAll();
        $quizzes = $this->quizRepository->getAll();
        return $this->view('admin/index', ['users' => $users, 'quizzes' => $quizzes]);
    }

    public function deleteUser($id): ?string
    {
        if (!ActiveUser::getUser()->is_admin) {
            return $this->redirect('/dashboard');
        }
        $this->userRepository->deleteUser($id);
        return $this->redirect('/admin');

    }
}