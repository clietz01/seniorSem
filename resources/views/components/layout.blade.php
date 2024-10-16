<header> 
        <form action="/logout" method="POST">
                <button id="logout">Logout</button>
                @csrf
                <img src="components/default-avatar-icon-of-social-media-user-vector.jpg" alt="profile">
                <hr>
        </form>
</header>

{{$slot}}

<footer>
        
</footer>