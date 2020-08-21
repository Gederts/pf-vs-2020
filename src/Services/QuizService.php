<?php
declare(strict_types=1);

namespace Project\Services;


use Exception;
use Project\Components\Session;
use Project\Models\QuestionModel;
use Project\Models\QuizModel;
use Project\Models\UserQuizAttemptAnswerModel;
use Project\Models\UserQuizAttemptModel;
use Project\Repositories\AnswerRepository;
use Project\Repositories\QuestionRepository;
use Project\Repositories\QuizRepository;
use Project\Repositories\UserQuizAttemptAnswerRepository;
use Project\Repositories\UserQuizAttemptRepository;
use Project\Structures\AnswerStructure;
use Project\Structures\QuestionStructure;
use Project\Structures\QuizStructure;

class QuizService
{
    private QuizRepository $quizRepository;
    private UserQuizAttemptRepository $userQuizAttemptRepository;
    private QuestionRepository $questionRepository;
    private AnswerRepository $answerRepository;
    private UserQuizAttemptAnswerRepository $userQuizAttemptAnswerRepository;
    private Session $session;

    public function __construct(
        QuizRepository $quizRepository = null,
        UserQuizAttemptRepository $userQuizAttemptRepository = null,
        QuestionRepository $questionRepository = null,
        AnswerRepository $answerRepository = null,
        UserQuizAttemptAnswerRepository $attemptAnswerRepository = null,
        Session $session = null
    )
    {
        $this->quizRepository = $quizRepository ?? new QuizRepository();
        $this->userQuizAttemptRepository = $userQuizAttemptRepository ?? new UserQuizAttemptRepository();
        $this->questionRepository = $questionRepository ?? new QuestionRepository();
        $this->answerRepository = $answerRepository ?? new AnswerRepository();
        $this->userQuizAttemptAnswerRepository = $attemptAnswerRepository ?? new UserQuizAttemptAnswerRepository();
        $this->session = $session ?? new Session();
    }


    public function getQuizDataStructures(): array
    {
        $quizModels = $this->quizRepository->getAll();
        $quizStructures = [];
        foreach ($quizModels as $quizModel) {
            $quizStructure = new QuizStructure();
            $quizStructure->id = $quizModel->id;
            $quizStructure->name = $quizModel->name;
            $quizStructure->questionCount = count($quizModel->questions);
            $quizStructures[] = $quizStructure;
        }

        return $quizStructures;

    }

    public function addQuiz(string $name): QuizModel
    {
        //TODO implement
        $quiz = new QuizModel();
        $quiz->name = $name;
        return $quiz;
    }

    public function startQuiz(int $activeUserId, int $quizId): void
    {
        $quiz = $this->quizRepository->getQuizById($quizId);
        if (!$quiz) {
            throw new \Exception("Quiz not found");
        }
        $attempt = new UserQuizAttemptModel();
        $attempt->user_id = $activeUserId;
        $attempt->quiz_id = $quizId;

        $attempt = $this->userQuizAttemptRepository->saveModel($attempt);
        $this->session->set(Session::KEY_CURRENT_ATTEMPT_ID, $attempt->id);
        $this->session->set(Session::KEY_QUESTIONS_ANSWERED, 0);
    }

    public function getNextQuestionStructure(): ?QuestionStructure //? jo nevienmer varetu but nakamais jautajums
    {
        $attemptId = $this->session->get(Session::KEY_CURRENT_ATTEMPT_ID);
        $attempt = $this->userQuizAttemptRepository->getById($attemptId);

        $quizId = $attempt->quiz_id;
        $questionsAnswered = $this->session->get(Session::KEY_QUESTIONS_ANSWERED);

        $questionModel = $this->questionRepository->getByQuizIdAndOffset($quizId, $questionsAnswered);
        if (!$questionModel) {
            return null;
        }
        $questionStructure = new QuestionStructure();
        $questionStructure->id = $questionModel->id;
        $questionStructure->quizId = $questionModel->quiz_id;
        $questionStructure->title = $questionModel->title;
        $questionStructure->answers = $this->getAnswerStructuresFromQuestion($questionModel);

        return $questionStructure;
    }

    private function getAnswerStructuresFromQuestion(QuestionModel $questionModel): array
    {
        $answerStructures = [];
        foreach ($questionModel->answers as $answeModel) {
            $answerStructure = new AnswerStructure();
            $answerStructure->id = $answeModel->id;
            $answerStructure->questionId = $answeModel->question_id;
            $answerStructure->title = $answeModel->title;
            $answerStructures[] = $answerStructure;
        }
        return $answerStructures;
    }

