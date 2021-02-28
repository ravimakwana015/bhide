<div class="modal profile-image-preview" id="myModal">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">{{ __('Upload Image') }}</h4>
				<button type="button" class="close" id="close_image_crop" >&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<div id="loading" style="display: none;">
					<img src="{{ URL::asset('public/build/images/loading-profile.gif') }}" style=" z-index: +1;" width="150" height="150" alt="loading-profile" title="loading-profile" />
				</div>
				<div class="image-wrap">
					<div id="upload-demo"></div>
					<div id="preview-crop-image"></div>
				</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-primary upload-image" id="cropimage">{{ __('Crop') }}</button>
			</div>

		</div>
	</div>
</div>