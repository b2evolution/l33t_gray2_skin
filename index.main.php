<?php
/**
 * This is the main/default page template.
 *
 * For a quick explanation of b2evo 2.0 skins, please start here:
 * {@link http://manual.b2evolution.net/Skins_2.0}
 *
 * b2evolution - {@link http://b2evolution.net/}
 * Released under GNU GPL License - {@link http://b2evolution.net/about/license.html}
 * @copyright (c)2003-2007 by Francois PLANQUE - {@link http://fplanque.net/}
 *
 * @package evoskins
 * @subpackage l33t_gray
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

skin_init($disp);
// -------------------------- HTML HEADER INCLUDED HERE --------------------------
skin_include( '_html_header.inc.php', array() );
// -------------------------------- END OF HEADER --------------------------------


// ---------------------------- SITE HEADER INCLUDED HERE ----------------------------
// If site headers are enabled, they will be included here:
siteskin_include( '_site_body_header.inc.php' );
// ------------------------------- END OF SITE HEADER --------------------------------
?>
<div id="container">
	<div class="centerTitle">
		<?php $Blog->disp('shortdesc', 'htmlbody'); ?>
	</div>

	<div class="titleBlock">
		<div class="blogTitle">
		<?php
			// ------------------------- "Header" CONTAINER EMBEDDED HERE --------------------------
			// Display container and contents:
			skin_container( NT_('Header'), array(
					// The following params will be used as defaults for widgets included in this container:
					'block_start'       => '',
					'block_end'         => '',
					'block_title_start' => '<h2>',
					'block_title_end'   => '</h2>',
				) );
			// ----------------------------- END OF "Header" CONTAINER -----------------------------
		?>
		</div>
		<div class="blogTagline">
			>> &nbsp;<?php $Blog->disp( 'tagline', 'htmlbody' ) ?>
		</div>
	</div>

	<div class="menuBlock">
		<ul>
	        <?php
			// ------------------------- "Menu" CONTAINER EMBEDDED HERE --------------------------
			// Display container and contents:
			// Note: this container is designed to be a single <ul> list
			skin_container( NT_('Menu'), array(
				// The following params will be used as defaults for widgets included in this container:
				'block_start'         => '',
				'block_end'           => '',
				'block_display_title' => false,
				'list_start'          => '',
				'list_end'            => '',
				'item_start'          => '<li>&gt;&gt;&nbsp; ',
				'item_end'            => '</li>',
			) );
			// ----------------------------- END OF "Menu" CONTAINER -----------------------------
		?>
		</ul>
	</div>

	<div class="menuBlock">
		<div class="centerTitle">WTF?</div>
		<div class="centerContent">
			<?php $Blog->disp('longdesc', 'htmlbody'); ?>
		</div>
	</div>

	<div class="afterDiv"></div>

	<?php 
	// ------------------- PREV/NEXT POST LINKS (SINGLE POST MODE) -------------------
	item_prevnext_links( array(
			'block_start' => '<table class="prevnext_post"><tr>',
			'prev_start'  => '<td>',
			'prev_end'    => '</td>',
			'next_start'  => '<td class="right">',
			'next_end'    => '</td>',
			'block_end'   => '</tr></table>',
		) );
	// ------------------------- END OF PREV/NEXT POST LINKS -------------------------

	// ------------------------- TITLE FOR THE CURRENT REQUEST -------------------------
	request_title( array(
			'title_before'=> '<h2>',
			'title_after' => '</h2>',
			'title_none'  => '',
			'glue'        => ' - ',
			'title_single_disp' => true,
			'format'      => 'htmlbody',
		) );
	// ------------------------------ END OF REQUEST TITLE -----------------------------
?>

<!-- =================================== START OF MAIN AREA =================================== -->
	<?php // ------------------------------------ START OF POSTS ----------------------------------------
	// Display message if no post:
	if( isset($MainList) ) display_if_empty();
	if( isset($MainList) ) while( $Item = & mainlist_get_item() )
	{	// For each blog post, do everything below up to the closing curly brace "}"
	?>

		<div id="<?php $Item->anchor_id() ?>" class="bPost bPost<?php $Item->status_raw() ?>" lang="<?php $Item->lang() ?>">

		<?php
			$Item->locale_temp_switch(); // Temporarily switch to post locale (useful for multilingual blogs)		?>
      
			<div class="centerTitle"><?php $Item->title(); ?></div>
			<div class="centerContent">
			<?php
				$MainList->date_if_changed( array(
					'before'      => '',
					'after'       => '',
					'date_format' => '#',
				));

				$Item->issue_time( array(
					'before'    => '@ ',
					'after'     => ' ',
				));

				$Item->categories( array(
					'before'          => T_('Categories').': ',
					'after'           => ' ',
					'include_main'    => true,
					'include_other'   => true,
					'include_external'=> true,
					'link_categories' => true,
				));

				// List all tags attached to this post:
				$Item->tags( array(
					'before' => ', '.T_('Tags').': ',
					'after' => ' ',
					'separator' => ', ',
				));

				echo ', ';
				$Item->wordcount();
				echo ' ', T_('words');
				echo ' &nbsp; ';
				locale_flag( $Item->locale, 'h10px', 'flag', '' );

				// ---------------------- POST CONTENT INCLUDED HERE ----------------------
				skin_include( '_item_content.inc.php', array(
					'image_size' => 'fit-400x320',
				));

	            // Note: You can customize the default item feedback by copying the generic
	            // /skins/_item_feedback.inc.php file into the current skin folder.
	            // -------------------------- END OF POST CONTENT -------------------------

				// Link to comments, trackbacks, etc.:
				$Item->feedback_link( array(
					'type' => 'comments',
					'link_before' => ' &bull; ',
					'link_after' => '',
					'link_text_zero' => '#',
					'link_text_one' => '#',
					'link_text_more' => '#',
					'link_title' => '#',
					'use_popup' => false,
				));

				$Item->edit_link( array( // Link to backoffice for editing
					'before'    => ' &bull; ',
					'after'     => '',
				));
				
				$Item->permanent_link();
			?>
			</div>

			<?php
			// ------------------ FEEDBACK (COMMENTS/TRACKBACKS) INCLUDED HERE ------------------
			skin_include( '_item_feedback.inc.php', array(
				'before_section_title' => '<h4>',
				'after_section_title'  => '</h4>',
			));

			// Note: You can customize the default item feedback by copying the generic
			// /skins/_item_feedback.inc.php file into the current skin folder.
			// ---------------------- END OF FEEDBACK (COMMENTS/TRACKBACKS) ---------------------
			?>
		</div>

		<?php
			locale_restore_previous();	// Restore previous locale (Blog locale)		?>

		<?php } 
		
		// --------------------------------- END OF POSTS ----------------------------------- 

		// -------------------- PREV/NEXT PAGE LINKS (POST LIST MODE) --------------------
		mainlist_page_links( array(
			'block_start' => '<p class="center"><strong>',
			'block_end' => '</strong></p>',
			'links_format' => '$prev$ :: $next$',
   			'prev_text' => '&lt;&lt; '.T_('Previous'),
   			'next_text' => T_('Next').' &gt;&gt;',
		));
		// ------------------------- END OF PREV/NEXT PAGE LINKS -------------------------
	
		// -------------- MAIN CONTENT TEMPLATE INCLUDED HERE (Based on $disp) --------------
		skin_include( '$disp$', array(
			'disp_posts'  => '',		// We already handled this case above
			'disp_single' => '',		// We already handled this case above
			'disp_page'   => '',		// We already handled this case above
		));

		// Note: you can customize any of the sub templates included here by
		// copying the matching php file into your skin directory.
		// ------------------------- END OF MAIN CONTENT TEMPLATE ---------------------------
	?>

	</div>
	<div class="leftBlock">

	<?php
		// Display container contents:		skin_container( NT_('Sidebar'), array(
			// The following (optional) params will be used as defaults for widgets included in this container:
			// This will enclose each widget in a block:
			'block_start' => '<div class="centerTitle"></div><div class="centerContent $wi_class$">',
			'block_end' => '</div>',

			// This will enclose the title of each widget:
			'block_title_start' => '<div class="centerInternalTitle">',
			'block_title_end' => '</div>',
		
			// If a widget displays a list, this will enclose that list:
			'list_start' => '<ul>',
			'list_end' => '</ul>',

			// This will enclose each item in a list:
			'item_start' => '<li>',
			'item_end' => '</li>',

			// This will enclose sub-lists in a list:
			'group_start' => '<ul>',
			'group_end' => '</ul>',

			// This will enclose (foot)notes:
			'notes_start' => '<div class="notes">',
			'notes_end' => '</div>',
		));
		// ----------------------------- END OF left "Sidebar" CONTAINER -----------------------------
	?>
	</div>

	<div class="rightBlock">
	<?php
		// Display container contents:		skin_container( NT_('Sidebar 2'), array(
			// The following (optional) params will be used as defaults for widgets included in this container:
			// This will enclose each widget in a block:
			'block_start' => '<div class="centerTitle"></div><div class="centerContent $wi_class$">',
			'block_end' => '</div>',

			// This will enclose the title of each widget:
			'block_title_start' => '<div class="centerInternalTitle">',
			'block_title_end' => '</div>',

			// If a widget displays a list, this will enclose that list:
			'list_start' => '<ul>',
			'list_end' => '</ul>',

			// This will enclose each item in a list:
			'item_start' => '<li>',
			'item_end' => '</li>',

			// This will enclose sub-lists in a list:
			'group_start' => '<ul>',
			'group_end' => '</ul>',

			// This will enclose (foot)notes:
			'notes_start' => '<div class="notes">',
			'notes_end' => '</div>',
		));
		// ----------------------------- END OF Right "Sidebar 2" CONTAINER -----------------------------
		?>

		<div class="centerTitle"><a name="power"></a><?php echo T_('Credits') ?></div>
		<div class="centerContent">
			<center>
			skin by <a href="http://www.unbolt.net">Brinley Ang</a>, design by <a href="http://www.dementedkitty.com">Tara Chen</a>
			<br/>

			<?php
				// Display additional credits:
				// If you can add your own credits without removing the defaults, you'll be very cool :))
				// Please leave this at the bottom of the page to make sure your blog gets listed on b2evolution.net
				credits( array(
						'list_start'  => '',
						'list_end'    => '<br/>',
						'separator'   => '|',
						'item_start'  => ' ',
						'item_end'    => ' ',
					) );

				powered_by( array(
					'block_start' => '<div class="powered_by">',
					'block_end'   => '</div>',
					// Check /rsc/img/ for other possible images -- Don't forget to change or remove width & height too
					'img_url'     => '$rsc$img/b2evolution_button_classic.png',
					'img_width'   => 80,
					'img_height'  => 15
				) );
			?>
			</center>
		</div>
	</div>
	<div class="afterDiv">&nbsp;</div>

<?php
// ------------------------- BODY FOOTER EXCLUDED HERE --------------------------
// skin_include( '_body_footer.inc.php' );
// ------------------------------- END OF FOOTER --------------------------------
?>

<?php
// ------------------------- HTML FOOTER INCLUDED HERE --------------------------
skin_include( '_html_footer.inc.php' );
// Note: You can customize the default HTML footer by copying the
// _html_footer.inc.php file into the current skin folder.
// ------------------------------- END OF FOOTER --------------------------------
?>
