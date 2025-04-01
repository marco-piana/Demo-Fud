<div class="card-body">
  <div class="form-group{{ $errors->has('comment') ? ' has-danger' : '' }}">
    <label class="form-control-label mb-2">{{ __('Additional Note') }} / {{ __('Comment')}}</label>
    <textarea name="comment" id="comment" class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" placeholder="{{ __( 'Your comment here' ) }} ..."></textarea>
    @if ($errors->has('comment'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('comment') }}</strong>
        </span>
    @endif
  </div>
</div>
