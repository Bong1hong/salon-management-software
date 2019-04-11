<?php include '../db_connect.php'; ?>

<?php

$sql = 'SELECT * from appointments';

$q = $conn->query($sql);
$q->setFetchMode(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Appointment List</title>
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
  <link rel="stylesheet" type="text/css" href="../style.css">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
  <script src="../script.js"></script>
</head>
<body>
  <div class="container">
    <h1 class="appointment-list-title">Appointment List</h1>
    <table class="ui striped table">
      <thead>
        <tr>
          <th>User Id</th>
          <th>Date</th>
          <th>Time</th>
          <th>Details</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $q->fetch()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['userId']) ?></td>
            <td><?php echo htmlspecialchars($row['appointmentDate']); ?></td>
            <td><?php echo htmlspecialchars($row['appointmentTime']); ?></td>
            <td><a class="view-details-tag" onclick='onViewAppointment(
              <?php echo htmlspecialchars($row['appointmentId']) ?>,
              <?php echo htmlspecialchars($row['userId']) ?>,
              <?php echo htmlspecialchars($row['appointmentDate']) ?>,
              <?php echo htmlspecialchars($row['appointmentTime']) ?>,
              <?php echo htmlspecialchars($row['typeOfServices']) ?>,
              <?php echo htmlspecialchars($row['hairdresser']) ?>,
              <?php echo htmlspecialchars($row['request']) ?>)'>
            <span class="view-details-text">view details<span></a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <div class="ui modal" id="appointment-details-modal">
      <div class="header">Appointment details<i id="close-app-mark" onmouseover="onHoverCloseDetail()" onclick="onCloseAppDetail()" class="close icon"></i></div>
      <div class="content">
        <p class="appointment-details-title">User: <span id="appDetails-user" class="appointment-details-content"></span></p>
        <p class="appointment-details-title">Appointment Date: <span id="appDetails-date" class="appointment-details-content"></span></p>
        <p class="appointment-details-title">Appointment Time: <span id="appDetails-time" class="appointment-details-content"></span></p>
        <p class="appointment-details-title">Service: <span id="appDetails-service" class="appointment-details-content"></span></p>
        <p class="appointment-details-title">Hairdresser: <span id="appDetails-hairdresser" class="appointment-details-content"></span></p>
        <p class="appointment-details-title">Request: <span id="appDetails-request" class="appointment-details-content"></span></p>
        <button class="ui red button" onclick="onDeleteAppointment()"><i class="trash icon"></i>Delete appointment</button>
      </div>
    </div>

     <div class="ui modal mini" id="delete-app-modal">
      <i class="close icon"></i>
      <div class="header">
        Delete appointment
      </div>
      <div class="content">
        <div class="description">
          <p>Please note that this action cannot be undone!</p>
          <p>Are you sure you want to delete?</p>
        </div>
      </div>
      <div class="actions">
        <div class="ui deny button">
          No, I don't mean it
        </div>
        <div class="ui red ok button">
          Yes, delete it
        </div>
      </div>
    </div>

  </div>
</body>
</html>

