<?php


namespace Project\Controllers;


use Project\Components\ActiveUser;
use Project\Components\Controller;
use Project\Models\UserQuizAttemptModel;
use Project\Repositories\QuizRepository;
use Project\Repositories\UserRepository;
use Project\Services\QuizService;
use Project\Services\UserService;

class IndexController extends Controller
{

    /**
     * @var UserRepository
     * @var QuizRepository
     */
    private UserRepository $userRepository;
    private QuizRepository $quizRepository;
    private QuizService $quizService;

    public function __construct(UserRepository $userRepository = null, QuizRepository $quizRepository = null, QuizService $quizService = null)
    {
        $this->userRepository = $userRepository ?? new UserRepository();
        $this->quizRepository = $quizRepository ?? new QuizRepository();
        $this->quizService = $quizService ?? new QuizService();
    }

    public function index(): string
    {
        return $this->view('index');
    }

    public function dashboard(): ?string
    {
        if(!ActiveUser::isLoggedIn()){
            return $this->redirect('/login');
        }

        return $this->view('dashboard', ['user' => ActiveUser::getUser()]);
    }

    public function myResults(): ?string
    {
        if(!ActiveUser::isLoggedIn()){
            return $this->redirect('/login');
        }
        $quizzesTaken = $this->quizService->getQuizzesAndResultsTakenByUserId(ActiveUser::getUser()->id);

        return $this->view('my-results', ['user' => ActiveUser::getUser(),'quizzesTaken' => $quizzesTaken]);
    }
}