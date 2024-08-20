document.addEventListener('DOMContentLoaded', () => {
    const msgdiv = document.querySelector(".msg");
    const inputMsg = document.querySelector("#input_msg");
    const sendButton = document.querySelector("#send_button");

    // Function to send a new message
    function update() {
        const inputMsgValue = inputMsg.value.trim();
        if (inputMsgValue === '') {
            alert('Message cannot be empty.');
            return;
        }

        fetch(`addmsg.php?msg=${encodeURIComponent(inputMsgValue)}`)
            .then(response => {
                if (response.ok) {
                    inputMsg.value = ''; // Clear input field
                    return response.text();
                }
                throw new Error('Network response was not ok.');
            })
            .then(() => {
                loadMessages(); // Load messages after sending
            })
            .catch(error => {
                console.error('Error adding message:', error);
            });
    }

    // Function to load messages
    function loadMessages() {
        fetch("readmsg.php")
            .then(response => {
                if (response.ok) {
                    return response.text();
                }
                throw new Error('Network response was not ok.');
            })
            .then(data => {
                const wasAtBottom = msgdiv.scrollHeight - msgdiv.scrollTop === msgdiv.clientHeight;
                msgdiv.innerHTML = data;
                if (wasAtBottom) {
                    scrollToBottom(); // Scroll to bottom if user was already at the bottom
                }
            })
            .catch(error => {
                console.error('Error fetching messages:', error);
            });
    }

    // Function to scroll to the bottom of the message container
    function scrollToBottom() {
        msgdiv.scrollTop = msgdiv.scrollHeight;
    }

    // Load messages when the page loads and set an interval to refresh messages
    loadMessages();
    setInterval(loadMessages, 3000); // Refresh messages every 3 seconds

    // Add messages to the database when Enter key is pressed
    window.addEventListener('keydown', (e) => {
        if (e.key === "Enter") {
            update();
        }
    });

    // Send message when Send button is clicked
    sendButton.addEventListener('click', update);
});
