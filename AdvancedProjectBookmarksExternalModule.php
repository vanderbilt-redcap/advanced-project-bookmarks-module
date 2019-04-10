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

					var onclick = $(link).attr('onclick')
					if(recordId){
						// If a matching 'record' parameter exists, change to an 'id' parameter (useful when multiple projects have matching records with the same ids).
						// This will cause duplicate 'id' parameters, but that won't actually cause any problems.
						onclick = onclick.replace('&record='+recordId, '&id='+recordId)
						$(link).attr('onclick', onclick)
					}
					else if(onclick.indexOf('&id=') !== -1){
						// This link expects a record id, but the current url does not include a record id.
						// Hide this link on this page.
						$(link).parent().hide()
					}
				})
			})
		</script>
		<?php
	}

	private function cssAttributeSelectorEscape($s){
		foreach([':', '/'] as $c){
			$s = str_replace("$c", "\\\\$c", $s);
		}

		return $s;
	}
}