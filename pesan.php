<?php
$filename = "messages.txt";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["delete"])) {
        file_put_contents($filename, ""); 
    } elseif (isset($_POST["search"])) {
        $search_query = htmlspecialchars($_POST["search_query"]);
    } else {
        $recipient = htmlspecialchars($_POST["recipient"]);
        $message = htmlspecialchars($_POST["message"]);
        if (!empty($message) && !empty($recipient)) {
            $entry = "$recipient: Anonim - $message" . PHP_EOL;
            file_put_contents($filename, $entry, FILE_APPEND);
        }
    }
}

$messages = file_exists($filename) ? file($filename, FILE_IGNORE_NEW_LINES) : [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>TALKS SPACE</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #fce4ec; text-align: center; }
        nav { margin-bottom: 20px; }
        nav a { margin-right: 10px; text-decoration: none; color: blue; }
        form { margin-bottom: 20px; display: inline-block; text-align: left; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); }
        h1, h2 { color: #d63384; }
        p { color: #a83264; font-size: 18px; }
        .hidden { display: none; }
    </style>
    <script>
        function toggleMessages() {
            var messagesDiv = document.getElementById("messages");
            if (messagesDiv.classList.contains("hidden")) {
                messagesDiv.classList.remove("hidden");
            } else {
                messagesDiv.classList.add("hidden");
            }
        }
    </script>
</head>
<body>
    <h1>Teleform</h1>
    <form method="POST">
        <label>Receiver : <input type="text" name="recipient" required></label><br><br>
        <label>Message: <textarea name="message" required></textarea></label><br><br>
        <button type="submit">Send</button>
    </form>
    <form method="POST">
        <button type="submit" name="delete">Delete</button>
    </form>
    <h2>Find Messages</h2>
    <form method="POST">
        <input type="text" name="search_query" placeholder="Find by Receiver" required>
        <button type="submit" name="search">Search</button>
    </form>
    <button onclick="toggleMessages()">Show or Hide</button>
    <div id="messages" class="hidden">
        <?php 
        foreach ($messages as $msg) {
            if (isset($search_query)) {
                if (stripos($msg, $search_query . ":") !== false) {
                    echo "<p>$msg</p>";
                }
            } else {
                echo "<p>$msg</p>";
            }
        }
        ?>
    </div>
</body>
</html>
