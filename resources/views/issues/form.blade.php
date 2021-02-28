<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {{ Form::label('issue', 'Issue Reported', ['class' =>'control-label required']) }}
            <br />
            {{ $issues->issue }}
        </div>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
            {{ Form::label('status', 'Status', ['class' =>'control-label required']) }}
            <br />
            <input type="radio" id="done" name="status" value="1" @if(isset($issues) && $issues->status=='1') checked @endif/>
            Completed
            <input type="radio" name="status" value="2" @if(isset($issues) && $issues->status=='2') checked @endif/>
            In Review
            <input type="radio" name="status" value="0" @if(isset($issues) && $issues->status=='0') checked @endif/>
            Pending
            <br />
            @if ($errors->has('status'))
            <span class="invalid-feedback">{{ $errors->first('status') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-3" id="commentsdata" @if(isset($issues) && $issues->status=='1')  @else style="display: none;" @endif >
        <div class="form-group">
            <div class="form-group  {{ $errors->has('comment') ? ' is-invalid' : '' }}">
                {{ Form::label('comment','Comment', ['class' => 'control-label required']) }}
                {{ Form::textarea('comment', null, ['class' => 'form-control '.($errors->has('comment') ? 'is-invalid':''), 'placeholder' => 'Comment','rows'=>2]) }}
                @if ($errors->has('comment'))
                <span class="invalid-feedback">{{ $errors->first('comment') }}</span>
                @endif
            </div>
        </div>
    </div>
</div>
