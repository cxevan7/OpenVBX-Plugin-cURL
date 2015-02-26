<?php

  $ci = &get_instance();
  $response = new TwimlResponse;

	$url = AppletInstance::getValue('url');
  $numDigits = AppletInstance::getValue('glength');
	$next = AppletInstance::getDropZoneUrl('next');
	
  /* Fetch all the data to operate the menu */
  $digits = isset($_REQUEST['Digits'])? $ci->input->get_post('Digits') : false;
  $prompt = AppletInstance::getAudioSpeechPickerValue('prompt');

  if($digits !== false) {
  	$fields = array('Digits' => ($digits));
    
    foreach($_REQUEST as $name => $val) $fields[$name] = ($val);
    
    $fields_string = http_build_query($fields);
    
    
    //  Initiate curl
    $ch = curl_init();
    // Disable SSL verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Set the url
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST, count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    // Execute
    $result = curl_exec($ch);
    // Closing
    curl_close($ch);
    
    $json = json_decode($result, true);
    
    if($json && $json['status'] == 'success'){
    	switch($json['type']){
      	case 'Play':
          $response->addPlay($json['msg']);
          $response->addRedirect($next);
        break;
        case 'Sms':
          $response->addSms($json['msg']);
          $response->addRedirect($next);
        break;
        case 'Dial':
          $response->addDial($json['msg']);
          $response->addRedirect($next);
        break;
        case 'Hangup':
        	$response->addHangup();
        break;
      	case 'Say':
        default:
          $response->Say($json['msg']);
          $response->Redirect($next);
        break;
      }
  	} elseif($json && $json['status'] != 'success'){
    	switch($json['type']){
      	case 'Play':
          $response->addPlay($json['msg']);
					$response->redirect();
        break;
        case 'Hangup':
        	$response->addHangup();
        break;
      	case 'Say':
        default:
          $response->addSay($json['msg']);
					$response->redirect();
        break;
      }
    } else {
    	error_log(print_r($json,true));
			$response->say('You have entered an invalid selection');
			$response->redirect();
    }
  } else {
  
    $gather = $response->gather(compact('numDigits'));
    // $verb = AudioSpeechPickerWidget::getVerbForValue($prompt, null);
    AudioSpeechPickerWidget::setVerbForValue($prompt, $gather);
    // $gather->append($verb);
  }
  
  
	$response->Respond();
