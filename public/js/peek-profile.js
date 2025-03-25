let userElements = document.querySelectorAll('.hashed_name');
let peek = document.getElementById('profile-preview');
let backBtn = document.getElementById('preview-exit');
let mainContent = document.getElementById('main-content');

peek.style.display = "none";

userElements.forEach((userElem) => {

    userElem.addEventListener('click', () => {


        let userId = userElem.dataset.userId;
        let userPic = userElem.dataset.userPic;
        let userLikes = userElem.dataset.userLikes;
        let username = userElem.dataset.username;


        document.getElementById('preview-usr').innerHTML = `<span style="color: rebeccapurple;">${username}</span>`;
        document.getElementById('preview-pfp').src = userPic;
        document.getElementById('preview-likes'). innerHTML = `Total ❤️: ${userLikes}`;




        peek.style.display = '';
        mainContent.classList.add('blur');
    });

});

backBtn.addEventListener('click', ()=> {

    peek.style.display = 'none';
    mainContent.classList.remove('blur');
});

