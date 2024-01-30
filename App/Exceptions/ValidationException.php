<?php

namespace App\Exceptions;

class ValidationException extends \Exception {

    /**
     * Массив с ошибками валидации
     * @var array
     */
    private array $errors;

    /**
     * Конструктор
     * Передаём родителю код ответа и текст ошибки, складываем массив ошибок для вывода в catch
     * @param array $errors
     * @param $code
     */
    public function __construct(array $errors, $code = 422)
    {
        parent::__construct('Validation error!', $code);

        $this->errors = $errors;
    }

    /**
     * Отдаём массив ошибок валидации
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }



}
