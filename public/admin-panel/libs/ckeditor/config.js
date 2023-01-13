/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'styles' },
		{ name: 'links' },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		{ name: 'colors' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Subscript,Superscript'; //Underline

	// Set the most common block elements.
	// config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';

	config.language = 'en';
	// config.uiColor = '#F7B42C';
	config.height = 300;
	// config.toolbarCanCollapse = true;

	config.basicEntities = false;
	config.allowedContent = true;
	config.extraAllowedContent= '*[*]{*}(*)';
    config.extraPlugins = 'indent,indentblock,embed,embedbase,autoembed,autolink,dialogadvtab';
	CKEDITOR.dtd.$removeEmpty.i = 0;
    config.embed_provider = '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}';
    // config.embed_provider = '//example.com/api/oembed-proxy?resource-url={url}&callback={callback}';
    // config.image2_alignClasses = [ 'image-left', 'image-center', 'image-right' ];
	// config.image2_captionedClass = 'image-fluid';
	// config.filebrowserUploadUrl = base_url() + 'admin/blogs/upload';
};
