<?php
spl_autoload_register('myAutoLoader');

function myAutoLoader($className) {
    // Определяем базовый путь к папке classes
    $basePath = __DIR__ . '/../classes/'; // __DIR__ — директория текущего файла

    // Формируем полный путь к файлу класса
    $fullPath = $basePath . $className . '.class.php';

    // Проверяем, существует ли файл
    if (file_exists($fullPath)) {
        require_once $fullPath;
    } else {
        // Если файл не найден, можно вывести предупреждение или записать в лог
        error_log("Class file not found: " . $fullPath);
        throw new Exception("Class file not found: " . $fullPath);
    }
}
