<?php

namespace App\Services\Admin\Company;

use App\Models\Company;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\Storage;

class CompanyService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Company::class);
    }

    /*
     * Store a newly created resource in storage.
     *
     * @param object $request
     */
    public function create(object $request): object
    {
        $path = $request->file('logo')->store('companies');
        $data = $request->safe()->merge(['logo' => $path]);

        return $this->model::create($data->all());
    }

    /*
     * Update the specified resource in storage.
     *
     * @param object $request
     * @param int $id
     * @param array $where
     * @return object
     */
    public function update(object $request, int $id, array $where = []): object
    {
        $company = $this->model::findOrFail($id);

        if ($request->hasFile('logo')) {
            if (Storage::exists($company->logo)) {
                Storage::delete($company->logo);
            }
            $path = $request->file('logo')->store('companies');
            $data = $request->safe()->merge(['logo' => $path]);
        } else {
            $data = $request->safe();
        }

        $company->update($data->all());

        return $company;
    }

    /*
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param array $where
     * @return bool
     */
    public function destroy(int $id, array $where = []): object
    {
        $company = $this->model::findOrFail($id);

        if (Storage::exists($company->logo)) {
            Storage::delete($company->logo);
        }

        $company->delete();

        return $company;
    }
}
