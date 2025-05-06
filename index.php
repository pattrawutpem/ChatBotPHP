<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>ChatGemini Bot </title>
</head>

<body>
    <div id="chatToggle" onclick="toggleChat()">💬 Chat AI</div>

    <div id="chatContainer" class="hidden">
        <button class="rounded" onclick="toggleChat()"><strong>Chat AI</strong></button>
        <div id="chatbox" class="rounded"></div>
        <div id="input-area">
            <input type="text" class="form-control" id="userInput" placeholder="Type a message">
            <button class="rounded" onclick="sendMessage()">send <i class="fa-solid fa-circle-right"></i></button>
        </div>
    </div>

    <script src="chat.js"></script>
    <script>
        function toggleChat() {
            const chat = document.getElementById('chatContainer');
            chat.classList.toggle('hidden');
        }

        document.getElementById('userInput').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                sendMessage();
            }
        });
    </script>
</body>

</html>