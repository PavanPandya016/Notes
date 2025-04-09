<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "curd";
$insert = false;
$delete = false;

$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {
  die("❌ Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["Title"])) {
  $title = htmlspecialchars($_POST["Title"]);
  $description = htmlspecialchars($_POST["Description"]);

  $stmt = $conn->prepare("INSERT INTO `notes` (`Title`, `Description`) VALUES (?, ?)");
  $stmt->bind_param("ss", $title, $description);
  $stmt->execute();
  $stmt->close();

  $insert = true;
  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["delete"])) {
  $sno = intval($_POST["sno"]);
  if ($sno > 0) {
    $stmt = $conn->prepare("DELETE FROM `notes` WHERE `sno` = ?");
    $stmt->bind_param("i", $sno);
    $stmt->execute();
    $stmt->close();
    $delete = true;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FUFUNotes - Make Your Life Better</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

  <style>
    body {
      background-color: #f8f9fa;
    }

    .container {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
    }

    h2 {
      font-weight: bold;
      color: #343a40;
    }

    .btn-primary {
      background-color: #007bff;
      border: none;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    .table {
      margin-top: 20px;
      background: white;
      border-radius: 10px;
      overflow: hidden;
    }

    .alert {
      border-radius: 5px;
    }

    .btn-danger {
      transition: 0.3s;
    }

    .btn-danger:hover {
      background-color: #c82333;
    }
  </style>

  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>
</head>

<body>

  <?php if ($insert) { ?>
    <div class='alert alert-success alert-dismissible fade show mx-3' role='alert'>
      <strong>✅ Success!</strong> Your note was added successfully!
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>
  <?php } ?>

  <?php if ($delete) { ?>
    <div class='alert alert-success alert-dismissible fade show mx-3' role='alert'>
      <strong>✅ Success!</strong> Your note was deleted successfully!
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>
  <?php } ?>

  <div class="container my-4">
    <form action="" method="post">
      <h2>Add Notes</h2>
      <div class="mb-3">
        <label for="Title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="Title" name="Title" required />
      </div>
      <div class="form-group my-4">
        <label for="Description">Note Description</label>
        <textarea class="form-control" id="Description" name="Description" rows="3" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

  <div class="container">
    <table class="table table-striped" id="myTable">
      <thead class="table-dark">
        <tr>
          <th scope="col">S.no</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `notes` ORDER BY `sno` ASC";
        $result = mysqli_query($conn, $sql);
        $a = 1;
        while ($row = mysqli_fetch_assoc($result)) {
          $no = $row['sno'];
          echo "
          <tr>
            <th scope='row'>" . $a . "</th>
            <td>" . htmlspecialchars($row['Title']) . "</td>
            <td>" . htmlspecialchars($row['Description']) . "</td>
            <td>
              <form method='POST' class='d-inline'>
                <input type='hidden' name='sno' value='" . $no . "' />
                <button type='button' class='btn btn-danger' onclick='confirmDelete($no)'>Delete</button>            
              </form>
            </td>
          </tr>";
          $a++;
        }
        mysqli_close($conn);
        ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
     function confirmDelete(sno) {
            var confirmDelete = confirm("Are you sure you want to delete this note?");
            if (confirmDelete) {
                // Create a form and submit it with the sno value to delete the note
                var form = document.createElement("form");
                form.method = "POST";
                form.action = "";

                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "sno";
                input.value = sno;
                form.appendChild(input);

                var deleteInput = document.createElement("input");
                deleteInput.type = "hidden";
                deleteInput.name = "delete";
                deleteInput.value = "1";
                form.appendChild(deleteInput);

                document.body.appendChild(form);
                form.submit();  // Submit the form to delete the note
            }
        }
  </script>
</body>

</html>