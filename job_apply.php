<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);


 $info = pathinfo($_FILES['resume']['name']);
 $ext = $info['extension']; // get the extension of the file
 $name = $_POST['full_name'];
 $email = $_POST['email'];
  $newname = "resume_BA_.".$name.$email.'.'.$ext; 

 $target = 'resume/'.$newname;
 move_uploaded_file( $_FILES['resume']['tmp_name'], $target);
	
 $arr = array ('recived'=>'success');
 echo json_encode($arr); // {"a":1,"b":2,"c":3,"d":4,"e":5}
?>


<?php
    if(isset($_POST['submit']))
    {
    	$message = "new resume recieved for the position of BDE";
    	//Set the form flag to no display (cheap way!)
    	$flags = 'style="display:none;"';

    	//Deal with the email
    	$to = 'kdhallu@gmail.com';
    	$subject = 'Resume from'.$name ;

    	$attachment = chunk_split(base64_encode(file_get_contents($_FILES['resume']['tmp_name'])));
    	$filename = $_FILES['resume']['name'];

    	$boundary =md5(date('r', time())); 

    	$headers = "From: webmaster@example.com\r\nReply-To: webmaster@example.com";
    	$headers .= "\r\nMIME-Version: 1.0\r\nContent-Type: multipart/mixed; boundary=\"_1_$boundary\"";

    	$message="This is a multi-part message in MIME format.

--_1_$boundary
Content-Type: multipart/alternative; boundary=\"_2_$boundary\"

--_2_$boundary
Content-Type: text/plain; charset=\"iso-8859-1\"
Content-Transfer-Encoding: 7bit

$message

--_2_$boundary--
--_1_$boundary
Content-Type: application/octet-stream; name=\"$filename\" 
Content-Transfer-Encoding: base64 
Content-Disposition: attachment 

$attachment
--_1_$boundary--";

    	mail($to, $subject, $message, $headers);
    }
?>

