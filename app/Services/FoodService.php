<?php

namespace App\Services;

use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class FoodService extends BaseService
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }

    /**
     * @return Collection
     * @throws Exception
     */
    public function getFilteredData(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function getPaginated(array $data): mixed
    {
        $perPage = $data['per_page'] ?? 50;
        $page = $data['page'] ?? 0;

        return $this->model->orderBy('name', 'asc')->simplePaginate($perPage, ['*'], 'page', $page);
    }

    /**
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function createCategory(array $data): mixed
    {
        return $this->model->create([
            'name' => $data['name'],
        ]);
    }

}
