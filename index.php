<?php

	/* ------------------------------------------
	 * Constants used in application
	 * ------------------------------------------ */
	require_once ('./includes/constants.php');
	
	/* ------------------------------------------------------
	 * INCLUDE CLASS DEFINITION PRIOR TO INITIALIZING SESSION
	 * ------------------------------------------------------ */
	require_once (__ROOT__.'/owasp-esapi-php/src/ESAPI.php');
	require_once (__ROOT__.'/classes/MySQLHandler.php');
	require_once (__ROOT__.'/classes/SQLQueryHandler.php');
	require_once (__ROOT__.'/classes/CustomErrorHandler.php');
	require_once (__ROOT__.'/classes/LogHandler.php');
	require_once (__ROOT__.'/classes/BubbleHintHandler.php');
	require_once (__ROOT__.'/classes/RemoteFileHandler.php');
	require_once (__ROOT__.'/classes/RequiredSoftwareHandler.php');
	
    /* ------------------------------------------
     * INITIALIZE SESSION
     * ------------------------------------------ */
	//initialize session
    if (strlen(session_id()) == 0){
    	session_start();
    }// end if

    // ----------------------------------------
	// initialize security level to "insecure" 
	// ----------------------------------------
    if (!isset($_SESSION['security-level'])){
    	$_SESSION['security-level'] = '0';
    }// end if

    

	$CustomErrorHandler = new CustomErrorHandler(__ROOT__.'/owasp-esapi-php/src/', $_SESSION["security-level"]);
	

	$LogHandler = new LogHandler(__ROOT__.'/owasp-esapi-php/src/', $_SESSION["security-level"]);	
		

	$MySQLHandler = new MySQLHandler(__ROOT__.'/owasp-esapi-php/src/', $_SESSION["security-level"]);
	$MySQLHandler->connectToDefaultDatabase();


	$SQLQueryHandler = new SQLQueryHandler(__ROOT__.'/owasp-esapi-php/src/', $_SESSION["security-level"]);
	

	$BubbleHintHandler = new BubbleHintHandler(__ROOT__.'/owasp-esapi-php/src/', $_SESSION["security-level"]);
	
	if ($_SESSION["showhints"] != $BubbleHintHandler->getHintLevel()){
		$BubbleHintHandler->setHintLevel($_SESSION["showhints"]);
	}//end if

	/* ------------------------------------------
 	* initialize remote file handler
 	* ------------------------------------------ */
	$RemoteFileHandler = new RemoteFileHandler(__ROOT__.'/owasp-esapi-php/src/', $_SESSION["security-level"]);

	/* ------------------------------------------
	 * initialize required software handler
	* ------------------------------------------ */
	$RequiredSoftwareHandler = new RequiredSoftwareHandler(__ROOT__.'/owasp-esapi-php/src/', $_SESSION["security-level"]);
	
	/* ------------------------------------------
	* PROCESS REQUESTS
	* ------------------------------------------ */
	if (isset($_GET["do"])){
		include_once(__ROOT__.'/includes/process-commands.php');
	}// end if
    
	
   	header("Content-Type: text/html", TRUE);
   	
	/* ------------------------------------------
     * DISPLAY PAGE
     * ------------------------------------------ */

   	/* ------------------------------------------
    * "PAGE" VARIABLE INJECTION
    * ------------------------------------------ */
   	global $lPage;
   	$lPage = __ROOT__.'/home.php';
	switch ($_SESSION["security-level"]){
   		case "0": // This code is insecure
   		case "1": // This code is insecure
		   // Get the value of the "page" URL query parameter
		    if (isset($_REQUEST["page"])) {
		    	$lPage = $_REQUEST["page"];
		    }// end if
   		break;
	    		
   	}// end switch
	/* ------------------------------------------
    * END "PAGE" VARIABLE INJECTION
    * ------------------------------------------ */



 	
	/* ------------------------------------------
	* END SIMULATE "SECRET" PAGES
	* ------------------------------------------ */

	/* ------------------------------------------
	* BEGIN OUTPUT RESPONSE
	* ------------------------------------------ */
	require_once (__ROOT__."/includes/header.php");
	
	if (strlen($lPage)==0 || !isset($lPage)){
		/* Default Page */
		require_once(__ROOT__."/home.php");
	}else{
		/* All Other Pages */

		/* Note: PHP uses lazy evaluation so if file_exists then PHP wont execute remote_file_exists */
		if (file_exists($lPage) || $RemoteFileHandler->remoteSiteIsReachable($lPage)){
			require_once ($lPage);
		}else{
			if(!$RemoteFileHandler->curlIsInstalled()){
				echo $RemoteFileHandler->getNoCurlAdviceBasedOnOperatingSystem();
			}//end if
			require_once (__ROOT__."/page-not-found.php");
		}//end if
		
	}// end if page variable not set

	require_once (__ROOT__."/includes/footer.php");
	





   	/* ------------------------------------------
   	 * LOG USER VISIT TO PAGE
   	* ------------------------------------------ */
   	//include_once (__ROOT__."/includes/log-visit.php");
		
	   


   	/* ------------------------------------------
   	 * CLOSE DATABASE CONNECTION
   	* ------------------------------------------ */
   	//$MySQLHandler->closeDatabaseConnection();



	// /* ------------------------------------------
	// * Anti-framing protection (Older Browsers)
	// * ------------------------------------------ */
	// if ($lIncludeFrameBustingJavaScript){
	// 	include_once (__ROOT__."/includes/anti-framing-protection.inc");	
	// }// end if    
	
	





	// /* ------------------------------------------
	// * Add javascript includes
	// * ------------------------------------------ */
   	// include_once (__ROOT__."/includes/create-html-5-web-storage-target.inc");	
   	// require_once (__ROOT__."/includes/jquery-init.inc");
   	
   	// if (isset($_GET["popUpNotificationCode"])){
   	// 	include_once (__ROOT__."/includes/pop-up-status-notification.inc");
	//    }// end if
	   

?>