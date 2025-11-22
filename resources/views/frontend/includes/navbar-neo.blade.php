<header class="navbar-neo">
    <div class="row-neo navbar-neo__container">
        <a class="navbar-neo__logo" href="#top">
            <img src="{{ asset('images/mylogo.png') }}" alt="Newlife Logo" class="site-logo">
        </a>

        <button class="hamburger-btn" aria-label="Menu" aria-expanded="false">
            <span class="hamburger-btn__line"></span>
            <span class="hamburger-btn__line"></span>
            <span class="hamburger-btn__line"></span>
        </button>
        
        <div class="mobile-nav">
            <nav class="navbar-neo__nav">
                <ul class="navbar-neo__links">
                    <li><a href="#hero">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#connect">Connect</a></li>
                    <li>
                        <a href="/my-admin" class="admin-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </a>
                    </li>
                    <li>
                        <button id="theme-switcher" class="theme-switcher-btn">
                            <svg class="sun" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                            <svg class="moon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
