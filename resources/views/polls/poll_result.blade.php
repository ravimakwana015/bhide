@forelse ($poll->options as $option)
@foreach ($result as $key=>$item)
@if($key==$option['id'])
{{ $option['option'] }}
<div class="progress">
    <div class="progress-bar bg-success" style="width:{{ $item }}%">
         {{ $item }}%
    </div>
</div><br/>
@endif
@endforeach
@empty

@endforelse
