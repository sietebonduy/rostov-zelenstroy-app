<?php 

include "session.php";

class Flash {
  private $session;

  public function __construct() {
      $this->session = new Session();
  }

  public function setMessage($message) {
      $this->session->setSessionVariable('flash_message', $message);
  }

  public function getMessage() {
      $message = $this->session->getSessionVariable('flash_message');
      $this->session->deleteSessionVariable('flash_message'); // Очищаем сообщение после получения
      return $message;
  }
}

$flash = new Flash();

$flash->setMessage('Form submitted successfully!');

$message = $flash->getMessage();

echo $message ? $message : 'No message available.';


?>