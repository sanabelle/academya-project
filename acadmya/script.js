document.getElementById("chatForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission

    // Get form data
    var user = document.getElementById("user").value;
    var message = document.getElementById("message").value;

    // Create XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Define what happens on successful data submission
    xhr.onload = function() {
        if (xhr.status == 200) {
            // Refresh messages
            getMessages();
            // Clear input fields
            document.getElementById("user").value = "";
            document.getElementById("message").value = "";
        }
    };

    // Prepare and send the request
    xhr.open("POST", "send_message.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("user=" + encodeURIComponent(user) + "&message=" + encodeURIComponent(message));
});

// Function to fetch and display messages
function getMessages() {
    // Create XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Define what happens on successful data retrieval
    xhr.onload = function() {
        if (xhr.status == 200) {
            // Display messages
            document.getElementById("chat-messages").innerHTML = xhr.responseText;
            // Scroll to the bottom of the chat
            document.getElementById("chat-messages").scrollTop = document.getElementById("chat-messages").scrollHeight;
        }
    };

    // Prepare and send the request
    xhr.open("GET", "get_messages.php", true);
    xhr.send();
}

// Fetch and display messages on page load
getMessages();

// Refresh messages every 3 seconds
setInterval(getMessages, 3000);
