<?php include_once 'form.php';
$messages = Form::dbRead() ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Messages Table</title>
  <style media="screen">
  table {
    margin: 10% auto;
    width: 90%;
    border-collapse: collapse;
    border: 2px solid black;
  }
  th, td {
    border: 1px solid grey;
  }
  th:nth-child(6) {
    width: 50%;
  }
  </style>
</head>
<body>
  <table>
    <caption>Messages from Contact Form</caption>
    <tr>
      <th>ID</th>
      <th>First name</th>
      <th>Last name</th>
      <th>E-mail</th>
      <th>Telephone</th>
      <th>Message</th>
      <th>Date</th>
    </tr>
    <?php foreach ($messages as $message): ?>
      <tr>
        <td><?= $message['id']; ?></td>
        <td><?= $message['fname']; ?></td>
        <td><?= $message['lname']; ?></td>
        <td><?= $message['email']; ?></td>
        <td><?= $message['tel']; ?></td>
        <td><?= $message['message']; ?></td>
        <td><?= $message['date']; ?></td>
      </tr>
    <?php endforeach ?>
  </table>
</body>
</html>
