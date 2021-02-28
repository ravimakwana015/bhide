@extends('layouts.app')
@section('content') 
<div class="features-page-main">
  <section class="features-wrap">
    <div class="container">
      <div class="grids">
        @if(isset($features))
        @foreach($features as $feature)
        <div class="grid">
          <img src="{{ asset('public/front') }}/features_image/{{ $feature->feature_image }}">
          <h2>{{ $feature->title }}</h2>
          @php
          $subtitles = json_decode($feature->subtitle);
          $contents = json_decode($feature->content);
          $mainarray = array_combine($subtitles,$contents);
          @endphp
          <div class="detail-text">
          @foreach($mainarray as $key => $array)
          <h3>{{ $key }} </h3>
          <p>{{ $array }} </p>
          @endforeach
          </div>
          
          {{-- {!! json_decode($feature->content) !!} --}}
        </div>
        @endforeach
        @endif
      </div>
    </div>
  </section>
</div>
@endsection