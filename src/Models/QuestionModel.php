<?php


namespace Project\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $quiz_id
 * @property string $title
 *
 * @property AnswerModel[] $answers
 */
class QuestionModel extends Model
{
    protected $table = 'questions';
    public $timestamps = false;
    protected $guarded = [];


    public function quiz(): BelongsTo
    {
        return $this->belongsTo(QuizModel::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(AnswerModel::class, 'question_id', 'id');
    }

    public function userAnswers()
    {
        return $this->hasMany(UserQuizAttemptAnswerModel::class, 'question_id', 'id');
    }
}