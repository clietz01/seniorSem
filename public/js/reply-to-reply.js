// reply-to-reply.js
document.querySelectorAll(".reply-reply-button").forEach(replyButton => {
    replyButton.addEventListener('click', () => {
        // Hide the reply button to avoid duplicate inputs
        replyButton.style.display = 'none';

        // Locate the closest comment element and the nested replies container
        const commentElement = replyButton.closest("li");
        const replyContainer = commentElement.querySelector("ul") || document.createElement('ul'); // Use existing <ul> or create a new one

        // Add the <ul> to the comment if it doesn't already exist
        if (!commentElement.querySelector("ul")) {
            commentElement.appendChild(replyContainer);
        }

        // Create the reply form elements
        const replyBody = document.createElement('li');
        const textArea = document.createElement('textarea');
        const postButton = document.createElement('button');
        postButton.textContent = 'Post';

        // Append the form elements
        replyBody.appendChild(textArea);
        replyBody.appendChild(postButton);
        replyContainer.appendChild(replyBody);

        // Handle the reply submission
        postButton.addEventListener('click', async () => {
            const content = textArea.value;
            const replyId = replyButton.dataset.replyId;

            if (!content.trim()) {
                alert("Reply content cannot be empty.");
                return;
            }

            try {
                // Send the reply via AJAX
                const response = await fetch(`/replies/${replyId}/reply`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ content }),
                });

                if (response.ok) {
                    const newReply = await response.json();

                    // Create and append the new reply element
                    const newReplyElement = document.createElement('li');
                    newReplyElement.innerHTML = `
                        <div class="comment-content">
                            <div class="comment-header">
                                <p>Created by</p>
                                <p class="display-name">${newReply.user.name}</p>
                            </div>
                            <div id="comment-body-container">
                                <div class="comment-body">
                                    <p>${newReply.content}</p>
                                </div>
                                <div id="timestamp">
                                    <p>${newReply.created_at}</p>
                                </div>
                                <button class="reply-reply-button" data-reply-id="${newReply.id}">Reply</button>
                            </div>
                        </div>
                    `;
                    replyContainer.appendChild(newReplyElement);

                    // Clean up the reply form
                    replyBody.remove();
                    replyButton.style.display = 'inline';
                } else {
                    throw new Error("Failed to post reply.");
                }
            } catch (error) {
                console.error("Error:", error);
                alert("An error occurred while posting the reply.");
            }
        });
    });
});
