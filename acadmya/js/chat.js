// chat.js

document.addEventListener('DOMContentLoaded', function () {
    const chatForm = document.getElementById('chat-form');
    const chatContainer = document.getElementById('chat-container');

    function fetchMessages() {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    chatContainer.innerHTML = xhr.responseText;
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                } else {
                    console.error('Error fetching messages:', xhr.status, xhr.statusText);
                }
            }
        };
        xhr.open('GET', 'fetch_messages.php?course_id=' + document.getElementById('course_id').value, true);
        xhr.send();
    }

    chatForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(chatForm);
        const xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    fetchMessages();
                    chatForm.reset();
                } else {
                    console.error('Error sending message:', xhr.status, xhr.statusText);
                }
            }
        };

        xhr.open('POST', chatForm.action, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(new URLSearchParams(formData).toString());
    });

    // Fetch messages initially and set interval for fetching messages
    fetchMessages();
    setInterval(fetchMessages, 3000); // Fetch new messages every 3 seconds
});