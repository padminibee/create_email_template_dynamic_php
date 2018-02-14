      $to = $to_email;

			$subject = 'Inquiry Form';

			$from = $email;
			
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";

			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Create email headers
			$headers .= 'From: '.$from."\r\n".

				'Reply-To: '.$from."\r\n" .

				'X-Mailer: PHP/' . phpversion();	
      
      
      $content = file_get_contents("email_template.php");
			$content = str_replace("%FormTitle%",$destination_name,$content);
			$content = str_replace("%inquiryfor%",$destination_name,$content);
			$content = str_replace("%Name%","Admin",$content);
			$content = str_replace("%passenger-name%",$passenger_name,$content);
			$content = str_replace("%mobile%",$mobile,$content);
			$content = str_replace("%email%",$email,$content);
			
			
				$content = str_replace("%column1%","Nationality",$content);
				$content = str_replace("%column1_val%",$get_country['countries_name'],$content);
				$content = str_replace("%column2%","kind of journey you looking for",$content);
				$content = str_replace("%column2_val%",$journey_desc,$content);
				
				$dom = new DOMDocument();
				$dom->loadHTML($content);
				$dom->preserveWhiteSpace = false;
				$table=$dom->getElementById('listtable');
				
				$keys = array();
				
				foreach($table->getElementsByTagName('tr') as  $key =>$tr){
					   $keyRemove = $tr->getElementsByTagName('td')->item(0)->nodeValue;
					   if($keyRemove == "%column3%" || $keyRemove == "%column4%" || $keyRemove == "%column5%" || $keyRemove == "%column6%") {
							$keys[] = $tr;						
					}
				}
				
				foreach($keys as $node) {
					$node->parentNode->removeChild($node);
				}
				 $newcontent = $dom->saveHTML();					
         
         if(mail($to, $subject, $newcontent, $headers))
				{
					echo "success";
				}
				else {
					echo "error1";
				}
