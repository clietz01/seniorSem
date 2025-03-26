let userElements = document.querySelectorAll('.hashed_name');
let peek = document.getElementById('profile-preview');
let backBtn = document.getElementById('preview-exit');
let mainContent = document.getElementById('main-content');
let relPosts = document.getElementById('relative-posts-list');

peek.style.display = "none";

document.addEventListener('DOMContentLoaded', () => {

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


    navigator.geolocation.getCurrentPosition(position => {

        const {latitude, longitude} = position.coords;

        userElements.forEach((userElem) => {

            userElem.addEventListener('click', () => {

                //let filteredPosts = [];

                let userId = userElem.dataset.userId;
                let userPic = userElem.dataset.userPic;
                let userLikes = userElem.dataset.userLikes;
                let username = userElem.dataset.username;


                document.getElementById('preview-usr').innerHTML = `<span style="color: rebeccapurple;">${username}</span>`;
                document.getElementById('preview-pfp').src = userPic;
                document.getElementById('preview-likes'). innerHTML = `Total ❤️: ${userLikes}`;

                fetch('/posts/location', {
                    method: "POST",
                    headers: {'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ latitude, longitude, userId})
                }).then(response => response.json())
                .then(posts => {
                    console.log("Fetched Posts: ", posts);

                    relPosts.innerHTML = ''; // Clear previous posts
                    posts.forEach(post => {

                        let li = document.createElement('li');
                        let a = document.createElement('a');
                        a.href = "/posts/" + post.id;
                        a.textContent = post.title;
                        li.appendChild(a)
                        relPosts.appendChild(li);
                    });

                }).catch(error => {
                    console.error("error fetching posts", error)
                });







                peek.style.display = '';
                mainContent.classList.add('blur');



            });

        });

        backBtn.addEventListener('click', ()=> {

            peek.style.display = 'none';
            mainContent.classList.remove('blur');
        });
    });



});


