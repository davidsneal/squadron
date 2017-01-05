<form enctype="multipart/form-data">
    <div class="form-group">
        <input id="asset-upload" name="asset-upload" type="file" multiple data-preview-file-type="any" data-preview-file-icon="">
    </div>
</form>

<script>
	STYLE_SETTING = 'style="width:{width};height:{height};"',
OBJECT_PARAMS = '      <param name="controller" value="true" />\n' +
    '      <param name="allowFullScreen" value="true" />\n' +
    '      <param name="allowScriptAccess" value="always" />\n' +
    '      <param name="autoPlay" value="false" />\n' +
    '      <param name="autoStart" value="false" />\n'+
    '      <param name="quality" value="high" />\n',
DEFAULT_PREVIEW = '<div class="file-preview-other">\n' +
    '       <i class="glyphicon glyphicon-file"></i>\n' +
    '   </div>'
// set file input options
$("#asset-upload").fileinput({
	uploadAsync: 			true,
	uploadUrl: 				"/{{ env('admin_prefix', 'admin') }}/assets/asset/create",
	allowedFileExtensions: 	{!! json_encode(env('asset_accepted_extensions')) !!},
	maxFileSize: 			{!! json_encode(env('asset_max_filesize')) !!},
	uploadExtraData:		{ _token: '{!! csrf_token() !!}', folder_id: {{ $folder_id }}},
	previewSettings:		{ image: { width: "auto", height: "100px" } },
	dropZoneTitle:			'<span class="glyphicon glyphicon-import" aria-hidden="true"></span> Drop Assets',
	fileActionSettings:		{
		indicatorNew: ''
	},
	removeLabel: 'Remove all',
	layoutTemplates:		{
		actions: '<div class="file-actions">\n' +
        '    <div class="file-footer-buttons">\n' +
        '        {delete}' +
        '    </div>\n' +
        '    <div class="file-upload-indicator" tabindex="-1" title="{indicatorTitle}">{indicator}</div>\n' +
        '    <div class="clearfix"></div>\n' +
        '</div>'
	},
	previewTemplates:		{
    generic: '<div class="file-preview-frame" id="{previewId}" data-fileindex="{fileindex}">\n' +
	        '   {content}\n' +
	        '   {footer}\n' +
	        '</div>\n',
	    image: '<div class="file-preview-frame" id="{previewId}" data-fileindex="{fileindex}">\n' +
	        '   <img src="{data}" class="file-preview-image" title="{caption}" alt="{caption}" ' + STYLE_SETTING + '>\n' +
	        '   {footer}\n' +
	        '</div>\n',
	    other: '<div class="file-preview-frame{frameClass}" id="{previewId}" data-fileindex="{fileindex}" title="{caption}" ' + STYLE_SETTING + '>\n' +
	        '   ' + DEFAULT_PREVIEW + '\n' +
	        '   {footer}\n' +
	        '</div>'
	}
});
// once batch upload is complete
$('#asset-upload').on('filebatchuploadcomplete', function(event, files, extra) {
    location.reload();
});
</script>