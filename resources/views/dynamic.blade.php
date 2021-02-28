@extends('layouts.app')
@section('content') 
<div class="about-page-main">
  <section class="about-wrap">
    <div class="container">
      <div class="grids">
        @foreach ($pages as $page)
        <div class="grid">
          <div class="left-content">
            <img src="{{ asset('public/front/images/login-bg.jpeg') }}" alt="login-bg">
          </div>
          <div class="right-content">
            <h2>{{ ucfirst($page->title) }}</h2>
            <div class="detail-text">
              {{ $page->content }}
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
</div>
@endsection