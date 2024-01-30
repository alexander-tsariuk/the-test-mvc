<?php

namespace App\Models;

use App\System\BaseModel;

class Comments extends BaseModel {
    /**
     * Имя таблицы
     * @var string
     */
    protected $table = 'comments';

    /**
     * Флаг использования timestamps от Eloqment
     * @var bool
     */
    public $timestamps = false;

    /**
     * Массив полей для заполниния($item->fill([...]))
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'title',
        'comment',
    ];
}
