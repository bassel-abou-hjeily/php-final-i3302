<?php
include("../connect.php");
include("check.php");
include("navbar.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users</title>
  <link rel="stylesheet" href="css/all-users_css.css">
  <link rel="stylesheet" href="../css/all.min.css">
</head>
<body>

  <h1>All Users</h1>
  <?php
  if (isset($_GET['id']) && isset($_GET['action'])) {
    $userId = $_GET['id'];
    $newStatus = ($_GET['action'] === 'block') ? 'Blocked' : 'Active';

    $updateSql = "UPDATE `account` SET `status` = '$newStatus' WHERE `id` = '$userId'";
    if (mysqli_query($conn, $updateSql)) {
    } else {
      echo "<script>alert('Error updating user status: " . mysqli_error($conn) . "');</script>";
    }
  }

  $sql = "SELECT * FROM `account`  where role != 'admin'  ";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    echo '<table border="3">';
    echo '<thead>
            <tr>
              <th>Firstname</th>
              <th>Lastname</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>';
    echo '<tbody>';
    while ($row = mysqli_fetch_assoc($result)) {
      $status = $row['status'];
      $action = ($status === 'Active') ? 'block' : 'unblock';
      $buttonText = ($status === 'Active') ? 'Block' : 'Unblock';
      $buttonClass = ($status === 'Active') ? '' : 'blocked';

      echo '<tr>';
      echo '<td>' . $row['Firstname'] . '</td>';
      echo '<td>' . $row['Lastname'] . '</td>';
      echo '<td>' . $row['Email'] . '</td>';
      echo '<td>' . $row['Phone_Nb'] . '</td>';
      echo '<td>' . $status . '</td>';
      echo '<td>
              <a href="?id=' . $row['id'] . '&action=' . $action . '">
                <button class="btn ' . $buttonClass . '">' . $buttonText . '</button>
              </a>
            </td>';
      echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
  } else {
    echo '<p class="no-data">No users found in the database.</p>';
  }

  mysqli_close($conn);
  ?>
</body>
</html>
