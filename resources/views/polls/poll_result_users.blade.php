
@foreach (array_unique($users_name) as $key=>$item)

<div class="">
	<h6>{{ $item }}</h6>
</div><br/>

@endforeach