
function sendMessage() {
    const input = document.getElementById('userInput');
    const message = input.value.trim();
    if (message === '') return;

    const chatbox = document.getElementById('chatbox');
    chatbox.innerHTML += `<div class ="text-end mb-3"><strong>You:</strong><br> <div style="display: inline-block; background-color: #0dcaf0; padding: 10px; border-radius: 12px; color: white;">${message}</div></div>`;
    input.value = "";

    fetch('api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ message: message })
    })
    .then(res => res.json())
    .then(data => {
        if (data.reply) {
            chatbox.innerHTML += `<div class = "mb-3"><strong>Ai :</strong> <br> <div style="display: inline-block; background-color: #ACACACFF; padding: 10px; border-radius: 12px; color: white;">${data.reply}</div></div>`;
        } else {
            chatbox.innerHTML += `<div class = "mb-3"><strong>Ai :</strong> <div style="display: inline-block; background-color: ##ACACACFF; padding: 10px; border-radius: 12px; color: white;">ไม่ได้รับคำตอบจาก API</div></div>`;
        }
        chatbox.scrollTop = chatbox.scrollHeight;
    })
    .catch(error => {
        chatbox.innerHTML += `<div class = "mb-3"><strong>Ai :</strong> <div style="display: inline-block; background-color: ##ACACACFF; padding: 10px; border-radius: 12px; color: white;">เกิดข้อผิดพลาด</div></div>`;
        console.error(error);
    });
}
