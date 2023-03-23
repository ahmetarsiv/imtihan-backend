<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = 0;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'is_image_option',
        'src',
        'language_id',
    ];

    /**
     * Get the category that owns the Question
     *
     * @return HasOne
     */
    public function category(): HasOne
    {
        return $this->hasOne(QuestionCategory::class, 'id', 'category_id');
    }

    /**
     * Get the language that owns the Question
     *
     * @return HasOne
     */
    public function language(): HasOne
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }

    /**
     * Get all the options for the Question
     *
     * @return HasMany
     */
    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class, 'question_id', 'id');
    }
}
