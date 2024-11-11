const postContainer = document.getElementById('post-container');
const editButton = document.getElementById('edit-post-button');
const body = document.getElementById('post-body');
const postId = editButton.dataset.postId;

editButton.addEventListener('click', () => {
  const text = body.textContent;

  body.style.display = 'none'; //crucial for displaying body while updating posts

  const textarea = document.createElement('textarea');
  textarea.value = text;

  const postButton = document.createElement('button');
  postButton.textContent = "Post";

  postButton.addEventListener('click', () => {
    const updatedContent = textarea.value;
    

    fetch(`/posts/${postId}`, {
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
      if (data.success) {
        body.textContent = updatedContent;
        body.style.display = ''; //crucial for showing the body while updating
        alert('Post updated successfully!');
        textarea.remove();
        postButton.remove();
      } else {
        alert('Error updating post.');
      }
    })
    .catch(error => {
      console.error('Error', error);
      alert('Error Updating Post');
    }); 
  });

  
  postContainer.appendChild(textarea);
  postContainer.appendChild(postButton);

});