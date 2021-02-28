@extends('layouts.app')

@section('content')
<div class="main package-page"> 
	<section class="appointment-info till-grids">
		<h2>Subscription Plans</h2>
		<div class="grids">
			@forelse($plans as $plan)
			@if($plan->interval=='year' && $plan->interval_count=='1')
			<div class="columns">
				<ul class="price">
					<li class="header">Yearly</li>
					<li>{{ $plan->trial_period_days }} Days Free Trial Period</li>
					<li class="grey">{{ Auth::user()->currency }}{{ number_format($plan->amount/100, 2) }}</li>
					<li><a href="{{ route('change.plan',$plan->id) }}" class="button">Start Free Trial</a></li>
				</ul>
			</div>
			@elseif($plan->interval=='month' && $plan->interval_count=='1')
			<div class="columns">
				<ul class="price">
					<li class="header">Monthly</li>
					<li>{{ $plan->trial_period_days }} Days Free Trial Period</li>
					<li class="grey">{{ Auth::user()->currency }}{{ number_format($plan->amount/100, 2) }}</li>
					<li><a href="{{ route('change.plan',$plan->id) }}" class="button">Start Free Trial</a></li>
				</ul>
			</div>
			@endif
			@empty
			<p>No Plans Available</p>
			@endforelse
		</div>
	</section>
</div>
@endsection

@push('js')

@endpush