<?php
/*$user_info = unserialize(file_get_contents($user_file));
$apps_info = unserialize(file_get_contents($apps_file));
$valid_users = array_keys($user_info);
$valid_apps = array_keys($apps_info);
if(!isset($apps_info)) $apps_info = array();
if(!isset($user_info)) $user_info = array();
foreach($user_info as $exusr => $exval)
{
	$userapps = array();
	foreach($apps_info as $exap => $val)
	{
	
		if(in_array($exusr, $val))
			array_push($userapps,$exap);
	}
	$user_info[$exusr][1] = implode(",",$userapps);
}

//	var_dump($apps_info);
$i=0;
$usersa =array( '1' => 'admin','2' => 'shdkpr2008');
$usersb = array('admin' => '1','shdkpr2008' => '2');
$appa = array( '1' => 'test');
$appb = array('test' => '1');


$i=0;
$tickcount = 0;
foreach($apps_info as $app => $appusers)
{
	global $conn;
	$i++;
	$app_file = $app_dir.$app."/".$app.".data";
	$app_progress_file = $app_dir.$app."/".$app."_progress.data";

	$app_info = file_get_contents($app_file);
	$app_info = unserialize($app_info);
	array_walk_recursive($app_info,'prepString');

	$progress = file_get_contents($app_progress_file);
	$progress = unserialize($progress);
	array_walk_recursive($progress,'prepString');
	
	$ids = array ();
	foreach($appusers as $usr => $username)
		$ids[] = $usersb[$username];

		
	$appname = $app;
	$apppath = "/app/".$appname."/";

	/*$stmt = $conn->prepare('INSERT INTO apps (appname, apppath) VALUES(?, ?);');
        $stmt->bind_param('ss',$appname, $apppath);
        if(!$stmt->execute())
            echo "FAILED!";
        $appid = $stmt->insert_id;

        $ptmt = $conn->prepare('INSERT INTO appconfig (appid, prop, val) VALUES (?, ?, ?);');
        $ptmt ->bind_param("iss", $appid, $prop, $val);

        foreach ($app_info as $prop => $val)
            if(!$ptmt->execute())
                echo "FAILED!";
        
        $ptmt = $conn->prepare('INSERT INTO appprogresscateg (appid, categname) VALUES (?, ?);');
        $ptmt ->bind_param("is", $appid, $categ);

        foreach ($progress as $categ => $progarr) {
            if(!$ptmt->execute())
                    echo "FAILED!";

            $categid = $ptmt->insert_id;
            $sptmt = $conn->prepare('INSERT INTO appprogress (categid, team, title, percent, notes) VALUES (?, ?, ?, ?, ?);');
            $sptmt ->bind_param("issss", $categid, $team, $title, $percent, $notes);

            foreach ($progarr as $index => $data) {
                $team = $data[0];
                $title = $data[1];
                $percent = $data[2];
                $notes = $data[3];

                if(!$sptmt->execute())
                    echo "FAILED!";
            }
            $sptmt->close();
		}
		
        $ptmt = $conn->prepare('INSERT INTO appsusers (appid, userid) VALUES (?, ?);');
        $ptmt ->bind_param("ii", $i, $idx);

        foreach ($ids as $idx => $userid)
            if(!$ptmt->execute())
                echo "FAILED!";
        
        $ptmt->close();

        $app_ticket_file = $app_dir.$app."/".$app."_ticket.data";
        $tickets = unserialize(file_get_contents($app_ticket_file));
        unset($tickets[0]);
        $appid = $i;
        
        
        foreach($tickets as $ticket)
        {
            $tickcount++;
            //
            $ticketstaff = array ();
            foreach($ticket["staff"] as $usr => $username)
                $ticketstaff[] = $usersb[$username];

            if(!$ticket["category"])
                $ticket["category"] ="";

                if(!$ticket["priority"])
                $ticket["priority"] ="";

                if(!$ticket["status"])
                $ticket["status"] ="";

                
                if(!$ticket["title"])
                $ticket["title"] ="";

           $stmt = $conn->prepare('INSERT INTO `tickets`(`appid`, `title`, `status`, `priority`, `category`) VALUES (?, ?, ?, ?, ?);');
            $stmt->bind_param('issss', $appid, $ticket["title"], $ticket["status"], $ticket["priority"], $ticket["category"]);
            if(!$stmt->execute()) 
            {
                echo "ERROR in 1st!";
            }
    
            $ticketid = $stmt->insert_id;

           
            $ptmt = $conn->prepare('INSERT INTO ticketsstaff (ticketid, userid) VALUES (?, ?);');
            $ptmt ->bind_param("ii", $ticketid, $userid);
    
            foreach ($ticketstaff as $idx => $userid)
                if(!$ptmt->execute())
                {
                                    echo "ERROR  in 2nd!";
                                    echo "APP : ".$appid."\n".$ticket["title"]."\n".$ticket["status"]."\n".$ticket["priority"]."\n".$ticket["category"]."\n\n";
                }
            
            $ptmt->close();

            

            foreach($ticket["messages"] as $message => $username)
            {
                $userid = $usersb[$username];

                $stmt = $conn->prepare('INSERT INTO `ticketmessages`(`ticketid`, `userid`, `message`) VALUES (?, ?, ?);');
                $stmt->bind_param('iis', $ticketid, $userid, $message);
                if(!$stmt->execute())
                {
                    echo "ERROR in 3rd!";
                    echo "APP : ".$appid."\n".$ticket["title"]."\n".$ticket["status"]."\n".$ticket["priority"]."\n".$ticket["category"]."\n\n";
                }
                 
                    
            }

        }
        /*


        $stmt = $conn->prepare('INSERT INTO `ticketmessages`(`ticketid`, `userid`, `message`) VALUES (?, ?, ?);');
        $stmt->bind_param('iis', $ticketid, $userid, $message);
        if($stmt->execute())
            return $messageid = $stmt->insert_id;

     

       
        
}

echo $tickcount;

foreach($user_info as $exusr => $exval) // array_keys($apps_info) as $exusr)// //
{
	
		//echo "INSERT INTO `users`(`username`, `password`, `email`) VALUES ('".$exusr."','".$exval[0]."','".$exval[2]."');" ;
	//echo "INSERT INTO `users`(`username`, `password`, `email`) VALUES ('".$exusr."','".$exval[0]."','".$exval[2]."');" ;
	//$i++;
	//echo "'".$exusr."' => '".$i."',";
	//echo "'".$i."' => '".$exusr."',";
}
//echo ")";
exit;
*/
?>