<?php
namespace App\System;

class Validator {

    /**
     * Данные валидации
     * @var array
     */
    private static array $data;

    /**
     * Массив для сбора ошибок валидации
     * @var array
     */
    private static array $errors = [];

    /**
     * Массив с именами полей ['field' => 'Название поля']
     * @var array
     */
    private static array $fieldName;

    /**
     * @param array $data - массив данных для валидации
     * @param array $rules - правила валидации
     * @param array $fieldsName - имена полей
     * @return void
     */
    public static function validate(array $data, array $rules, array $fieldsName): void
    {
        if(!empty($rules)) {

            self::$data = $data;
            self::$fieldName = $fieldsName;

            $rules = self::prepareRules($rules);

            foreach ($rules as $field => $fieldRules) {
                foreach ($fieldRules as $rule => $value)
                    match ($rule) {
                        'required' => self::required($field),
                        'min' => self::min($field, $value),
                        'max' => self::max($field, $value),
                        'email' => self::email($field)
                    };
            }
        }
    }

    /**
     * Возвращаем список ошибок валидации
     * @return array
     */
    public static function errors(): array
    {
        return self::$errors;
    }

    /**
     * Приводим правила валидации к нужному виду
     * @param array $rules
     * @return array
     */
    private static function prepareRules(array $rules): array
    {
        $preparedRules = [];

        foreach ($rules as $field => $fieldRules) {
            foreach ($fieldRules as $key => $value) {
                if(is_int($key)) {
                    $preparedRules[$field][$value] = 1;
                } else {
                    $preparedRules[$field][$key] = $value;
                }
            }
        }

        return $preparedRules;
    }

    /**
     * Проверяем на существование и пустоту элемент массива
     * @param string $field - имя элемента массива
     * @return void
     */
    private static function required(string $field): void
    {
        if(!isset(self::$data[$field]) || empty(self::$data[$field])) {
            self::$errors[$field] = "Поле \"".self::$fieldName[$field]."\" обязательно к заполнению!";
        }
    }

    /**
     * Проверяем на мин. кол-во символов
     * @param string $field - имя элемента массива
     * @param int $value - кол-во символов
     * @return void
     */
    private static function min(string $field, int $value): void
    {
        if(!isset(self::$errors[$field])) {
            if (mb_strlen(self::$data[$field]) < $value) {
                self::$errors[$field] = "Минимальная длина поля \"".self::$fieldName[$field]."\" составляет {$value} символов.";
            }
        }
    }

    /**
     * Проверяем на макс. кол-во символов
     * @param string $field - имя элемента массива
     * @param int $value - кол-во символов
     * @return void
     */
    private static function max(string $field, int $value): void
    {
        if(!isset(self::$errors[$field])) {
            if (mb_strlen(self::$data[$field]) > $value) {
                self::$errors[$field] = "Максимальная длина поля \"".self::$fieldName[$field]."\" составляет {$value} символов.";
            }
        }
    }

    /**
     * Проверяем поле на email
     * @param string $field - имя элемента массива
     * @return void
     */
    private static function email(string $field): void
    {
        if(!isset(self::$errors[$field])) {
            if (!filter_var(self::$data[$field], FILTER_VALIDATE_EMAIL)) {
                self::$errors[$field] = "Некорректно заполнено поле ".self::$fieldName[$field];
            }
        }
    }
}