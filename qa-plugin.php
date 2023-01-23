<?php
/*
	Question2Answer by Gideon Greenspan and contributors
	http://www.question2answer.org/


	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	More about this license: http://www.question2answer.org/license.php
*/

/*
	Plugin Name: TinyMCE Editor
	Plugin URI:
	Plugin Description: HTML Editor(TinyMCE WYSIWYG)
	Plugin Version: 1.0
	Plugin Date: 2023-01-20
	Plugin Author: Thalles Tutoriais
	Plugin Author URI: https://www.youtube.com/VideosTutoriais
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.3
	Plugin Update Check URI:
*/


if (!defined('QA_VERSION')) {
	header('Location: ../../');
	exit;
}


qa_register_plugin_module('editor', 'qa-tinymce-editor.php', 'qa_tinymce_editor', 'TinyMCE Editor');
