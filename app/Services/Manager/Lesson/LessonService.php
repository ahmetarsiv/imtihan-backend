<?php

namespace App\Services\Manager\Lesson;

use App\Helper\Helper;
use App\Models\Lesson;
use App\Models\LessonByCompany;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;

class LessonService extends BaseService
{
    public function __construct()
    {
        parent::__construct(LessonByCompany::class);
    }

    public function show(int $id, $with = [], $where = []): object
    {
        return $this->model::with($with)->where($where)->whereLessonId($id)->firstOrFail();
    }

    public function create(object $request): object
    {
        $lesson = null;
        DB::transaction(function () use ($request, &$lesson) {
            $lesson = Lesson::create($request->validated());

            $this->model::create([
                'lesson_id' => $lesson->id,
                'company_id' => Helper::userInfo()->company_id,
            ]);
        });

        return $lesson;
    }

    public function update(object $request, int $id, $where = []): object
    {
        $lesson = $this->model::whereLessonId($id)->firstOrFail();
        DB::transaction(function () use ($request, $lesson) {
            $lesson->lesson->update($request->validated());
        });
        return $lesson;
    }

    public function destroy(int $id, $where = []): object
    {
        $lesson = $this->model::wherelessonId($id)->firstOrFail();
        DB::transaction(function () use ($lesson) {
            $lesson->lesson->delete();
            $lesson->delete();
        });

        return $lesson;
    }
}
