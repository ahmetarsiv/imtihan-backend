<?php

namespace App\Services\Manager\Exam;

use App\Models\ClassExam;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;

class ClassExamService extends BaseService
{
    public function __construct()
    {
        parent::__construct(ClassExam::class);
    }

    public function create(object $request): object
    {
       $classExam = null;
        DB::transaction(function () use ($request, &$classExam) {
            $classExam = $this->model::create($request->validated());

            $classExam->classExamCategories()->createMany($request->categories);
        });

        return $classExam;
    }

    public function update(object $request, $id, $where = []): object
    {
        $classExam = $this->model::findOrFail($id);
        DB::transaction(function () use ($request, $classExam) {
            $classExam->update($request->validated());

            $classExam->classExamCategories()->delete();

            $classExam->classExamCategories()->createMany($request->categories);
        });

        return $classExam;
    }

    public function destroy($id, $where = []): object
    {
        $classExam = $this->model::findOrFail($id);
        DB::transaction(function () use ($classExam) {
            $classExam->classExamCategories()->delete();
            $classExam->delete();
        });

        return $classExam;
    }
}
