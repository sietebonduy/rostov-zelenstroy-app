<?php

class Session {
    public function __construct() {
        session_start();
    }

    public function setSessionVariable($name, $value) {
        $_SESSION[$name] = $value;
    }

    public function getSessionVariable($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    public function deleteSessionVariable($name) {
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
    }

    public function checkSessionVariable($name) {
        return isset($_SESSION[$name]);
    }

    public function setMultipleSessionVariables(array $data) {
        $_SESSION = array_merge($_SESSION, $data);
    }
}

$session = new Session();

$session->setSessionVariable('username', 'john_doe');

$username = $session->getSessionVariable('username');
echo "Username: $username<br>";

$isLogged = $session->checkSessionVariable('username');
echo "Is logged in: " . ($isLogged ? 'Yes' : 'No') . "<br>";

$session->deleteSessionVariable('username');

$isLogged = $session->checkSessionVariable('username');
echo "Is logged in: " . ($isLogged ? 'Yes' : 'No') . "<br>";

$session->setMultipleSessionVariables([
    'username' => 'mary_jane',
    'password' => 'secure_password'
]);

$username = $session->getSessionVariable('username');
$password = $session->getSessionVariable('password');
echo "Username: $username, Password: $password<br>";

?>
