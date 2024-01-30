<?php

namespace App\System;

use Illuminate\Database\Eloquent\Model as EloquentModel;
class BaseModel extends EloquentModel {

    /**
     * Выборка всех элементов постранично
     * @param string $orderByField
     * @param string $orderByDest
     * @return mixed
     */
    public function getList(string $orderByField = 'id', string $orderByDest = 'ASC'): mixed
    {
        return $this->orderBy($orderByField, $orderByDest)
            ->paginate(getenv('ITEMS_PER_PAGE'), ['*'], 'page', $_REQUEST['page'] ?? 1);
    }

    /**
     * Создаем элемент
     * @param array $inputData
     * @return bool
     */
    public function storeItem(array $inputData): bool
    {
        $item = new $this();

        $item->fill($inputData);

        return $item->save();
    }
}
