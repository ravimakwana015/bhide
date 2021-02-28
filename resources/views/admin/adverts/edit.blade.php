<div class="msg"></div>
<div class="row">
    <input type="hidden" name="id" value="{{ $adverts->id }}">
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label class="form-control-label" for="validationDefault01">{{__('Title:')}}</label>
            <input type="text" name="title" class="form-control @error('title') invalid-input @enderror"
                value="{{ old('title',$adverts->title) }}">
            @error('title')
            <div class="invalid-div">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label class="form-control-label" for="validationDefault01">{{__('Redirect URL:')}}</label>
            <input type="text" name="redirect_url" class="form-control @error('redirect_url') invalid-input @enderror"
                value="{{ old('redirect_url',$adverts->redirect_url) }}">
            @error('redirect_url')
            <div class="invalid-div">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label class="form-control-label" for="validationDefault01">{{__('Instagram URL:')}}</label>
            <input type="text" name="instagram_url" class="form-control @error('instagram_url') invalid-input @enderror"
                value="{{ old('instagram_url',$adverts->instagram_url) }}">
            @error('instagram_url')
            <div class="invalid-div">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label class="form-control-label" for="validationDefault01">{{__('Image:')}}</label>
            <input type="file" name="image" class="form-control file-input  @error('image') invalid-input @enderror">
            @error('image')
            <div class="invalid-div">{{ $message }}</div>
            @enderror
            <img class="mt-2 img-fluid" src="{{ asset('/storage/app/img/ads/') }}/{{ $adverts->image }}" alt=""
                width="200" height="200" id="career_img">
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label class="form-control-label" for="validationDefault01">{{__('Status:')}}</label><br />
            <label class="custom-toggle custom-toggle-primary ml-2">
                <input type="checkbox" value="1" name="status" @if($adverts->status==1) checked @endif>
                <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
            </label>
            @error('status')
            <div class="invalid-div">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
