<?php
if(!defined('ABSPATH')) {
    die();
}
?>
<div class="wpallexport-free-edition-notice" style="padding: 20px; margin-bottom: 10px;">
	<a class="upgrade_link" target="_blank" href="https://www.wpallimport.com/checkout/?edd_action=add_to_cart&download_id=5839967&edd_options%5Bprice_id%5D=1&utm_source=export-plugin-free&utm_medium=upgrade-notice&utm_campaign=filters"><?php esc_html_e('Upgrade to the Pro edition of WP All Export to Add Filters','wp_all_export_plugin');?></a>
	<p><?php esc_html_e('If you already own it, remove the free edition and install the Pro edition.','wp_all_export_plugin');?></p>
</div>	
<div class="wp_all_export_rule_inputs">
	<table>
		<tr>
			<th><?php esc_html_e('Element', 'wp_all_export_plugin'); ?></th>
			<th><?php esc_html_e('Rule', 'wp_all_export_plugin'); ?></th>
			<th><?php esc_html_e('Value', 'wp_all_export_plugin'); ?></th>
			<th>&nbsp;</th>
		</tr>
		<tr>
			<td style="width: 25%;">
				<select id="wp_all_export_xml_element">
					<option value=""><?php esc_html_e('Select Element', 'wp_all_export_plugin'); ?></option>
					<?php
                        // Content is sanitized
                        echo $engine->render_filters();
                    ?>
				</select>
			</td>
			<td style="width: 25%;" id="wp_all_export_available_rules">
				<select id="wp_all_export_rule">
					<option value=""><?php esc_html_e('Select Rule', 'wp_all_export_plugin'); ?></option>
				</select>
			</td>
			<td style="width: 25%;">
				<input id="wp_all_export_value" type="text" placeholder="value" value=""/>
			</td>
			<td style="width: 15%;">
				<a id="wp_all_export_add_rule" href="javascript:void(0);"><?php esc_html_e('Add Rule', 'wp_all_export_plugin');?></a>
			</td>
		</tr>
	</table>						
