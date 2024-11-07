<header> 
        <form action="/logout" method="POST">
                <div id="head-container">
                        <button id="logout">Logout</button>
                        @csrf
                        <a href="/return/{{auth()->id()}}"><img id="profile-pic" src={{asset('images/default-avatar-icon-of-social-media-user-vector.jpg')}} alt="profile"></a>
                </div>
                <hr>
        </form>
</header>

{{$slot}}



<footer>
        <div id="footer-container">
            <ul id="footer-list">
                    <li><h3><a href="https://github.com/clietz01">Github</a></h3></li>
                    <li><h3><a href="https://www.linkedin.com/in/christian-lietz-76a36822a/">LinkedIn</a></h3></li>
                    <li><h3><a href="#">Placeholder</a></h3></li>
                    <li><h3><a href="#">Placeholder</a></h3></li>
            </ul>
    </div>
    </footer>