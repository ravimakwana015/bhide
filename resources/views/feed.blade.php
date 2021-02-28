@extends('layouts.app')
@section('content')
<div class="main feed-page profile-page">
  <div class="custom-container">
    <div class="feed-main-wrap">
      {{-- <div class="name-header">
        <h2>Sophie March</h2>
      </div>
      <div class="profile-wrap actor">
        <div class="grid">
          <div class="img-bio">
            <div class="img-wrap">
              <img src="images/profile-pic.png" alt="profile-pic">
            </div>
            <div class="self-bio">
              <p>"I study abroad just by myself, I think it is great to challenge yourself and travel to places you have never been and try to survive there. I didn't know of a word of chinese when I first came here but now I can at least order food and talk to the driver."</p>
            </div>
          </div>
          <ul class="multipoint qualities">
            <li>Kind</li>
            <li>Acheiver</li>
            <li>Charming</li>
          </ul>
          <div class="self-detail">
            <div class="type">Gender: <span class="ans">Male</span></div>
            <div class="type">Age: <span class="ans">19</span></div>
            <div class="type">Genre: <span class="ans">Action, Thriller, Fantasy</span></div>
            <div class="type">Status: <span class="ans">Available</span></div>
            <div class="type">Language: <span class="ans">English, Spanish</span></div>
            <div class="type">Accents: <span class="ans">Standard, American, Irish</span></div>
          </div>
        </div>
      </div> --}}
      <div class="feed-wrap">
        <div class="create-post-wrap">
          <h2>Create Post</h2>
          <div class="write-post">
            <div class="pro_img">
              <img src="{{ asset('public/front/images/profile.jpeg') }}" alt="chat-pro-img">
            </div>
            <textarea placeholder="Write something here..."></textarea>
          </div>
          <div class="btn-wrap">
            <button class="btn">Post</button>
          </div>
        </div>
        <div class="feed-post">
          <div class="pro-detail">
            <div class="pro_img">
              <img src="{{ asset('public/front/images/profile.jpeg') }}" alt="chat-pro-img">
            </div>
            <div class="pro_name">
              <h3>Mike</h3>
              <span class="desig">Musician</span>
              <span class="date-time">10 Mins</span>
            </div>
          </div>
          <div class="post_wrap">
            <p>Hollywood Robs Icelandic Musician Of His Star</p>
          </div>
          <div class="like_here">
            <div class="like-comment">
              <span class="icon"><i class="far fa-heart"></i>
              </span>
              <span>36</span>
            </div>
            <div class="like-comment">
              <span class="icon">
                <i class="far fa-comment-dots"></i>
              </span>
              <span>2</span>
            </div>
          </div>
        </div>
        <div class="feed-post liked">
          <div class="pro-detail">
            <div class="pro_img">
              <img src="{{ asset('public/front/images/profile.jpeg') }}" alt="chat-pro-img">
            </div>
            <div class="pro_name">
              <h3>Nik</h3>
              <span class="post-info">Update his profile picture.</span>
              <span class="desig">Musician</span>
              <span class="date-time">10 PM Yesterday</span>
            </div>
          </div>
          <div class="post_wrap profile_pic">
            <img src="{{ asset('public/front/images/profile.jpeg') }}" alt="profile-pic">
          </div>
          <div class="like_here">
            <div class="like-comment">
              <span class="icon"><i class="fas fa-heart"></i>
              </span>
              <span>37</span>
            </div>
            <div class="like-comment">
              <span class="icon">
                <i class="far fa-comment-dots"></i>
              </span>
              <span>2</span>
            </div>
          </div>
        </div>
        <div class="feed-post">
          <div class="pro-detail">
            <div class="pro_img">
              <img src="{{ asset('public/front/images/profile.jpeg') }}" alt="chat-pro-img">
            </div>
            <div class="pro_name">
              <h3>Nik</h3>
              <span class="desig">Musician</span>
              <span class="date-time">Dec 02 at 8:30 PM</span>
            </div>
          </div>
          <div class="post_wrap">
            <p>Ariel Winter Celebrates 'HumpDay' with sexy Dance Moves...</p>
          </div>
          <div class="like_here">
            <div class="like-comment">
              <span class="icon"><i class="far fa-heart"></i>
              </span>
              <span>36</span>
            </div>
            <div class="like-comment">
              <span class="icon">
                <i class="far fa-comment-dots"></i>
              </span>
              <span>2</span>
            </div>
          </div>
        </div>
        <div class="feed-post commented">
          <div class="pro-detail">
            <div class="pro_img">
              <img src="{{ asset('public/front/images/profile.jpeg') }}" alt="chat-pro-img">
            </div>
            <div class="pro_name">
              <h3>Nik</h3>
              <span class="desig">Musician</span>
              <span class="date-time">Nov 30 2018 at 10:30 AM</span>
            </div>
          </div>
          <div class="post_wrap">
            <img src="{{ asset('public/front/images/profile.jpeg') }}" alt="models-bg">
          </div>
          <div class="like_here">
            <div class="like-comment">
              <span class="icon"><i class="far fa-heart"></i>
              </span>
              <span>36</span>
            </div>
            <div class="like-comment">
              <span class="icon">
                <i class="fas fa-comment-dots"></i>
              </span>
              <span>3</span>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection