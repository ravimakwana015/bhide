@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Edit Settings') }}</h3>
            </div>
            <div class="btn-wrap" style="padding-left: 0px;">
              <a class="btn mb-0" href="{{ route('loyaltyCard.index') }}"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
        </div>
          <!-- form start -->
          {!! Form::model($companySettings, ['route' => ['companySettings.update', $companySettings], 'role' => 'form', 'method' =>
          'PATCH','id'=>'settings-edit','files' => true]) !!}
          <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @include("settings.form")
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-secondary">Submit</button>
        </div>
        {!! Form::close() !!}
        <!-- /.card -->
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript">
    $('.store_details').click(function() {
        var count = parseInt($('#count').val()) + parseInt(1);
        var html = '<div class="row remove_'+count+'"> <div class="col-3"> <div class="form-group"> <label>Title / Name '+count+'</label> <input type="text" class="form-control" name="emergency_captions[]"> </div> </div> <div class="col-3"> <div class="form-group"> <label>Contact Number '+count+'</label> <input type="text" class="form-control" name="emergency_numbers[]"> </div> </div><div class="col-md-4"> <label>&nbsp;</label> <br/><a class="remove-field btn" data-id="'+count+'" href="javascript:;">Remove</a> </div> </div>';
        $('#count').val(count);
        $('.store_details_dynamic').append(html);
    });

    $(document).on('click', '.remove-field', function(e) {
     var id = $(this).data('id');
     $('.remove_'+id).remove();
     e.preventDefault();
 });
</script>


<script>
    var resize = $('#upload-demo').croppie({
        enableExif: true,
        viewport: { 
            width: 600,
            height: 350,
            type: 'square'
        },
        boundary: {
            width: 600,
            height: 350
        }
    });

    $('#loyalty_card_image-1').on('change', function () {
        $('#myModal').show('model');
        var reader = new FileReader();
        reader.onload = function (e) {
            resize.croppie('bind',{
                points: [77,469,280,739],
                url: e.target.result
            }).then(function(){
                resize.croppie('setZoom', 0.2);
                $('.profile-image-preview').addClass('active');
                $('body').addClass('profile-popup');
            });
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('#close_image_crop').click(function(event) {
        $('.profile-image-preview').removeClass('active');
        $('body').removeClass('profile-popup');
        $('#building_image-1').val('');
        $('#myModal').hide('model');
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
                url: "{{ route('upload-loyalty-pic') }}",
                type: "POST",
                data: {"image":img},
                success: function (data) {
                    $('#myModal').hide('model');
                    $('#loading').hide(); 
                    var path ='{{ asset('storage/app/img/loyaltyCard/') }}';
                    $('#profile-img-tag').attr('src', path+'/'+data);
                    $('#loyalty_cardimage').val(data);

                    $('#yellowbutton').trigger('click');
                    setTimeout(function() { 
                        $('#loadings').hide(); 
                    }, 4000);
                }
            });
        });
    });
</script>

@endpush
