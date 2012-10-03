<?php
/*
Plugin Name: Expandable Menus
Plugin URI: http://playforward.net
Description: Allows you to expand and collapse menus in WordPress admin.
Author: Dustin Dempsey
Version: 1.1
Author URI: http://playforward.net
*/


	// out function
	function EM_admin_head(){
	
		// echo css and javascript
		$plus_path = includes_url('/images/admin-bar-sprite.png');
		echo '
			<style>
				.expand_hidden {
					display: none;
				}
				.minimized .menu-item-handle {
					border-right: 20px solid #298cba;
					overflow: visible !important;
				}
				.minimized .item-type {
					position:relative;
					left: 40px;
					padding-right: 50px;
					background: url("' . $plus_path . '") 60px -181px no-repeat;
					cursor: s-resize;
				}
				.menu-item-custom.minimized .item-type {
					background: url("' . $plus_path . '") 76px -181px no-repeat;
				}
				.expander {
					position: absolute;
					top: 0px;
					left: 420px;
				}
			</style>
			<!-- Expandable Menu Code -->
			<script type="text/javascript">
				jQuery(document).ready(function(){
					var expand_editing = false;
					jQuery("#menu-to-edit .item-edit").on("dblclick", function(event){
						expand_editing = true;
						setTimeout(function(){
							expand_editing = false;
						},100);
					});
					var the_expand_function = function(){
						if ( expand_editing === false ) {
							var classes = jQuery(this).attr( "class" ).split(" ");
							if ( jQuery(this).hasClass( "minimized" ) ) {
								minimizing = false;
							}
							if ( classes ) {
								for(var i = 0; i < classes.length; i++){
									if ( classes[i] ) {
										if(classes[i].substr(0,16) == "menu-item-depth-"){
											var the_depth = parseInt(classes[i].split("menu-item-depth-")[1]);
											var the_index = 0;
											var current_element = this;
											var children_check = false;
											var children_depth = the_depth + 1;
											if ( the_depth || ( the_depth == 0 ) ) {
												setTimeout(function(){
													the_index = 1;
												},2000);
												for(var maini = 0; maini < 200; maini++){
													if ( the_index == 1 ) {
													} else {
														var next_element = jQuery(current_element).next();
														if ( jQuery(next_element).attr( "class" ) ) {
															var next_classes = jQuery(next_element).attr( "class" ).split(" ");
															if ( next_classes ) {
																for(var nexti = 0; nexti < next_classes.length; nexti++){
																	if ( next_classes[nexti] ) {
																		if(next_classes[nexti].substr(0,16) == "menu-item-depth-"){
																			var next_depth = parseInt(next_classes[nexti].split("menu-item-depth-")[1]);
																			if ( next_depth || ( next_depth == 0 ) ) {
																				if ( next_depth > the_depth ) {
																					if ( children_check === true ) {
																						if ( next_depth <= children_depth  ) {
																							children_check = false;
																						}
																					}
																					if ( children_check === false ) {
																						// hide/show
																						jQuery(next_element).toggleClass( "expand_hidden" );
																						if ( jQuery(next_element).hasClass( "minimized" ) ) {
																							children_check = true;
																							children_depth = next_depth;
																						}
																					}
																					current_element = next_element;
																					var expanded = true;
																				} else {
																					// stop execution
																					the_index = 1;
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
											if ( expanded === true ) {
												jQuery(this).toggleClass( "minimized" );
											}
										}
									}
								}
							}
						}
					}
					jQuery("#menu-to-edit li").on( "dblclick", the_expand_function );
				});
			</script>
			<!-- END expanadable menu code -->
			';
	}
	
	// add action to admin head
	add_action( 'admin_head', 'EM_admin_head' );

?>