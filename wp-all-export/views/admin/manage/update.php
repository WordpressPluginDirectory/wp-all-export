<?php
if(!defined('ABSPATH')) {
    die();
}
$l10n = array(
		'confirm_and_run'    => __('Confirm & Run Export', 'wp_all_export_plugin'),
		'save_configuration' => __('Save Export Configuration', 'wp_all_export_plugin')	
	);
?>
<script type="text/javascript">	
	var wp_all_export_L10n = <?php echo json_encode($l10n); ?>;
</script>


<div class="wpallexport-step-4 wpallexport-export-options wpallexport-re-run-export">
	
	<h2 class="wpallexport-wp-notices"></h2>

	<div class="wpallexport-wrapper">
		<h2 class="wpallexport-wp-notices"></h2>
		<div class="wpallexport-header">
			<div class="wpallexport-logo"></div>
			<div class="wpallexport-title">
				<h2><?php esc_html_e('Confirm & Run', 'wp_all_export_plugin'); ?></h2>
			</div>
			<div class="wpallexport-links">
				<a href="http://www.wpallimport.com/support/?utm_source=export-plugin-free&utm_medium=help&utm_campaign=premium-support" target="_blank"><?php esc_html_e('Support', 'wp_all_export_plugin'); ?></a> | <a href="http://www.wpallimport.com/documentation/?utm_source=export-plugin-free&utm_medium=help&utm_campaign=docs" target="_blank"><?php esc_html_e('Documentation', 'wp_all_export_plugin'); ?></a>
			</div>
		</div>	
		<div class="clear"></div>		
	</div>			

	<table class="wpallexport-layout">
		<tr>
			<td class="left" style="width: 100%;">		
	
				<?php do_action('pmxe_options_header', $isWizard, $post); ?>
				
				<div class="ajax-console">					
					<?php if ($this->errors->get_error_codes()): ?>
						<?php $this->error() ?>
					<?php endif ?>					
				</div>														

				<div class="wpallexport-content-section" style="padding: 0 30px 0 0; overflow: hidden; margin-bottom: 0;">

					<div id="filtering_result" class="wpallexport-ready-to-go">						
						<h3> &nbsp; </h3>
						<div class="wp_all_export_preloader"></div>
					</div>	

					<form class="confirm <?php echo ! $isWizard ? 'edit' : '' ?>" method="post" style="float:right;">							

						<?php wp_nonce_field('update-export', '_wpnonce_update-export') ?>
						<input type="hidden" name="is_confirmed" value="1" />
                        <input type="hidden" name="record-count" class="wpae-record-count" value="0" />


                        <input type="submit" class="rad10 wp_all_export_confirm_and_run" value="<?php esc_html_e('Confirm & Run Export', 'wp_all_export_plugin') ?>" <?php if (empty(PMXE_Plugin::$session->found_posts)):?>style="display:none;"<?php endif;?>/>
					</form>	

				</div>					

				<div class="clear"></div>

				<form class="<?php echo ! $isWizard ? 'edit' : 'options' ?> choose-export-options" method="post" enctype="multipart/form-data" autocomplete="off" <?php echo ! $isWizard ? 'style="overflow:visible;"' : '' ?>>

					<?php
                    $addons = new \Wpae\App\Service\Addons\AddonService();
					$selected_post_type = '';
					if ($addons->isUserAddonActive() && XmlExportUser::$is_active):
						$selected_post_type = empty($post['cpt'][0]) ? 'users' : $post['cpt'][0];
					endif;
					if (empty($selected_post_type) and ! empty($post['cpt'][0]))
					{
						$selected_post_type = $post['cpt'][0];
					}				
					?>
					
					<input type="hidden" name="selected_post_type" value="<?php echo esc_attr($selected_post_type); ?>"/>
					<input type="hidden" name="export_type" value="<?php echo esc_attr($post['export_type']); ?>"/>
					<input type="hidden" name="taxonomy_to_export" value="<?php echo esc_attr($post['taxonomy_to_export']);?>">
					<input type="hidden" name="wpml_lang" value="<?php echo esc_attr($post['wpml_lang']);?>" />
					<input type="hidden" id="export_variations" name="export_variations" value="<?php echo XmlExportEngine::getProductVariationMode();?>" />
                    <input type="hidden" name="record-count" class="wpae-record-count" value="0" />
                    <input type="hidden" name="sub_post_type_to_export" value="<?php echo $post['sub_post_type_to_export'];?>">

                    <?php XmlExportFiltering::render_filtering_block( $engine, $isWizard, $post ); ?>

					<?php include_once PMXE_ROOT_DIR . '/views/admin/export/options/settings.php'; ?>						

					<p class="wpallexport-submit-buttons" style="text-align: center;">
						<?php wp_nonce_field('update-export', '_wpnonce_update-export') ?>
						<input type="hidden" name="is_confirmed" value="1" />					
						
						<a href="<?php echo esc_url(apply_filters('pmxi_options_back_link', add_query_arg('id', $item->id, add_query_arg(['action'=>'template','_wpnonce_template' => wp_create_nonce('template')], $this->baseUrl)), $isWizard)); ?>" class="back rad3"><?php esc_html_e('Edit Template', 'wp_all_export_plugin') ?></a>
						<?php if (empty(PMXE_Plugin::$session->found_posts)):?>
						<input type="submit" class="button button-primary button-hero wpallexport-large-button confirm_and_run_bottom" value="<?php esc_html_e('Save Export Configuration', 'wp_all_export_plugin') ?>" />
						<?php else:?>
						<input type="submit" class="button button-primary button-hero wpallexport-large-button confirm_and_run_bottom" value="<?php esc_html_e('Confirm & Run Export', 'wp_all_export_plugin') ?>" />
						<?php endif;?>
					</p>


				</form>

                <div class="wpallexport-display-columns wpallexport-margin-top-forty">
					<?php echo apply_filters('wpallexport_footer', ''); ?>
                </div>
					
			</td>			
		</tr>
	</table>

</div>

<div class="wpallexport-overlay"></div>
