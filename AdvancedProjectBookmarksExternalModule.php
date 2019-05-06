<?php
namespace Vanderbilt\AdvancedProjectBookmarksExternalModule;

class AdvancedProjectBookmarksExternalModule extends \ExternalModules\AbstractExternalModule
{
	function redcap_every_page_top(){
		$escapedWebRoot = $this->cssAttributeSelectorEscape(APP_PATH_WEBROOT_FULL);

		?>
		<script>
			$(function(){
				var recordId = <?=json_encode(@$_GET['id'])?>;

				$('#extres_panel .hang a[onClick*=<?=$escapedWebRoot?>]').each(function(i, link){
					// This is a link to this REDCap instance.
					link = $(link)

					if(recordId){
						var adjustAttributeParams = function(attributeName){
							var value = link.attr(attributeName)

							if(value.indexOf('&record=') !== -1){
								// Remove the id parameter if it already exists
								value = value.replace(/&id=[^&]+/,'')

								// Change the 'record' parameter to an 'id' parameter (useful when multiple projects have matching records with the same ids)
								value = value.replace('&record='+recordId, '&id='+recordId)
							}

							link.attr(attributeName, value)
						}

						adjustAttributeParams('onclick')
						adjustAttributeParams('href') // for when "Opens new window" is checked
					}
					else if(link.attr('onclick').indexOf('&id=') !== -1){
						// This link expects a record id, but the current url does not include a record id.
						// Hide this link on this page.
						link.parent().hide()
					}
				})
			})
		</script>
		<?php
	}

	private function cssAttributeSelectorEscape($s){
		foreach([':', '/', '.'] as $c){
			$s = str_replace("$c", "\\\\$c", $s);
		}

		return $s;
	}
}