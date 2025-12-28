<?php
// ---------------------------
// DATABASE INSTELLINGEN
// ---------------------------
$host = "database-5019015271.webspace-host.com";
$user = "dbu1065673";
$pass = "Robertwim1947!";
$db   = "dbs14968921";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database-verbinding mislukt: " . $conn->connect_error);
}

// ---------------------------
// NIEUW BERICHT OPSLAAN
// ---------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam    = $conn->real_escape_string($_POST['naam']);
    $bericht = $conn->real_escape_string($_POST['bericht']);

    if (!empty($naam) && !empty($bericht)) {
        $sql = "INSERT INTO guestbook (naam, bericht) VALUES ('$naam', '$bericht')";
        $conn->query($sql);
    }

    header("Location: index.php");
    exit;
}

// ---------------------------
// BERICHTEN OPHALEN
// ---------------------------
$result = $conn->query("SELECT * FROM guestbook ORDER BY datum DESC");
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Gastenboek</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f5f5f5; padding:20px; }
        h1 { text-align:center; color:#1743e3; }

        form { background:#fff; padding:20px; border-radius:8px; margin-bottom:30px;
               box-shadow:0 4px 10px rgba(0,0,0,0.1); }

        input, textarea {
            width:100%; padding:10px; margin:8px 0;
            border:1px solid #ccc; border-radius:6px;
        }

        button {
            padding:10px 20px; background:#1743e3; color:#fff;
            border:none; cursor:pointer; border-radius:6px;
        }
        button:hover { background:#0d2bb5; }

        .bericht {
            background:#fff; border:1px solid #ccc; padding:15px;
            margin-bottom:15px; border-radius:8px;
            box-shadow:0 2px 6px rgba(0,0,0,0.05);
            position:relative;
        }

        .bericht strong { color:#1743e3; }
        .datum { font-size:12px; color:#666; }

        .delete {
            position:absolute; top:10px; right:10px;
            color:red; font-weight:bold; text-decoration:none;
            font-size:18px;
        }
        .delete:hover { color:#b30000; }
    </style>

    <!-- EmailJS -->
    <script src="https://cdn.jsdelivr.net/npm/emailjs-com@2/dist/email.min.js"></script>
    <script>
        (function(){
            emailjs.init("tXEpvWmxU_FI1cCDj");
        })();
    </script>
</head>
<body>

<h1>Gastenboek</h1>

<!-- FORMULIER -->
<form method="post" action="" id="gastenboekForm">
    <input type="text" name="naam" placeholder="Je naam" required>
    <textarea name="bericht" placeholder="Je bericht" required></textarea>
    <button type="submit">Verstuur</button>
</form>

<!-- BERICHTEN TONEN -->
<?php while ($row = $result->fetch_assoc()): ?>
    <div class="bericht">
        <a class="delete"
           href="delete.php?id=<?php echo $row['id']; ?>"
           onclick="return confirm('Weet je zeker dat je dit bericht wilt verwijderen?');">
           ✖
        </a>

        <p><strong><?php echo htmlspecialchars($row['naam']); ?></strong></p>
        <p><?php echo nl2br(htmlspecialchars($row['bericht'])); ?></p>
        <p class="datum"><?php echo $row['datum']; ?></p>
    </div>
<?php endwhile; ?>

<script>
// EmailJS versturen
document.getElementById("gastenboekForm").addEventListener("submit", function(e) {
    emailjs.send("robertwim", "template_kg3q0np", {
        from_name: document.querySelector("[name='naam']").value,
        message: document.querySelector("[name='bericht']").value
    });
});
</script>

</body>
</html>
