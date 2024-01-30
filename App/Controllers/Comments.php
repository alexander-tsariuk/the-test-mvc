<?php

namespace App\Controllers;

use App\System\BaseController;

class Comments extends BaseController {

    /**
     * Запускаем констуктор родителя, устанавливаем правила валидации для элементов и их имена(['field' => 'Имя поля'])
     */
    public function __construct()
    {
        parent::__construct();

        $this->setStoreValidationRules([
            'name' => ['required', 'min' => 3, 'max' => 40],
            'email' => ['required', 'min' => 3, 'max' => 40, 'email'],
            'title' => ['required', 'min' => 5, 'max' => 40],
            'comment' => ['required', 'min' => 10, 'max' => 255],
        ]);

        $this->setStoreFieldsName([
            'name' => 'Ваше имя',
            'email' => 'Ваш e-mail',
            'title' => 'Заголовок комментария',
            'comment' => 'Комментарий',
        ]);
    }


}
