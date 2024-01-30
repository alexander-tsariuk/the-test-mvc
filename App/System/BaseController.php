<?php

namespace App\System;

use App\Exceptions\ValidationException;

class BaseController {

    /**
     * Массив, содержащий правила валидации
     * @var array
     */
    private array $storeValidationRules;

    /**
     * Массив, содержащий правила валидации
     * @var array
     */
    private array $storeFieldsName;

    /**
     * Массив ответа
     * @var array
     */
    public array $response = [
        'success' => true,
        'data' => [],
        'code' => 200
    ];

    /**
     * Имя модели
     * @var string
     */
    protected string $modelName;

    /**
     * В конструкторе получаем путь и имя модели
     */
    public function __construct()
    {
       $this->modelName = $this->getModelName();
    }

    /**
     * Метод получения списка элементов
     * @return void
     */
    public function index(): void
    {
        try {
            $model = new $this->modelName();

            $items = $model->getList('id', 'DESC');

            $this->response['data']['items'] = View::render($this->getViewName().'_list', [
                'items' => $items
            ]);

        } catch (\Exception $exception) {
            $this->response['success'] = false;
            $this->response['code'] = 500;
            $this->response['message'] = $exception->getMessage();
        } finally {
            echo json_encode($this->response, true);
            die;
        }
    }

    /**
     * Метод добавления элемента
     * @return void
     */
    public function store(): void
    {
        try {
            $validator = new Validator();

            $validator->validate($_REQUEST['item'], $this->storeValidationRules, $this->storeFieldsName);

            if($errors = $validator::errors()) {
                throw new ValidationException($errors);
            }

            $model = new $this->modelName();

            if(!$model->storeItem((array)$_REQUEST['item'])) {
                throw new \Exception("При добавлении комментария произошла ошибка!");
            }

            $this->response['data']['items'] = View::render($this->getViewName().'_list', [
                'items' => $model->getList('id', 'DESC')
            ]);
        } catch (ValidationException $exception) {
            $this->response['success'] = false;
            $this->response['code'] = $exception->getCode();
            $this->response['data']['errors'] = $exception->getErrors();
        } catch (\Exception $exception) {
            $this->response['success'] = false;
            $this->response['code'] = 500;
            $this->response['data']['message'] = $exception->getMessage();
        } finally {
            echo json_encode($this->response, true);
            die;
        }
    }

    /**
     * Получаем путь к модели. Имя контроллера = имени модели
     * @return string
     */
    private function getModelName(): string
    {
        return "App\\Models\\".substr(get_called_class(), strrpos(get_called_class(), '\\')+1);
    }

    /**
     * Название шаблона. Имя контроллера = начало имени вьюхи base_*
     * @return string
     */
    private function getViewName(): string
    {
        return strtolower(substr(get_called_class(), strrpos(get_called_class(), '\\')+1));
    }

    /**
     * Устанавливаем правила валидации
     * @param array $rules
     * @return void
     */
    public function setStoreValidationRules(array $rules): void
    {
        $this->storeValidationRules = $rules;
    }

    /**
     * Устаналиваем имена полей
     * @param array $fields - массив с именами полей ['field' => 'Название поля']
     * @return void
     */
    public function setStoreFieldsName(array $fields): void
    {
        $this->storeFieldsName = $fields;
    }
}