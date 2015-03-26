<form enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="folder-id" id="folder-id" value="{{ $folder_id }}" />
    <div class="form-group">
        <input id="asset" type="file" multiple data-preview-file-type="any" data-preview-file-icon="">
    </div>
</form>

<script>
$("#asset").fileinput({
	uploadAsync: true,
	allowedFileExtensions: {!! json_encode(Config::get('settings.asset_accepted_extensions')) !!},
	uploadUrl: "/{{ Config::get('settings.admin_prefix') }}/assets/asset/create"
});
</script>