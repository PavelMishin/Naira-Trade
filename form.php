<?php
Class Form {
  private $fname;
  private $lname;
  private $tel;
  private $email;
  private $message;
  const ADMIN_MAIL = 'trobing1@gmail.com';
  const SUBJECT = 'Mail from contact form';
  const DB_NAME = 'y92936ku_books';
  const DB_USER = 'y92936ku_books';
  const DB_PASSWORD = 'kykish123';
  const TABLE_NAME = 'form_messages';

  public function __construct($fname, $lname, $tel, $email, $message) {
    $this->fname = $fname;
    $this->lname = $lname;
    $this->tel = $tel;
    $this->email = $email;
    $this->message = $message;

    try {
      $this->checkFields();
    } catch (Exception $ex) {
      print $ex->getMessage();
      die;
    }

    $this->sendMail();

    $this->dbWrite();
  }

  private function checkFields() {
    if (preg_match('/[^\w \']+/u', $this->fname) || preg_match('/[^\w \']+/u', $this->lname))
    throw new Exception('Invalid characters in Name fields!<br>');

    if (strlen($this->fname) < 2 || strlen($this->lname) < 2)
    throw new Exception('Too short name!<br>');

    if (!preg_match('/[+]*?[7]*?[0-9 ]{9,15}$/', $this->tel) && $this->tel !== '')
    throw new Exception('Incorrect telephone number!<br>');

    if (!preg_match('/[\w]+[@][\w]+[.][\w]{2,3}/', $this->email))
    throw new Exception('Incorrect E-mail address!<br>');

    if (strlen($this->message) < 5) {
      throw new Exception('Too short Message!<br>');
    }

    if (preg_match('/[^\w!., ;\/\"\-\']+/u', $this->message))
    throw new Exception('Invalid characters in Message!<br>');
  }

  private function sendMail() {
    $to = self::ADMIN_MAIL;
    $subject = self::SUBJECT;
    $message = 'Last Name: ' . $this->lname . '<br>' .
    'First Name: ' . $this->fname . '<br>' .
    'Telephone number: ' . $this->tel . '<br>' .
    'E-mail: ' . $this->email . '<br>' .
    'Message: ' . $this->message . '<br>';

    $result = mail($to, $subject, $message);
  }

  private function dbWrite() {
    $db = new PDO('mysql:host=localhost', self::DB_USER, self::DB_PASSWORD);
    $db->query('CREATE DATABASE IF NOT EXISTS ' . self::DB_NAME . ' CHARACTER SET utf8 COLLATE utf8_general_ci');
    $db = new PDO('mysql:host=localhost; dbname='. self::DB_NAME . '; charset=utf8', self::DB_USER, self::DB_PASSWORD);
    $db->query('CREATE TABLE IF NOT EXISTS ' . self::TABLE_NAME . ' (
                id int(11) AUTO_INCREMENT,
                first_name varchar(50) NOT NULL,
                last_name varchar(50) NOT NULL,
                email varchar(50) NOT NULL,
                telephone varchar(20) NOT NULL,
                message text NOT NULL,
                date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id))
                ENGINE=InnoDB DEFAULT CHARSET=utf8;)');

    $query = 'INSERT INTO ' . self::TABLE_NAME . ' (first_name, last_name, email, telephone, message) ' .
              ' VALUES (:fname, :lname, :email, :telephone, :message)';

    $result = $db->prepare($query);
    $result->bindParam(':fname', $this->fname, PDO::PARAM_STR);
    $result->bindParam(':lname', $this->lname, PDO::PARAM_STR);
    $result->bindParam(':email', $this->email, PDO::PARAM_STR);
    $result->bindParam(':telephone', $this->tel, PDO::PARAM_STR);
    $result->bindParam(':message', $this->message, PDO::PARAM_STR);
    return $result->execute();
  }

  public static function dbRead() {
    $db = new PDO('mysql:host=localhost; dbname='. self::DB_NAME . '; charset=utf8', self::DB_USER, self::DB_PASSWORD);
    $result = $db->query('SELECT * FROM ' . self::TABLE_NAME . ' ORDER BY date DESC');

    $i = 0;
    while ($row = $result->fetch()) {
      $messages[$i]['id'] = $row['id'];
      $messages[$i]['fname'] = $row['first_name'];
      $messages[$i]['lname'] = $row['last_name'];
      $messages[$i]['email'] = $row['email'];
      $messages[$i]['tel'] = $row['telephone'];
      $messages[$i]['message'] = $row['message'];
      $messages[$i]['date'] = $row['date'];
      $i++;
    }
    return $messages;
  }
}
