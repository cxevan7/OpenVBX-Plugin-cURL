<?php 
	$url = AppletInstance::getValue('url');
  $glength = AppletInstance::getValue('glength'); 
?>
<div class="vbx-applet curl-applet">
	<h2>cURL Request</h2>
  
  
	<p>When the caller reaches this, they will hear:</p>
  <div class="menu-prompt">
  	<?php echo AppletUI::audioSpeechPicker('prompt'); ?>
  </div><br /><br />
	<p>The service will then cURL the following URL, if you want to gather input before the request, enter a length greater than 0:</p>
  <fieldset class="vbx-input-container">
  	<input class="keypress tiny" type="text" name="glength" value="<?=$glength?>" autocomplete="off" style="float:left;" />
  	<input class="keypress medium" type="text" name="url" value="<?=$url?>" autocomplete="off" />
    <div style="clear:both;"></div>
  </fieldset>
  
  <h2 class="settings-title">Next</h2>
  <p>After the prompt, continue to the next applet</p>
  <div class="vbx-full-pane">
  	<?php echo AppletUI::DropZone('next'); ?>
  </div><!-- .vbx-full-pane -->
</div>
