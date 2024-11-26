<?php
session_start();

class Auth {
    private $error = '';

    public function redirectIfAuthenticated($redirectTo = 'MusicPost/index.php') {
        if (isset($_SESSION['email'])) {
            header('Location: ' . $redirectTo);
            exit();
        }
    }
    
    public function redirectIfNotAuthenticated($redirectTo = 'signin.php') {
        if (!isset($_SESSION['email'])) {
            header('Location: ' . $redirectTo);
            exit();
        }
    }

    // Function to handle the login process
    public function login() {
        
        $this->redirectIfAuthenticated();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $this->error = $this->validateInputs($email, $password);

            if (empty($this->error)) {
                if ($this->checkCredentials($email, $password)) {
                    header('Location: signin.php');
                    die();
                } else {
                    $this->error = 'Your credentials are wrong';
                }
            }
        }
    }

    // Function to handle the signup process
    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';

            $this->error = $this->validateSignupInputs($email, $password, $password_confirm);

            if (empty($this->error)) {
                // Check if the email is already registered
                if ($this->emailExists($email)) {
                    $this->error = 'The email is already registered';
                } else {
                    // Save the user credentials to the CSV file
                    $this->registerUser($email, $password);
                    header('Location: signin.php');
                    die();
                }
            }
        }
    }

    public function signout() {
        session_destroy();
        echo "<h2>You have successfully signed out. Click here to return to the <a href='index.php'>HomePage</a></h2>";
    }

    // Validate signup inputs
    private function validateSignupInputs($email, $password, $password_confirm) {
        if (empty($email)) return 'You must enter your email';
        if (empty($password)) return 'You must enter your password';
        if (empty($password_confirm)) return 'You must confirm your password';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return 'You must enter a valid email';
        if (strlen($password) < 8 || strlen($password) > 16) return 'Password must be between 8 and 16 characters';
        if ($password !== $password_confirm) return 'Passwords must match';

        return ''; // No errors
    }

    // Check if email already exists in the CSV file
    private function emailExists($email) {
        $fp = fopen('users.csv.php', 'r');
        while (!feof($fp)) {
            $line = fgets($fp);
            $line = explode(';', $line);
            if (count($line) == 2 && $email == $line[0]) {
                fclose($fp);
                return true;
            }
        }
        fclose($fp);
        return false;
    }

    // Register a new user by saving their credentials in the CSV file
    private function registerUser($email, $password) {
        $fp = fopen('users.csv.php', 'a+');
        fputs($fp, $email . ';' . password_hash($password, PASSWORD_DEFAULT) . PHP_EOL);
        fclose($fp);
    }

    // Getter for error message
    public function getError() {
        return $this->error;
    }

    // Validate common login inputs
    private function validateInputs($email, $password) {
        if (empty($email)) return 'You must enter your email';
        if (empty($password)) return 'You must enter your password';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return 'You must enter a valid email';
        if (strlen($password) < 8 || strlen($password) > 16) return 'You must enter a password between 8 and 16 characters';

        return ''; // No errors
    }

    // Check login credentials
    private function checkCredentials($email, $password) {
        $user_id = 0;
        $fp = fopen('users.csv.php', 'r');
        while (!feof($fp)) {
            $line = fgets($fp);
            $line = explode(';', $line);
            if (count($line) == 2 && $email == $line[0] && password_verify(trim($password), trim($line[1]))) {
                fclose($fp);
                $_SESSION['email'] = $line[0];
                $_SESSION['user_id'] = $user_id;
                return true;
            }
            $user_id++;
        }
        fclose($fp);
        return false;
    }
}
?>
