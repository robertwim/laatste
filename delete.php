<?php
// Vul hier je Strato database gegevens in
$host = "jouw-hostnaam";       // meestal rdbms.strato.de
$user = "jouw-gebruikersnaam"; // bij Strato gekregen
$pass = "jouw-wachtwoord";
$db   = "jouw-databasenaam";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Bericht opslaan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $conn->real_escape_string($_POST['name']);
    $bericht = $conn->real_escape_string($_POST['message']);
    $sql = "INSERT INTO berichten (naam, bericht) VALUES ('$naam', '$bericht')";
    $conn->query($sql);
    header("Location: gastenboek.php"); // voorkomt dubbel versturen bij refresh
    exit;
}

// Berichten ophalen
$result = $conn->query("SELECT * FROM berichten ORDER BY datum DESC");
?>
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Gastenboek</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    form { margin-bottom: 30px; }
    input, textarea { display:block; margin:10px 0; width:300px; }
    button { padding:8px 15px; }
    .message { margin:10px 0; padding:10px; border:1px solid #ccc; }
    .delete { color:red; cursor:pointer; text-decoration:none; margin-left:10px; }
    .date { font-size:small; color:gray; }
  </style>
</head>
<body>
  <h2>Laat een bericht achter</h2>
  <form method="POST">
    <input type="text" name="name" placeholder="Je naam" required>
    <textarea name="message" rows="5" placeholder="Je bericht..." required></textarea>
    <button type="submit">Verstuur</button>
  </form>

  <h2>Berichten</h2>
  <?php while($row = $result->fetch_assoc()): ?>
    <div class="message">
      <strong><?= htmlspecialchars($row['naam']) ?></strong>: 
      <?= nl2br(htmlspecialchars($row['bericht'])) ?>
      <a class="delete" href="delete.php?id=<?= $row['id'] ?>">✖</a>
      <div class="date"><?= $row['datum'] ?></div>
    </div>
  <?php endwhile; ?>
</body>
</html>
<?php $conn->close(); ?>
