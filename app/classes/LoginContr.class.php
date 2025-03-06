<?php 
class LoginContr extends Login {
    private $Username; 
    private $Password; 

    public function __construct($Username, $Password) {
        $this->Username = $Username;
        $this->Password = $Password;
    }

    private function checkEmptyInput() {
        return !(empty($this->Username) || empty($this->Password));
    }

    public function loginUser() {
    if (!$this->checkEmptyInput()) {
        header("location: ../login.php?error=empty_input");
        exit();
    }

    $this->getUser($this->Username, $this->Password);
    }
}
