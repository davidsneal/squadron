<form enctype="multipart/form-data">
    <div class="form-group">
        <input id="asset-upload" name="asset-upload" type="file" multiple data-preview-file-type="any" data-preview-file-icon="">
    </div>
</form>

<script>
// set file input options
$("#asset-upload").fileinput({
	uploadAsync: 			true,
	uploadUrl: 				"/{{ Config::get('settings.admin_prefix') }}/assets/asset/create",
	allowedFileExtensions: 	{!! json_encode(Config::get('settings.asset_accepted_extensions')) !!},
	maxFileSize: 			{!! json_encode(Config::get('settings.asset_max_filesize')) !!},
	uploadExtraData:		{ _token: '{!! csrf_token() !!}', folder_id: {{ $folder_id }}},
	previewSettings:		{ image: { width: "auto", height: "100px" } },
	dropZoneTitle:			'<span class="glyphicon glyphicon-import" aria-hidden="true"></span> Drop Assets'
});
// once batch upload is complete
$('#asset-upload').on('filebatchuploadcomplete', function(event, files, extra) {
    location.reload();
});
</script>