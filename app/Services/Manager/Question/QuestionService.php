<?php

namespace App\Services\Manager\Question;

use App\Helper\Helper;
use App\Models\Question;
use App\Models\QuestionBug;
use App\Models\QuestionByCompany;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;

class QuestionService extends BaseService
{
    public function __construct()
    {
        parent::__construct(QuestionByCompany::class);
    }

    public function show($id, $with = [], $where = []): mixed
    {
        return $this->model::with($with)->where($where)->whereQuestionId($id)->firstOrFail();
    }

    public function create(object $request): object
    {
        $question = null;
        DB::transaction(function () use ($request, &$question) {
            $question = Question::create($request->validated());
            $question->options()->createMany($request->options);

            $this->model::create([
                'question_id' => $question->id,
                'company_id' => Helper::userInfo()->company_id,
            ]);
        });

        return $question;
    }

    public function update(object $request, int $id, $where = []): object
    {
        $question = $this->model::whereQuestionId($id)->firstOrFail();
        DB::transaction(function () use ($request, $question) {
            $question->question->update($request->validated());
            $question->question->options()->delete();
            $question->question->options()->createMany($request->options);
        });

        return $question;
    }

    public function destroy(int $id, $where = []): object
    {
        $question = $this->model::whereQuestionId($id)->firstOrFail();
        DB::transaction(function () use ($question) {
            $question->question->options()->delete();
            $question->question->delete();
            $question->delete();
        });

        return $question;
    }

    public function getBugList()
    {
        $companyQuestionIds = $this->model::whereCompanyId(Helper::userInfo()->company_id)->pluck('question_id');

        return QuestionBug::whereIn('question_id', $companyQuestionIds)->with('question')->latest()->get();
    }

    public function destroyBug($id)
    {
        return QuestionBug::findOrFail($id)->delete();
    }
}
