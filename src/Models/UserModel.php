<?php

namespace Project\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $email
 * @property string $name
 */
class QuestionModel extends Model
{
    protected $table = 'users';
    public $timestamps = false;
    protected $guarded = [];

    public function quizAttempts(): HasMany
    {
        return $this->hasMany(UserQuizAttemptModel::class, 'user_id', 'id');
    }

}