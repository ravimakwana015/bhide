<div class="modal fade bd-example-modal-lg" id="addAdvert" tabindex="-1" role="dialog"
    aria-labelledby="addParcelsTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLongTitle">Add Adverts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'advert.store','role' => 'form', 'method' => 'post', 'id' => 'create-ads','files' => true]) }}
            <div class="modal-body">
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
                            <input type="file" name="image"  class="form-control file-input  @error('image') invalid-input @enderror">
                            @error('image')
                            <div class="invalid-div">{{ $message }}</div>
                            @enderror
                            <img class="mt-2 img-fluid" src="" alt="" width="200" height="200" id="career_img">
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
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary">Submit</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
