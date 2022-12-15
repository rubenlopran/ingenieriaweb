<div class="box box-info padding-1">
    <div class="box-body">
    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
    <input type="hidden" name="publicacion_id" value="{{$like->publicacion_id}}" >

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>