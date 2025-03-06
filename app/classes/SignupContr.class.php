<?php

class SignupContr {
    private $username;
    private $pwd;
    private $repeatPwd;
    private $email;

    public function __construct($username, $pwd, $repeatPwd, $email) {
        $this->username = $username;
        $this->pwd = $pwd;
        $this->repeatPwd = $repeatPwd;
        $this->email = $email;
    }

    private function emptyInput() {
        return !(empty($this->username) || empty($this->pwd) || empty($this->repeatPwd) || empty($this->email));
    }

    private function invalidUid() {
        return !preg_match("/^[a-zA-Z0-9]*$/", $this->username);
    }

    private function pwdNotMatch() {
        return $this->pwd !== $this->repeatPwd;
    }

    private function uidExists() {
        return $this->checkUser($this->username, $this->email);
    }

    private function checkUser($username, $email) {
        $sql = "SELECT * FROM members WHERE Username = ? OR email = ?;";
        $stmt = $this->conn()->prepare($sql);
        $stmt->execute([$username, $email]);

        return $stmt->rowCount() > 0;
    }

    private function setUser($username, $pwd, $email) {
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT); 
        $sql = "INSERT INTO members (Username, Password, Email) VALUES (?, ?, ?);";
        $stmt = $this->conn()->prepare($sql);
        $stmt->execute([$username, $hashedPwd, $email]);
    }

    public function createUser() {
        if (!$this->emptyInput()) {
            header("location: ../signup.php?error=empty_input");
            exit();
        }

        if ($this->invalidUid()) {
            header("location: ../signup.php?error=invalid_uid");
            exit();
        }

        if ($this->pwdNotMatch()) {
            header("location: ../signup.php?error=passwords_dont_match");
            exit();
        }

        if ($this->uidExists()) {
            header("location: ../signup.php?error=username_taken");
            exit();
        }


        $this->setUser($this->Username, $this->Passwod, $this->Email);


        header("location: ../signup.php?error=none");
        exit();
    }

    private function conn() {
        $host = 'db';
        $dbname = 'ogtech';
        $user = 'myuser';
        $password = 'mypassword';

        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}
