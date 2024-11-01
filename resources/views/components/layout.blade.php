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
        
</footer>