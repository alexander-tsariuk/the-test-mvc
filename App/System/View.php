<?php

namespace App\System;

class View {

    /**
     * Метод отображения вьюхи
     * @param string $view - название вьюхи в директории
     * @param array $params - массив данных для вьюхи
     * @return bool|string
     * @throws \Exception
     */
    public static function render(string $view, array $params = []): bool|string
    {
        if(!empty($params)) {
            extract($params);
        }

        if(!file_exists(getenv('VIEWS_DIR')."/{$view}".'.php')) {
            throw new \Exception("Представление не найдено!");
        }

        ob_start();
        include getenv('VIEWS_DIR')."/{$view}".'.php';
        return ob_get_clean();
    }
}