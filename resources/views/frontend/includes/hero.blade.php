<!-- hero
================================================== -->
<section class="s-hero" data-parallax="scroll" data-image-src="images/hero-bg-3000.jpg" data-natural-width=3000 data-natural-height=2000 data-position-y=center>

    <div class="hero-left-bar"></div>

    <div class="row hero-content">

        <div class="column large-full hero-content__text">
            @php
            $banner_message = "Making Jesus Known<br>Building Strong<br>Local Church";
             @endphp
            <h1>
                {!! $banner_message !!}
            </h1>

            <div class="hero-content__buttons">
                @livewire('new-member-button')
                <a href="about.html" class="btn btn--stroke">About Us</a>
            </div>
        </div> <!-- end hero-content__text -->
        @livewire('create-member-modal')

    </div> <!-- end hero-content -->

    <ul class="hero-social">
        <li class="hero-social__title">Follow Us</li>
        <li>
            <a href="#0" title="">Facebook</a>
        </li>
        <li>
            <a href="#0" title="">YouTube</a>
        </li>
        <li>
            <a href="#0" title="">Instagram</a>
        </li>
    </ul> <!-- end hero-social -->

    <div class="hero-scroll">
        <a href="#about" class="scroll-link smoothscroll">
            Scroll For More
        </a>
    </div> <!-- end hero-scroll -->

</section> <!-- end s-hero -->
