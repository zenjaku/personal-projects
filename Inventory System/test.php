<?php
// Load the .env file
require_once 'vendor/autoload.php';
// Dotenv\Dotenv::createImmutable(__DIR__)->load();


// Start the session
// session_start();

// Fetch credentials from the environment

// try {
//     Dotenv\Dotenv::createImmutable(__DIR__)->load();

//     $validUsername = $_ENV['DB_USERNAME'];

//     $validPasswordHash = $_ENV['DB_PASSWORD'];

//     echo "<h1>$validUsername</h1>";

//     echo "<h1>$validPasswordHash</h1>";

//     $hashed = password_hash("Admin!12345", PASSWORD_DEFAULT);


//     echo "<h1>$hashed</h1>";

//     // Test the getenv() function
//     // echo getenv('DB_USERNAME') ? 'Username found' : 'No username detected';

//     if(isset($_POST["submit"])) {
//         $pw = $_POST["pw"];

//         if(password_verify($pw, $validPasswordHash)) {
//             echo "<h1>working</h1>";
//         }
//     }


//     if ($validUsername) {
//         echo "<script> console.log('$validUsername'); </script>";
//     } else {
//         echo "<script> console.log('No username detected'); </script>";
//     }
// } catch (Exception $e) {
//     echo "Error loading .env file: " . $e->getMessage();
// }
// // require_once 'vendor/autoload.php';

// // Dotenv\Dotenv::createImmutable(__DIR__)->load();

// // // Print all environment variables for debugging
// // echo "<pre>";
// // print_r($_ENV);
// // echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .chat-container {
            width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .messages {
            height: 300px;
            overflow-y: scroll;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .input-container {
            display: flex;
            margin-top: 10px;
        }

        input {
            flex: 1;
            padding: 10px;
        }

        button {
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="chat-container">
        <div class="messages" id="messages"></div>
        <div class="input-container">
            <input type="text" id="userMessage" placeholder="Type a message...">
            <button type="button" onclick="sendMessage()">Send</button>
        </div>
    </div>

    <script>
        function sendMessage() {
            let userMessage = document.getElementById("userMessage").value;
            if (!userMessage) return;

            let chatBox = document.getElementById("messages");
            chatBox.innerHTML += `<p><strong>You:</strong> ${userMessage}</p>`;

            document.getElementById("userMessage").value = ""; // Clear input

            fetch("bot.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `message=${encodeURIComponent(userMessage)}`
            })
                .then(response => response.text())
                .then(data => {
                    chatBox.innerHTML += `<p><strong>Bot:</strong> ${data}</p>`;
                    chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll
                })
                .catch(error => {
                    console.error("Error:", error);
                    chatBox.innerHTML += `<p><strong>Error:</strong> Something went wrong!</p>`;
                    chatBox.scrollTop = chatBox.scrollHeight;
                });
        }
    </script>
</body>

</html>


<!-- <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>

        <body>
            <form action="" method="post">
                <input type="text" name="pw">
                <button type="submit" name="submit">submit</button>
            </form>
        </body>

        </html> -->