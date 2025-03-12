<header>
        <div id="head-container">
            <!-- Logout Button -->
            <form action="/logout" method="POST" style="margin: 0;">
                @csrf
                <button id="logout">Logout</button>
            </form>
    
            <!-- Profile Picture -->
            <a href="/return/{{auth()->id()}}">
                @if ($user->profile_picture)
                    <img id="profile-pic" src="{{ secure_asset('storage/' . $user->profile_picture) }}" alt="Profile Picture">
                @else
                    <img id="profile-pic" src="{{ secure_asset('images/default-profile-pic.jpg') }}" alt="Default Profile Picture">
                @endif
            </a>
        </div>
        <hr>
    </header>
    
    {{ $slot }}
    
    <footer>
        <div id="footer-container">
            <ul id="footer-list">
                <li><h3><a href="https://github.com/clietz01" target="_blank">Github</a></h3></li>
                <li><h3><a href="https://www.linkedin.com/in/christian-lietz-76a36822a/" target="_blank">LinkedIn</a></h3></li>
                <li><h3><a href="/support">Support</a></h3></li>
            </ul>
        </div>
    </footer>
    
