<?php


class qa_tinymce_editor
{
	
	
	public function calc_quality($content, $format)
	{
		if ($format == 'html')
			return 1.0;
		elseif ($format == '')
			return 0.8;
		else
			return 0;
	}

	public function get_field(&$qa_content, $content, $format, $fieldname, $rows)
	{
		
		$qa_content['script_lines'][] = array('
		
		var detectThemeSkin = "";
		var detectThemeCSS = "";
		
		if (localStorage.theme === "dark") {
			detectThemeSkin = "oxide-dark";
			detectThemeCSS = "dark";
		}
		
		document.getElementsByName('.qa_js($fieldname).')[0].id = '.qa_js($fieldname."_tinymce_editor").';
		var script = document.createElement("script");
		script.onload = function () {
			tinymce.init({
				selector: '.qa_js("#" .$fieldname."_tinymce_editor").',

				skin:detectThemeSkin,
				content_css:detectThemeCSS,

				plugins: "searchreplace autolink directionality visualblocks visualchars link table lists wordcount charmap quickbars",
				menubar: "edit view",
				toolbar: ["removeformat undo redo | styles | bold italic bullist numlist table charmap"],
				quickbars_selection_toolbar: "bold italic quicklink blockquote removeformat",
				
				draggable_modal:true,
				image_advtab:true,
				apply_source_formatting:true,
				remove_linebreaks:true,
				verify_html:true,
				quickbars_insert_toolbar:"",
				branding:false,
				paste_auto_cleanup_on_paste:true,
				paste_remove_styles:true,
				paste_remove_styles_if_webkit:true,
				paste_strip_class_attributes:"all",

				contextmenu:false,

				toolbar_mode:"sliding",

				valid_elements: "a[href|target],ul,ol,li,p,i,b,u,span,em,strong,del,table,td,tr,tbody,thead,pre,blockquote,code,sub,sup",

				style_formats: [
					{ title: "Bold", inline: "strong" },
					{ title: "Italic", inline: "i" },
					{ title: "Underline", inline: "u" },
					{ title: "Strikethrough", inline: "del" },
					{ title: "Paragraph", inline: "p" },
					{ title: "Blockquote", inline: "blockquote" },
					{ title: "Pre", inline: "pre" },
					{ title: "Code", inline: "code" },
					{ title: "Subscript", inline: "sub" },
					{ title: "Superscript", inline: "sup" },
				],
				style_formats_merge: false,
				style_formats_autohide: true

			
			});
			document.getElementById('.qa_js($fieldname."_tinymce_active").').value = "1";
		}
		script.src = "//cdnjs.cloudflare.com/ajax/libs/tinymce/6.0.2/tinymce.min.js";
		document.head.appendChild(script);
		
		',
		);
		

		if ($format == 'html') {
			$html = $content;
		} else {
			$html = qa_html($content, true);
		}

		return array(
			'tags' => 'name="'.$fieldname.'"',
			'value' => qa_html($html),
			'rows' => $rows,
			'html_prefix' => '
			<style>.tox .tox-toolbar--scrolling{flex-wrap:wrap!important;}</style>
			<input name="'.$fieldname.'_tinymce_active" id="'.$fieldname.'_tinymce_active" type="hidden" value="0">
			',
		);
	}


	public function read_post($fieldname)
	{
		if (qa_post_text($fieldname.'_tinymce_active')) {
			// tinymce was loaded successfully
			$html = qa_post_text($fieldname);

			// remove <p>, <br>, etc... since those are OK in text
			$htmlformatting = preg_replace('/<\s*\/?\s*(br|p)\s*\/?\s*>/i', '', $html);

			// if still some other tags, it's worth keeping in HTML
				// qa_sanitize_html() is ESSENTIAL for security
				return array(
					'format' => 'html',
					'content' => qa_sanitize_html($html, false, true),
				);
			
		} else {
			// tinymce was not loaded so treat it as plain text
			return array(
				'format' => '',
				'content' => qa_post_text($fieldname),
			);
		}
	}




}
