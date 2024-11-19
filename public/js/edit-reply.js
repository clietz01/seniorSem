// Select all edit buttons
const replyButtons = document.querySelectorAll(".edit-reply-button"); 

replyButtons.forEach(replyButton => {
    replyButton.addEventListener('click', () => {
        // Get the parent with class "comment-content"
        const commentContent = replyButton.closest(".comment-content"); 
        // Get the comment body within the content
        const body = commentContent.querySelector(".comment-body"); 
        const editId = replyButton.dataset.editId;
        const text = body.textContent;

        body.style.display = 'none';
        const textArea = document.createElement('textarea');
        textArea.value = text; 

        const postButton = document.createElement('button');
        postButton.textContent = 'Post'; // Use textContent instead of value for button text

        postButton.addEventListener('click', () => {
            const updatedContent = textArea.value;

            fetch(`posts/replies/${editId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    body: updatedContent
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    body.textContent = updatedContent;
                    body.style.display = '';
                    alert('Reply updated successfully!');
                    textArea.remove();
                    postButton.remove();
                } else {
                    alert('Error updating reply');
                }
            })
            .catch(error => {
                console.error('Error', error);
                alert('Error updating reply');
            });
        });

        commentContent.appendChild(textArea);
        commentContent.appendChild(postButton);
    });
});