    public function isLastQuestion(): bool
    {
        $attemptId = $this->session->get(Session::KEY_CURRENT_ATTEMPT_ID);
        $questionsAnswered = $this->session->get(Session::KEY_QUESTIONS_ANSWERED);
        $attempt = $this->userQuizAttemptRepository->getById($attemptId);
        // 3 jautajumi
        // esam atbildejusi uz 2, questionsAnswered = 2
        // 2+1 >= 3
        return ($questionsAnswered + 1) >= count($attempt->quiz->questions);

    }

    public function saveAnswer(int $answerId): void
    {
        $attemptId = $this->session->get(Session::KEY_CURRENT_ATTEMPT_ID);
        $attempt = $this->userQuizAttemptRepository->getById($attemptId);
        $answerModel = $this->answerRepository->getById($answerId);
        if (!$answerModel) {
            throw new Exception("Answer not found!");
        }
        if ($attempt->quiz->id !== $answerModel->question->quiz->id) {
            throw new Exception("Answer from another quiz");
        }
        $attemptAnswerModel = new UserQuizAttemptAnswerModel();
        $attemptAnswerModel->attempt_id = $attempt->id;
        $attemptAnswerModel->question_id = $answerModel->question_id;
        $attemptAnswerModel->answer_id = $answerModel->id;
        $this->userQuizAttemptAnswerRepository->saveModel($attemptAnswerModel);
        $questionsAnswered = $this->session->get(Session::KEY_QUESTIONS_ANSWERED);
        $questionsAnswered++;
        $this->session->set(Session::KEY_QUESTIONS_ANSWERED, $questionsAnswered);
    }

    public function getResults(): array
    {
        $attemptId = $this->session->get(Session::KEY_CURRENT_ATTEMPT_ID);
        $attempt = $this->userQuizAttemptRepository->getById($attemptId);
        $completedQuiz = $attempt->quiz;
        $totalQuestionCount = count($completedQuiz->questions);
        $correctAnswerCount = 0;
        $userAnswers = $attempt->userAnswers;
        foreach ($userAnswers as $userAnswer) {
            $correctAnswerCount += $userAnswer->answer->is_correct;
        }
        $this->session->unset(Session::KEY_CURRENT_ATTEMPT_ID);
        $this->session->unset(Session::KEY_QUESTIONS_ANSWERED);
        return [$correctAnswerCount, $totalQuestionCount];
    }

    public function getQuizzesAndResultsTakenByUserId(int $userId): array//?UserQuizAttemptModel
    {
        $quizzesTakenModel = UserQuizAttemptModel::query()->where('user_id', '=', $userId)->get();
        $someArray = [];
        foreach ($quizzesTakenModel as $quizTaken) {
            $someArray[] = $quizTaken;
        }

        $attemptArray = [];
        $someArray2 = [];
        foreach ($someArray as $itemModel) {
            $someArray2 [] = $itemModel->quiz_id;
            $attemptArray [] = $this->userQuizAttemptRepository->getById($itemModel->id);
        }   //$someArray2 atrodas masīvas ar visiem attempt id no attiecīgā user


        $completedQuizzesArray = [];
        foreach ($attemptArray as $attempt){
            $completedQuizzesArray [] = $attempt->quiz;
        }


        $totalQuestionCountArray = [];

        foreach ($completedQuizzesArray as $completedQuiz){
            $totalQuestionCountArray [] = count($completedQuiz->questions);

        }

        $userAnswersArray = [];

        foreach ($attemptArray as $attempt){
            $userAnswersArray [] = $attempt->userAnswers;

        }


        $correctAnswerCountArray = [];
        $i=0;
        foreach ($userAnswersArray as $userAnswerArray) {
            foreach ($userAnswerArray as $userAnswer) {
                $correctAnswerCountArray [$i] += $userAnswer->answer->is_correct;
            }
            $i++;
        }


        $quizStartedArray = [];
        foreach ($attemptArray as $attemptStart){
            $quizStartedArray [] = $attemptStart->started_at;
        }
        $quizModels = QuizModel::all()->all();
        $quizArrayModels = [];
        foreach ($someArray2 as $idFromQuiz) {
            foreach ($quizModels as $quizModel) {
                if($idFromQuiz == $quizModel->id) {
                    $quizArrayModels [] =  $quizModel;
                }
            }
        }

        $someArray = [];    //dont need someArray anymore
        foreach ($quizArrayModels as $quizArray){
            $someArray [] = $quizArray->name;
        }
        return array($someArray, $quizStartedArray, $totalQuestionCountArray, $correctAnswerCountArray);
    }

    public function getQuestionCount(int $quizId): int
    {
        $count = 0;
        $questionModels = QuestionModel::query()->where('quiz_id', '=', $quizId)->get();
        foreach ($questionModels as $questionModel){
            $count+=1;
        }
        return $count;
    }

}