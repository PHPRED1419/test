/**

 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.

 * For licensing, see LICENSE.html or http://ckeditor.com/license

 */



CKEDITOR.editorConfig = function( config ) {

	// Define changes to default configuration here.

	// For complete reference see:

	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	

		config.toolbar = [{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] }]



	// The toolbar groups arrangement, optimized for two toolbar rows.

	config.toolbarGroups = [

		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },

		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },

		{ name: 'links' },

		{ name: 'insert' },

		{ name: 'forms' },

		{ name: 'tools' },

		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },

		{ name: 'others' },

		'/',

		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },

		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },

		{ name: 'styles' },

		{ name: 'colors' },

		{ name: 'about' }

	];

	

	config.allowedContent = true;

	

	config.extraAllowedContent = 'div(*)';

	config.extraAllowedContent = 'p(*)';
	config.extraAllowedContent = 'span(*)';

	// Remove some buttons provided by the standard plugins, which are

	// not needed in the Standard(s) toolbar.

	config.removeButtons = 'Subscript,Superscript';

	

	config.extraPlugins = '';



	// Set the most common block elements.

	//config.format_tags = 'p;h1;h2;h3;pre';

	

	//config.allowedContent = true;



	// Simplify the dialog windows.

	config.removeDialogTabs = 'image:advanced;link:advanced';	
	

	config.contentsCss = 'http://fonts.googleapis.com/css?family=myriad';
	config.font_names = config.font_names + 'myriad;';
	config.font_names = config.font_names + 'myriad;';

};

