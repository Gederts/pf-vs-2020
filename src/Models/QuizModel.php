<?php

namespace Project\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 */
class QuizModel extends Model
{
    protected $table = 'quizzes';
    public $timestamps = false;
    protected $guarded = [];

    public function questions(): HasMany
    {
        return $this->hasMany(QuestionModel::class, 'quiz_id', 'id');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(UserQuizAttemptAnswerModel::class, 'quiz_id', 'id');
    }

}