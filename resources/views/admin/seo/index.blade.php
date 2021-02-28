@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>General SEO</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- /.card -->
      <div class="card card-dark card-tabs">
        @include("admin.include.message")
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-edit"></i>
            General SEO
          </h3>
        </div>
        {!! Form::model($settings, ['route' => ['admin.seo.update'], 'class' => 'form-horizontal', 'role' =>
        'form', 'method' => 'POST', 'files' => true ,'id' => 'edit-settings']) !!}
        <input type="hidden" name="id" value="{{ $settings->id }}" />
        <div class="card-body">
          <div class="tab-content" id="custom-content-below-tabContent" style="margin-top:25px;">
            <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel"
              aria-labelledby="custom-content-below-home-tab">
              <div class="form-group">
                {{ Form::label('page title','Page Title', ['class' => 'control-label'])}}
                {{ Form::text('page_title', null, ['class' => 'form-control', 'placeholder' => 'Page Title'])}}
              </div>

              <div class="form-group">
                {{ Form::label('seo','SEO Title', ['class' => 'control-label'])}}
                {{ Form::text('seo_title', null, ['class' => 'form-control', 'placeholder' => 'SEO Title'])}}
              </div>
              
              <div class="form-group">
                {{ Form::label('seo_keyword','Seo Keyword', ['class' => 'control-label'])}}
                {{ Form::textarea('seo_keyword', null,['class' => 'form-control', 'placeholder' =>'Seo Keyword', 'rows' => 2]) }}
              </div>

              <div class="form-group">
                {{ Form::label('seo_description','SEO Description', ['class' => 'control-label'])}}
                {{ Form::textarea('seo_description', null,['class' => 'form-control', 'placeholder' =>'SEO Description', 'rows' => 2]) }}
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <div class="card-footer">
          {{ Form::submit('Update', ['class' => 'btn btn-dark btn-md']) }}
        </div>
        {{ Form::close() }}
      </div>
  </section>
</div>
@endsection
@section('after-scripts')
<script>
  tinymce.init({
		selector:'textarea',
		// width: 900,
		height: 300
	});
</script>
@endsection
