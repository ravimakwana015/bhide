@extends('layouts.app')

@section('content')
<div class="main dashboard-page profile-edit-page">
	@if ($message = Session::get('success'))
	<div class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>{{ $message }}</strong>
	</div>
	@endif
	<div class="subscription-page">
		<div class="col-12 mb-3" style="padding-left: 0px;">
			<a class="btn" href="{{ route('home') }}"><i class="fas fa-arrow-left"></i> Back</a>
		</div>
		<div class="card shadow">
			<div class="card-header">
				<h3 class="mb-0">My Membership</h3>
			</div>
			@if(isset($plan))
			<div class="card-body">  
				<div class="account">
					<div class="text">
						<h4>Active Membership</h4>
						@if(isset($plan) && $plan->interval=='year' && $plan->interval_count=='1')
						<span>Yearly - (£{{ number_format($plan->amount/100, 2) }}  Yearly)</span>
						@elseif(isset($plan) && $plan->interval=='month' && $plan->interval_count=='1')
						<span>Monthly - (£{{ number_format($plan->amount/100, 2) }} Monthly)</span>
						@elseif(isset($plan) )
						<span>Quarterly - (£{{ number_format($plan->amount/100, 2) }} Quertarly)</span>
						@endif
						@if(Auth::user()->owner->stripe_id!=Auth::user()->username)
						@if (Auth::user()->subscription('main')->onGracePeriod())
						<br/>
						<span>Your Subscription Ends At - {{ date('F d Y',strtotime(Auth::user()->owner->ends_at)) }}</span>
						@endif
						@endif
					</div>
					@if (Auth::user()->subscription('main')->onGracePeriod())
					<a href="{{ route('resume-membership') }}" class="btn btn-small resume-membership">Resume Membership</a>
					@else
					<a href="javascript:" class="btn btn-small cancle-membership" id="conform-member">Cancel Membership</a>
					@endif
					@if(Auth::user()->owner->trial_ends_at!='' && Auth::user()->planid!='')
					<a href="{{ route('get.payment.trail',Auth::user()->planid) }}" class="btn btn-small">Activate Membership</a>
					@endif
				</div>
				@if(Auth::user()->owner->trial_ends_at!='')
				<div class="account">
					<div class="text">
						<h4>Trail Period Ends</h4>
						<span>{{ date('dS M Y H:i A',strtotime(Auth::user()->owner->trial_ends_at)) }}</span>
					</div>
				</div>
				@endif

				<div class="account">
					<div class="text">
						<h4>Current Period Ends</h4>
						<span>{{ date('dS M Y H:i A',$subscription->current_period_end) }}</span>
					</div>
				</div>
				<div class="account">
					<div class="text">
						<h4>Card Details</h4>
						@if(isset(Auth::user()->card_brand) && Auth::user()->card_brand!='')
						<span>{{ ucfirst(Auth::user()->card_brand) }} </span>
						@else
						<span>N/A</span>
						@endif
					</div>
				</div>
				<div class="account">
					<div class="text">
						<h4>{{ ucfirst(Auth::user()->card_brand) }} Ending</h4>
						@if(isset(Auth::user()->card_last_four) && Auth::user()->card_last_four!='')
						<span>{{ ucfirst(Auth::user()->card_last_four) }} </span>
						@else
						<span>N/A</span>
						@endif
					</div>
				</div>
			</div>
			@else
			<div class="card-body">  
				<div class="account">
					<div class="text">
						<h4>Active Membership</h4>
						
						<span style="color: red;">Active Subscription</span>
						
					</div>
				</div>
			</div>
			@endif
		</div>
	</br>
	@if(isset($plan))
	<div class="card shadow">
		<div class="card-header">
			<h3 class="mb-0">Payment Methods</h3>
		</div>
		<div class="card-body">
			<button type="button" class="mb-3 btn btn-small btn-greyt" style="float: right;" id="addCard"><i class="fas fa-plus"></i> Add card</button>
			<div class="table-responsive">
				@include('subscription.card')
			</div>
		</div>
	</div>
	@endif
</div>
</div>

