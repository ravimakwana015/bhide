@extends('admin.layouts.app')

@section('content')
@include('admin.layouts.headers.header',
array( 'class'=>'info', 'title'=>"advert",'description'=>'', 'icon'=>'fas fa-home', 'breadcrumb'=>array(['text'=>'advert', 'text'=>'Add advert', ])))
<div class="container-fluid mt--7">
	<div class="row">
		<div class="col">
			<div class="card shadow">
				<div class="card-header ">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">{{ __('New advert') }}</h3>
						</div>
						<div class="col-4 text-right">
							<a href="{{ route('advert.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form action="{{ route('advert.store') }}" method="POST"  enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="icon_img" id="icon_img" value="">
						<div class="form-row">
							<div class="col-md-6 mb-3">
								<div class="form-group">
									<label class="form-control-label" for="validationDefault01">{{__('Title:')}}</label>
									<input type="text" name="title" class="form-control @error('title') invalid-input @enderror" value="{{ old('title') }}">
									@error('title')
									<div class="invalid-div">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="form-group">
									<label class="form-control-label" for="validationDefault01">{{__('Redirect URL:')}}</label>
									<input type="text" name="redirect_url" class="form-control @error('redirect_url') invalid-input @enderror" value="{{ old('redirect_url') }}">
									@error('redirect_url')
									<div class="invalid-div">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="form-group">
									<label class="form-control-label" for="validationDefault01">{{__('Instagram URL:')}}</label>
									<input type="text" name="instagram_url" class="form-control @error('instagram_url') invalid-input @enderror" value="{{ old('instagram_url') }}">
									@error('instagram_url')
									<div class="invalid-div">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="form-group">
									<label class="form-control-label" for="validationDefault01">{{__('Image:')}}</label>
									<input type="file" name="icon"  class="form-control file-input  @error('icon') invalid-input @enderror">
									@error('icon')
									<div class="invalid-div">{{ $message }}</div>
									@enderror
									<img class="mt-2 img-fluid" src="" alt="" width="200" height="200" id="career_img">
								</div>

								<div class="profile-image-preview">
									<div class="content">
										<div class="image-header">
											<h4 class="title">Upload Image</h4>
											<button type="button" id="close_image_crop" class="close">&times;</button>
										</div>
										<div class="image-wrap">
											<div id="upload-demo"></div>
											<div id="preview-crop-image"></div>
										</div>
										<div class="image-footer">
											<button type="button" class="btn btn-primary upload-image">Upload Image</button>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="form-group">
									<label class="form-control-label" for="validationDefault01">{{__('Status:')}}</label><br/>
									<label class="custom-toggle custom-toggle-primary ml-2">
										<input type="checkbox" value="1" name="status">
										<span class="custom-toggle-slider rounded-circle" data-label-off="No"
										data-label-on="Yes"></span>
									</label>
									@error('status')
									<div class="invalid-div">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<button class="btn btn-primary" type="submit">{{__('Submit')}}</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
<script>
	var resize = $('#upload-demo').croppie({
		enableExif: true,
					// enableOrientation: false,
					viewport: {
						width: 450,
						height: 450,
						type: 'square'
					},
					boundary: {
						width: 500,
						height: 500
					}
				});

	$('#icon-1').on('change', function () {
		var reader = new FileReader();
		reader.onload = function (e) {
			resize.croppie('bind',{
				url: e.target.result
			}).then(function(){
				$('.profile-image-preview').addClass('active');
				$('body').addClass('profile-popup');
			});
		}
		reader.readAsDataURL(this.files[0]);
	});

	$('#close_image_crop').click(function(event) {
		$('.profile-image-preview').removeClass('active');
		$('body').removeClass('profile-popup');
	});

	$('.upload-image').on('click', function (ev) {
		resize.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function (img) {
			$('#loading').show();
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: "{{ route('upload-career-icon') }}",
				type: "POST",
				data: {"image":img},
				success: function (data) {
					$('#loading').hide();
					var path ='{{ asset('public/upload') }}';
					$('#career_img').attr('src', path+'/'+data);
					$('#icon_img').val(data);
					$('.profile-image-preview').removeClass('active');
					$('body').removeClass('profile-popup');
				}
			});
		});
	});
</script>
@endpush
