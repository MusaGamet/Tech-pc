<?php

class Login extends CommonUtil {
    protected function getUser($Username, $Password) {
        $row = $this->uidExists($Username);

        if ($row === false) {
            header("location: ../login.php?error=usernotfound");
            exit();
        }

        $PasswordHashed = $row["Password"];
        $checkPwd = password_verify($Password, $PasswordHashed);

        if ($checkPwd === false) {
            $loginAttempt = $row["Attempt"];
            $loginAttempt--;

            // Обновляем количество попыток
            $updateAttempt = "UPDATE members SET Attempt = $loginAttempt WHERE Username = ?";
            $stmt = $this->conn()->prepare($updateAttempt);
            $stmt->execute([$Username]);

            if ($loginAttempt < 1) {
                header("location: ../login.php?error=attemptReached");
                exit();
            } else {
                header("location: ../login.php?error=WrongLogin");
                exit();
            }
        }

        if ($checkPwd === true) {
            $loginAttempt = $row["Attempt"];

            if ($loginAttempt > 0) {
                session_start();
                require_once "../includes/class_autoloader.php";

                $member = new Member(
                    $row["MemberID"],
                    $row["Username"],
                    $row["Email"],
                    $row["PrivilegeLevel"]
                );

                $_SESSION["Member"] = $member;
                header("location: ../index.php");
                exit();
            } else {
                header("location: ../login.php?error=attemptReached");
                exit();
            }
        }
    }
}
