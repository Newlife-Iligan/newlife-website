@extends('frontend.layouts.master')

@section('content')

    <!-- hero
    ================================================== -->
    <section id="hero" class="s-section target-section">
        <div class="hero-shape shape1"></div>
        <div class="hero-shape shape2"></div>
        <div class="hero-shape shape3"></div>
        <div class="row-neo hero-content">
            <div class="column large-full">
                <h1 class="reveal-on-scroll">
                    A New Life in Christ. <br>
                    A New Community to Belong.
                </h1>
                <p class="lead reveal-on-scroll">
                    Welcome to Hesed! We are a vibrant community of believers passionate about
                    loving God and loving people. Explore what's new and get connected.
                </p>
                <div class="hero-content__buttons reveal-on-scroll">
                    <a href="#about" class="btn-neo btn-neo-primary">Learn More</a>
                    <a href="#connect" class="btn-neo">Get Connected</a>
                </div>
            </div>
        </div>
    </section> <!-- end s-hero -->

    <!-- about
    ================================================== -->
    <section id="about" class="s-section">
        <div class="row-neo">
            <div class="column large-half medium-full reveal-on-scroll">
                <div class="card-neo">
                    <h3 class="subhead">Welcome to Hesed</h3>
                    <p class="lead">
                        We are a church that believes in the power of God's love and the strength of community.
                        Our doors are always open to people from all backgrounds.
                    </p>
                    <a href="#" class="btn-neo">More About Us</a>
                </div>
            </div>

            <div class="column large-half medium-full reveal-on-scroll">
                 <div class="card-neo">
                    <h4>Main Church Service</h4>
                    <p>
                        Sunday - 9:00 AM | 1:00 PM | 4:30 PM <br>
                        1600 Amphitheatre Parkway, Mt. View, CA, 94043
                    </p>
                </div>
            </div>
        </div>
    </section> <!-- end s-about -->


    <!-- connect
    ================================================== -->
    <section id="connect" class="s-section">
        <div class="row-neo connect-content">
            <div class="column large-half tab-full reveal-on-scroll">
                <div class="card-neo">
                    <h3 class="display-1">Volunteer With Us.</h3>
                    <p>
                       Make a difference. Join one of our ministry teams and use your gifts to serve others.
                    </p>
                    <a href="#" class="btn-neo btn-neo-primary h-full-width">I'm Interested</a>
                </div>
            </div>
            <div class="column large-half tab-full reveal-on-scroll">
                <div class="card-neo">
                    <h3 class="display-1">Join a Life Group.</h3>
                    <p>
                        Do life together. Our life groups are small communities where you can build relationships and grow in your faith.
                    </p>
                    <a href="#" class="btn-neo h-full-width">Learn More</a>
                </div>
            </div>
        </div>
    </section> <!-- end s-connect -->

@endsection