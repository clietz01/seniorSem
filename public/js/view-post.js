
const postContainer = document.getElementById('post-container');
const editButton = document.getElementById('edit-post-button');
const body = document.getElementById('post-body');
const postId = editButton.dataset.postId;

document.addEventListener("DOMContentLoaded", function() {


  if (editButton) {
      const postContainer = document.getElementById('post-container');
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

  }});

/*
  document.addEventListener("DOMContentLoaded", function() {
    const editButton = document.getElementById('edit-post-button');

    if (!editButton) {
      return;
    }

    const postContainer = document.getElementById('post-container');
    const body = document.getElementById('post-body');
    const postId = editButton.dataset.postId;

    editButton.addEventListener('click', () => {
      const text = body.textContent;

      body.style.display = 'none';

      // Create textarea with specific styling to match your design
      const textarea = document.createElement('textarea');
      textarea.value = text;

      // Explicitly apply styles to match your existing design
      textarea.style.width = '100%';
      textarea.style.backgroundColor = '#222222';
      textarea.style.color = 'white';
      textarea.style.padding = '15px';
      textarea.style.border = '1px solid #ccc';
      textarea.style.borderRadius = '5px';
      textarea.style.fontSize = 'inherit';
      textarea.style.fontFamily = 'inherit';
      textarea.style.resize = 'vertical';

      const postButton = document.createElement('button');
      postButton.textContent = "Post";

      // Ensure button matches your existing button styles
      postButton.style.backgroundColor = '#74000a';
      postButton.style.color = 'white';
      postButton.style.border = 'none';
      postButton.style.padding = '5px 10px';
      postButton.style.marginTop = '5px';
      postButton.style.borderRadius = '5px';
      postButton.style.cursor = 'pointer';

      postButton.addEventListener('mouseenter', () => {
        postButton.style.backgroundColor = '#4e0000';
      });

      postButton.addEventListener('mouseleave', () => {
        postButton.style.backgroundColor = '#74000a';
      });

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
            body.style.display = '';
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
  });
*/
