<?php

namespace App\Services\Base;

class BaseService
{
    protected string $model;

    /**
     * @var string $model
     */
    public function __construct(string $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     * @param array $with
     * @param array $where
     * @return mixed
     */
    public function list(array $with = [], array $where = []): mixed
    {
        return $this->model::with($with)->where($where)->latest()->get();
    }

    /**
     * Display a listing paginated of the resource.
     * @param array $with
     * @param array $where
     * @param int $perPage
     */
    public function paginate(array $with = [], array $where = [], int $perPage = 10)
    {
        return $this->model::with($with)->where($where)->latest()->paginate($perPage);
    }

    /**
     * Display a listing paginated of the resource.
     * @param string $query
     * @param int $perPage
     * @return mixed
     */
    public function search(string $query, int $perPage = 10): mixed
    {
        return $this->model::search($query)->paginate($perPage);
    }

    /**
     * Store a newly created resource in storage.
     * @param object $request
     * @return object
     */
    public function create(object $request): object
    {
        return $this->model::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param array $with
     * @param array $where
     * @return mixed
     */
    public function show(int $id, array $with = [], array $where = []): mixed
    {
        return $this->model::with($with)->where($where)->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param object $request
     * @param int $id
     * @param array $where
     * @return object
     */
    public function update(object $request, int $id, array $where = []): object
    {
        $this->model::where($where)->findOrFail($id)->update($request->validated());

        return $this->model::findOrFail($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param array $where
     * @return mixed
     */
    public function destroy(int $id, array $where = []): mixed
    {
        $model = $this->model::where($where)->findOrFail($id);

        $model->delete();

        return $model;
    }
}