<div class="modal fade" id="myconformModal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Smile Scan</h4>
			</div>
			<div class="modal-body">
				<h5>Are you sure you would like to cancel your membership ?</h5>
				<form action="{{ route('cancle-membership') }}" method="post">
					@csrf
					{{-- <div class="form-item">
						<textarea name="feedback" placeholder="Reason for cancel your membership"></textarea>
					</div> --}}
					<button type="submit" class="btn btn-small cancle-membership">Yes I’m Sure</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="addCardModal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add a card</h4>
			</div>
			<div class="modal-body">
				{!! Form::open(['url' => route('add-card'), 'data-parsley-validate', 'id' => 'card-form']) !!}
				<div id="card-error-msg"></div>
				<div id="card-success-msg"></div>
				<input type="hidden" id="card-url" value="{{ route('add-card') }}">
				<input type="hidden" id="card-redirect_url" value="{{ route('subscription') }}">
				<br/>
				<div class="form-item">
					<label>Credit Card Number</label>
					{!! Form::text('number', null, ['class'=> 'form-control','required'=> 'required','data-stripe'=> 'number','data-parsley-type'=> 'number','maxlength'=> '16','data-parsley-trigger'=> 'change focusout','data-parsley-class-handler'=> '#cc-group']) !!}
				</div>
				<div class="form-item">
					<label>MM</label>
					{!! Form::selectMonth('exp_month', null, ['required'=> 'required','data-stripe'=> 'exp-month'], '%m') !!}
				</div>
				<div class="form-item">
					<label>YYYY</label>
					{!! Form::selectYear('exp_year', date('Y'), date('Y') + 10, null, ['required'=> 'required','data-stripe'       => 'exp-year']) !!}
				</div>
				<div class="form-item">
					<label>CVC/CVV</label>
					{!! Form::text('cvc', null, ['required'=> 'required','data-stripe'=> 'cvc','data-parsley-type'=> 'number','data-parsley-trigger'=> 'change focusout','maxlength'=> '4','data-parsley-class-handler'=> '#ccv-group','placeholder'=> '3 or 4 digits code']) !!}
				</div>
				<div class="form-action">
					{!! Form::submit('Add card', ['class' => 'btn', 'id' => 'submitBtn', 'style' => 'margin-top: 20px;']) !!}
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="updateCardModal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Update a card</h4>
			</div>
			<div class="modal-body">
				{!! Form::open(['url' => route('update-card'), 'data-parsley-validate', 'id' => 'update-card-form']) !!}
				<div id="update-card-error-msg"></div>
				<input type="hidden" id="update-card-url" value="{{ route('update-card') }}">
				<input type="hidden" id="update-card-redirect_url" value="{{ route('subscription') }}">
				<div class="form-item">
					<label>MM</label>
					{!! Form::selectMonth('exp_month', null, ['required'=> 'required','data-stripe'=> 'exp-month','id'=>'exp_month'], '%m') !!}
				</div>
				<div class="form-item">
					<label>YYYY</label>
					{!! Form::selectYear('exp_year', date('Y'), date('Y') + 10, null, ['required'=> 'required','data-stripe'=> 'exp-year','id'=>'exp_year']) !!}
				</div>
				<div class="form-action">
					{!! Form::submit('Update', ['class' => 'btn', 'id' => 'updateBtn', 'style' => 'margin-top: 20px;']) !!}
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="deleteCardModal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Remove payment method</h4>
			</div>
			<form id="deleteCardBtn" method="post" accept-charset="UTF-8">
				@csrf
				<div class="modal-body">
					The Payment method will no longer be in use after you have removed it.
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-small cancle-membership" data-dismiss="modal">Go Back</button>
					<button type="submit" class="btn btn-small cancle-membership" id="cancle-membership">Yes I’m Sure</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection

@push('js')
<script>
	$(document).ready(function() {
		$('#card-table').DataTable({searching: false});
	} );
	$('#conform-member').click(function() {
		$("#myconformModal").modal();
	});
	$('#addCard').click(function() {
		$("#addCardModal").modal('show');
	});
	function deleteCardModal(cardid,url){
		$('#deleteCardBtn').attr('action', url);
		$('<input>').attr({
			type: 'hidden',
			name: 'cardid',
			value: cardid,
		}).appendTo('#deleteCardBtn');
		$("#deleteCardModal").modal('show');
	}

	function getCardModal(cardid,url){
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: url,
			type: 'POST',
			dataType: 'json',
			data: {
				cardid:cardid
			},
		}).done(function(res) {
			if(res.status==0){
				$('#card-error-msg').html('<span>'+res.msg+'</span>');
			}else{
				$("#updateCardModal").modal('show');
				$('#exp_month option[value='+res.card.card.exp_month+']').attr('selected','selected');
				$('#exp_year option[value='+res.card.card.exp_year+']').attr('selected','selected');
				$('<input>').attr({
					type: 'hidden',
					name: 'cardid',
					value: res.card.id,
				}).appendTo('#update-card-form');
			}
		});
	}

	jQuery(function ($) {
		$('#card-form').submit(function (event) {
			var $form = $(this);
			$form.parsley().subscribe('parsley:form:validate', function (formInstance) {
				return false;
			});
			addCard($('#card-url').val(), $('#card-redirect_url').val());
			return false;
		});

		$('#update-card-form').submit(function (event) {
			var $update_form = $(this);
			$update_form.parsley().subscribe('parsley:form:validate', function (formInstance) {
				return false;
			});
			updateCard($('#update-card-url').val(), $('#update-card-redirect_url').val());
			return false;
		});
	});

	function showDefault(key) {
		$('#default_' + key).toggle();
	}

	function setDefaultCard(paymentMethodId, url, redirect_url) {
		$('#loading').show();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: url,
			type: 'POST',
			dataType: 'json',
			data: {
				cardid: paymentMethodId
			},
		})
		.done(function (res) {
			$('#loading').hide();
			if (res.status == 0) {
				$('#setcard-error-msg').show();
				$('#set_msg').html(res.msg);
				return false;
			} else {
				$('#setcard-error-msg').show();
				$('#set_msg').html(res.msg);
				setTimeout(function () {
					location.href = redirect_url;
				}, 1000);
			}
		});
	}

	function addCard(url, redirect_url) {
		$('#loading').show();
		$('#card-error-msg').html('');
		$('#card-success-msg').html('');
		var $form = $('#card-form').serialize();
		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data: $form,
		})
		.done(function (res) {
			$('#loading').hide();
			if (res.status == 0) {
				$('#card-error-msg').html('<span class="alert alert-danger">' + res.msg + '</span>');
				return false;
			} else {
				$('#card-success-msg').html('<span class="alert alert-success">' + res.msg + '</span>');
				setTimeout(function () {
					location.href = redirect_url;
				}, 1000);
			}
		});
		return false;
	};

	function updateCard(url, redirect_url) {
		$('#loading').show();
		var $update_form = $('#update-card-form').serialize();
		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data: $update_form,
		})
		.done(function (res) {
			$('#loading').hide();
			if (res.status == 0) {
				$('#update-card-error-msg').html('<span>' + res.msg + '</span>');
				return false;
			} else {
				$('#update-card-error-msg').html('<span>' + res.msg + '</span>');
				setTimeout(function () {
					location.href = redirect_url;
				}, 1000);
			}
		});
		return false;
	};
</script>
@endpush