</div>	
<div id="wpallexport-filters" style="padding:0;">								
	<div class="wpallexport-content-section" style="padding:0; border: none;">					
		<fieldset id="wp_all_export_filtering_rules">					
			<?php
			$filter_rules = $post['filter_rules_hierarhy'];
			$filter_rules_hierarhy = json_decode($filter_rules);											
			?>
			<p id="date_field_notice" style="margin: 5px 0px 20px; text-align: center;"><?php esc_html_e('Date filters use natural language.<br>For example, to return records created in the last week: <i>date ▸ newer than ▸ last week</i>.<br>For all records created in 2016: <i>date ▸ older than ▸ 1/1/2017</i> AND <i>date ▸ newer than ▸ 12/31/2015</i>', 'wp_all_export_plugin');?>.</p>
			<p id="no_options_notice" style="margin:20px 0 5px; text-align:center; <?php if ( ! empty($filter_rules_hierarhy) and is_array($filter_rules_hierarhy) ) echo 'display:none;';?>"><?php esc_html_e('No filtering options. Add filtering options to only export records matching some specified criteria.', 'wp_all_export_plugin');?></p>
			<ol class="wp_all_export_filtering_rules">
				<?php							
					
					$condition_labels = array(
						'default' => array(
							'equals' => __('equals', 'wp_all_export_plugin'),
							'not_equals' => __("doesn't equal", 'wp_all_export_plugin'),
							'greater' => __('greater than', 'wp_all_export_plugin'),
							'equals_or_greater' => __('equal to or greater than', 'wp_all_export_plugin'),
							'less' => __('less than', 'wp_all_export_plugin'),
							'equals_or_less' => __('equal to or less than', 'wp_all_export_plugin'),
							'contains' => __('contains', 'wp_all_export_plugin'),
							'not_contains' => __("doesn't contain", 'wp_all_export_plugin'),
							'is_empty' => __('is empty', 'wp_all_export_plugin'),
							'is_not_empty' => __('is not empty', 'wp_all_export_plugin'),
							'in' => __('In', 'wp_all_export_plugin'),
							'not_in' => __('Not In', 'wp_all_export_plugin')
						),
						'date' => array(
							'equals' => __('equals', 'wp_all_export_plugin'),
							'not_equals' => __("doesn't equal", 'wp_all_export_plugin'),
							'greater' => __('newer than', 'wp_all_export_plugin'),
							'equals_or_greater' => __('equal to or newer than', 'wp_all_export_plugin'),
							'less' => __('older than', 'wp_all_export_plugin'),
							'equals_or_less' => __('equal to or older than', 'wp_all_export_plugin'),
							'contains' => __('contains', 'wp_all_export_plugin'),
							'not_contains' => __("doesn't contain", 'wp_all_export_plugin'),
							'is_empty' => __('is empty', 'wp_all_export_plugin'),
							'is_not_empty' => __('is not empty', 'wp_all_export_plugin'),
							'in' => __('In', 'wp_all_export_plugin'),
							'not_in' => __('Not In', 'wp_all_export_plugin')
						)
					);

					if ( ! empty($filter_rules_hierarhy) and is_array($filter_rules_hierarhy) ): 

						$rulenumber = 0;
						
						foreach ($filter_rules_hierarhy as $rule) 
						{						
							if ( is_null($rule->parent_id) )
							{								
								$condition_label = in_array($rule->element, array('post_date', 'user_registered', 'comment_date')) ? $condition_labels['date'][$rule->condition] : $condition_labels['default'][$rule->condition];

								$rulenumber++;
								?>
								<li id="<?php echo esc_attr("item_" . $rulenumber);?>" class="dragging">
									<div class="drag-element">
										<input type="hidden" value="<?php echo esc_attr($rule->element); ?>" class="wp_all_export_xml_element" name="wp_all_export_xml_element[<?php echo intval($rulenumber); ?>]"/>
										<input type="hidden" value="<?php echo esc_attr($rule->title); ?>" class="wp_all_export_xml_element_title" name="wp_all_export_xml_element_title[<?php echo intval($rulenumber); ?>]"/>
							    		<input type="hidden" value="<?php echo esc_attr($rule->condition); ?>" class="wp_all_export_rule" name="wp_all_export_rule[<?php echo intval($rulenumber); ?>]"/>
										<input type="hidden" value="<?php echo esc_attr($rule->value); ?>" class="wp_all_export_value" name="wp_all_export_value[<?php echo intval($rulenumber); ?>]"/>
										<span class="rule_element"><?php echo esc_attr($rule->title); ?></span>
										<span class="rule_as_is"><?php echo esc_attr($condition_label); ?></span>
										<span class="rule_condition_value"><?php echo esc_attr($rule->value); ?></span>
										<span class="condition <?php if ($rulenumber == count($filter_rules_hierarhy)) :?>last_condition<?php endif; ?>">
											<label for="rule_and_<?php echo intval($rulenumber); ?>">AND</label>
											<input id="rule_and_<?php echo intval($rulenumber); ?>" type="radio" value="and" name="rule[<?php echo intval($rulenumber); ?>]" <?php if ($rule->clause == 'AND'): ?>checked="checked"<?php endif; ?> class="rule_condition"/>
											<label for="rule_or_<?php echo intval($rulenumber); ?>">OR</label>
											<input id="rule_or_<?php echo intval($rulenumber); ?>" type="radio" value="or" name="rule[<?php echo intval($rulenumber); ?>]" <?php if ($rule->clause == 'OR'): ?>checked="checked"<?php endif; ?> class="rule_condition"/>
										</span>
									</div>
									<a href="javascript:void(0);" class="icon-item remove-ico"></a>
									<?php echo wp_all_export_reverse_rules_html($filter_rules_hierarhy, $rule, $rulenumber, $condition_labels); ?>
								</li>
								<?php
							}
						}
					endif;
				?>
			</ol>	
			<div class="clear"></div>
		</fieldset>
	</div>	
</div>