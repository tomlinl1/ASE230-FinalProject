<?php
session_start();
require_once('db.php');

class Auth {
    private $error = '';
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function redirectIfAuthenticated($redirectTo = 'MusicPost/index.php') { // **REWORK** : Add Compare to DataBase Functionality
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

        //  Check for error, if successful go back to signin.php               --     All good, no rework.
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
            $fname = $_POST['fname'] ?? '';
            $lname = $_POST['lname'] ?? '';

            $this->error = $this->validateSignupInputs($email, $password, $password_confirm);

        // Update emailExists and registerUser
            if (empty($this->error)) {
                // Check if the email is already registered
                if ($this->emailExists($email)) {
                    $this->error = 'The email is already registered';
                } else {
                    // Save the user credentials to the CSV file
                    $this->registerUser($fname, $lname, $email, $password);
                    header('Location: signin.php');
                    die();
                }
            }
        }
    }

    public function signout() { // This is fine! Edited to make it so there's no need to click a link to go back
        session_destroy();
        echo "<h2>You have successfully signed out.</h2>";
        header('Location: index.php');
        
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

    // Check if email already exists in the database
    private function emailExists($email) {
        $query = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $query->execute(['email' => $email]);
        
        $count = $query->fetchColumn();
        
        return $count > 0;
    }
    
    
    // Register a new user by saving their credentials to the database ***
    

    private function registerUser($fname, $lname, $email, $password) {
        // Check if the email already exists
        if ($this->emailExists($email)) {
            return 'This email is already registered.';
        }
    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Default role perms
        $role = '1';
    
        $query = $this->db->prepare("INSERT INTO users (email, password, firstname, lastname, role) VALUES (:email, :password, :firstname, :lastname, :role)");
        
        $query->execute([
            'email' => $email,
            'password' => $hashedPassword,
            'firstname' => $fname,
            'lastname' => $lname,
            'role' => $role
        ]);
    
        return 'User registered successfully.';
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

    // Check login credentials against database
    private function checkCredentials($email, $password) {
        $query = $db -> prepare("SELECT user_ID, password FROM users WHERE email = :email LIMIT 1");
        $query -> execute(['email' => $email]);
        $user = $query -> fetch();
    
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $user['user_ID'];
            return true;
        }
        return false;
    }
    
}
?>
