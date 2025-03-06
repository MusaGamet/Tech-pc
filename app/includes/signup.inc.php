<?php
require_once "class_autoloader.php";

if (isset($_POST["submit"])) {
    // Очистка и проверка данных
    $username = htmlspecialchars(trim($_POST["username"]));
    $pwd = htmlspecialchars(trim($_POST["pwd"]));
    $repeatPwd = htmlspecialchars(trim($_POST["repeat_pwd"]));
    $email = htmlspecialchars(trim($_POST["email"]));

    // Проверка на пустые поля
    if (empty($username) || empty($pwd) || empty($repeatPwd) || empty($email)) {
        header("location: ../signup.php?error=emptyfields");
        exit();
    }

    // Проверка совпадения паролей
    if ($pwd !== $repeatPwd) {
        header("location: ../signup.php?error=passwordcheck");
        exit();
    }

    // Создание объекта SignupContr
    $signup = new SignupContr($username, $pwd, $repeatPwd, $email);

    // Запуск обработки регистрации
    $signup->createUser();

    // Перенаправление после успешной регистрации
    header("location: ../signup.php?error=none");
    exit();
} else {
    header("location: ../signup.php");
    exit();
}
