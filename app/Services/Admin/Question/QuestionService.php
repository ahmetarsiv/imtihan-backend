<?php

namespace App\Services\Admin\Question;

use App\Models\Question;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;

class QuestionService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Question::class);
    }

    public function create(object $request): object
    {
        $question = null;
        DB::transaction(function () use ($request, &$question) {
            $question = $this->model::create($request->validated());

            $question->options()->createMany($request->options);

        });
        return $question;
    }

    public function update(object $request, int $id, $where = []): object
    {
        $question = $this->model::findOrFail($id);
        DB::transaction(function () use ($request, $question) {
            $question->update($request->validated());

            $question->options()->delete();

            $question->options()->createMany($request->options);
        });

        return $question;
    }
}
