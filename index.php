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

    /* ----------------------------------------------------
     * ENFORCE SSL
     * ----------------------------------------------------
     * If the user would like to enforce the use of SSL,
     * redirect any HTTP requests "up to" HTTPS. Otherwise
     * keep the URL the same.
     * ---------------------------------------------------- */
    if (!isset($_SESSION["EnforceSSL"])){
    	$_SESSION["EnforceSSL"] = "False";
    }// end if
    
    switch ($_SESSION["security-level"]){
    	case "0": // This code is insecure
    	case "1": // This code is insecure
		    if ($_SESSION["EnforceSSL"] == "True"){
		    	if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS']!="on"){
		    		$lSecureRedirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		    		header("Location: $lSecureRedirect");
		    		exit();
		    	}//end if
		    }//end if
   		break;
    			
	}// end switch    
	


    
    // /* ----------------------------------------------------
    //  * Initialize logged in status
    //  * ----------------------------------------------------
    //  * user is logged out by default
    //  */
    // if (!isset($_SESSION["loggedin"])){
	//     $_SESSION['loggedin'] = 'False';
	//     $_SESSION['logged_in_user'] = '';
	//     $_SESSION['logged_in_usersignature'] = '';	    	
    // }// end if    
    
    // /* ----------------------------------------------------
    //  * Check if user wants to disregard any detected
    //  * database errors
    //  * ----------------------------------------------------
    //  * user is logged out by default
    //  */
    // if (!isset($_SESSION["UserOKWithDatabaseFailure"])) {
    // 	$_SESSION["UserOKWithDatabaseFailure"] = "FALSE";
    // }// end if
	
	










    // /* ----------------------------------------
    //  * initialize showhints session and cookie
    //  * ----------------------------------------
	//  * This code is here to create a simulated vulnerability. Some
	//  * sites put authorication and status tokens in cookies instead
	//  * of the session. This is a mistake. The user controls the 
	//  * cookies entirely.
	// */    
	// if (isset($_COOKIE["showhints"])){
	// 	$l_showhints = $_COOKIE["showhints"];
	// }else{
	// 	$l_showhints = 1;

	// 	/*
	// 	 * If in secure mode, we want the cookie to be protected
	// 	 * with HTTPOnly flag. There is some irony here. In secure code,
	// 	 * we are to ignore authorization cookies, so we are protecting
	// 	 * a cookie we know we are going to ignore. But the point is to
	// 	 * provide an example to developers of proper coding techniques.
	// 	 */
	//    	switch ($_SESSION["security-level"]){
	//    		case "0": // This code is insecure
	//    		case "1": // This code is insecure
	//    			$lProtectCookies = FALSE;
	//    		break;

	//    	}// end switch		
		
	// 	if ($lProtectCookies){
	// 		setcookie('showhints', $l_showhints.";HTTPOnly");
	// 	}else {
	// 		setcookie('showhints', $l_showhints);
	// 	}// end if $lProtectCookies
	// }// end if (isset($_COOKIE["showhints"])){

	// if (!isset($_SESSION["showhints"]) || ($_SESSION["showhints"] != $l_showhints)){
	// 	// make session = cookie
	// 	$_SESSION["showhints"] = $l_showhints;
	// 	switch ($l_showhints){
	// 		case 0: $_SESSION["hints-enabled"] = "Disabled (".$l_showhints." - I try harder)"; break;
	// 		case 1: $_SESSION["hints-enabled"] = "Enabled (".$l_showhints." - Try easier)"; break;
	// 	}// end switch
	// }//end if
	
	// /* ------------------------------------------
	//  * initialize OWASP ESAPI for PHP
	//  * ------------------------------------------ */
	// /*
	// if (!is_object($_SESSION["Objects"]["ESAPIHandler"])){
	// 	$_SESSION["Objects"]["ESAPIHandler"] = new ESAPI(__ROOT__.'/owasp-esapi-php/src/ESAPI.xml');
	// 	$_SESSION["Objects"]["ESAPIEncoder"] = $_SESSION["Objects"]["ESAPIHandler"]->getEncoder();
	// 	$_SESSION["Objects"]["ESAPIRandomizer"] = $_SESSION["Objects"]["ESAPIHandler"]->getRandomizer();
	// }// end if
	
	// // Set up an alias by reference so object can be referenced in memory without copying
	// $ESAPI = &$_SESSION["Objects"]["ESAPIHandler"];
	// $Encoder = &$_SESSION["Objects"]["ESAPIEncoder"];
	// $ESAPIRandomizer = &$_SESSION["Objects"]["ESAPIRandomizer"];
	// */
	// $ESAPI = new ESAPI(__ROOT__.'/owasp-esapi-php/src/ESAPI.xml');
	// $Encoder = $ESAPI->getEncoder();
	// $ESAPIRandomizer = $ESAPI->getRandomizer();

	// /* ------------------------------------------
 	// * Test for database availability
 	// * ------------------------------------------ */

	// function handleError($errno, $errstr, $errfile, $errline, array $errcontext){
	// 	/*
	// 	restore_error_handler();
	// 	restore_exception_handler();
	// 	header("Location: database-offline.php", true, 302);
	// 	exit();
	// 	*/
	// }// end function

	// function handleException($exception){
	// 	//restore_error_handler();
	// 	restore_exception_handler();
	// 	header("Location: database-offline.php", true, 302);
	// 	exit();
	// }// end function

	// if ($_SESSION["UserOKWithDatabaseFailure"] == "FALSE") {
	// 	//set_error_handler('handleError', E_ALL & ~E_NOTICE);
	// 	set_exception_handler('handleException');
	//     	MySQLHandler::databaseAvailable();
	// 	//restore_error_handler();
	// 	restore_exception_handler();
	// }//end if







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
    
	/* ------------------------------------------
	* PROCESS LOGIN ATTEMPT (IF ANY)
	* ------------------------------------------ */
	if (isset($_POST["login-php-submit-button"])){
		include_once(__ROOT__.'/includes/process-login-attempt.php');
	}// end if

	// /* ------------------------------------------
    //  * REACT TO CLIENT SIDE CHANGES
    //  * ------------------------------------------ */
	// switch ($_SESSION["security-level"]){
   	// 	case "0": // This code is insecure
   	// 	case "1": // This code is insecure
	// 		/* Use the clients authorization token which is stored in
	// 		 * the cookie (in this case). Placing authorization tokens
	// 		 * on the client is fairly ridiculous.
	// 		 * 
	// 		 * Known Vulnerabilities: SQL Injection, Authorization Bypass, Session Fixation,
	// 		 * 	Lack of custom error page, Application Exception
	// 		 */
   	// 		if (isset($_COOKIE['uid'])){
 
	// 			try{
	// 				$lQueryResult = $SQLQueryHandler->getUserAccountByID($_COOKIE['uid']);
					
	// 			    // Switch to whatever cookie the user sent to simulate sites
	// 			    // that use client-side authorization tokens. Auth information
	// 			    // should never be in cookies.
	// 			    if ($lQueryResult->num_rows > 0) {
	// 				    $row = $lQueryResult->fetch_object();
	// 					$_SESSION['loggedin'] = 'True';
	// 					$_SESSION['uid'] = $row->cid;
	// 					$_SESSION['logged_in_user'] = $row->username;
	// 					$_SESSION['logged_in_usersignature'] = $row->mysignature;
	// 					$_SESSION['is_admin'] = $row->is_admin;
   	// 					header('Logged-In-User: '.$_SESSION['logged_in_user'], true);
	// 		    	}// end if ($result->num_rows > 0)
				    
	// 			} catch (Exception $e) {
	// 		   		echo $CustomErrorHandler->FormatError($e, $lQueryString); 
	// 		   	}// end try
   	// 		}else{
	//    			/* 
	//    			 * Output the user's login name into a custom header 
	//    			 * 
	//    			 * Known Vulnerability: Potential HTTP Response Splitting
	//    			 * (PHP defends itself against HTTP response splitting by
	//    			 * filtering "new line" characters)
	//    			 */
   	// 			header('Logged-In-User: '.$_SESSION['logged_in_user'], true);
   	// 		}// end if

   	// 	break;

   	// }// end switch
	// /* ------------------------------------------
    //  * END REACT TO CLIENT SIDE CHANGES
	//  * ------------------------------------------ */
	



   	// /* ------------------------------------------
   	//  * PHP Version Detection
   	//  * ------------------------------------------ */
   	// try{
   	//     /*
   	//      * This section detects if the header_remove() function should
   	//      * be supported. PHP 5.3 first includes this function.
   	//      */
   	//     $l_header_remove_supported = FALSE;
   	//     $l_phpversion = explode(".", phpversion());
   	//     $l_phpmajorversion = (int)$l_phpversion[0];
   	//     $l_phpminorversion = (int)$l_phpversion[1];
   	//     if (($l_phpmajorversion >= 5 && $l_phpminorversion >= 3) || $l_phpmajorversion > 5){
   	//         $l_header_remove_supported = TRUE;
   	//     }else{
   	//         $l_header_remove_supported = FALSE;
   	//     }// end if
   	// } catch (Exception $e) {
   	//     //Bummer: Not sure if we have support
   	//     $l_header_remove_supported = FALSE;
   	// }// end try
   	
   	// /* ------------------------------------------
    // * Security Headers (Modern Browsers)
    // * ------------------------------------------ */

   	// /* If not security level 5, try to get rid of cache-control */
   	// if ($_SESSION["security-level"] < 5) {
   	    
   	//     try{
   	//         /*
   	//          * This section is the cache-control. This only works in PHP 5.3
   	//          * and higher due to the header_remove function becoming
   	//          * available at that time.
   	//          */
   	//         if ($l_header_remove_supported){
   	//             /* Try to get rid of expires, last-modified, Pragma,
   	//              * cache control header, HTTP/1.1 and cookie cache control
   	//              * that would be created if the user
   	//              * enabled security level 5.
   	//              */
   	//             header_remove("Expires");
   	//             header_remove("Last-Modified");
   	//             header_remove("Cache-Control");
   	//             header_remove("Pragma");
   	//         }else{
   	//             /* Try to get rid of expires, last-modified, Pragma,
   	//              * cache control header, HTTP/1.1 and cookie cache control
   	//              * that would be created if the user
   	//              * enabled security level 5.
   	//              */
   	//             /*This line causes severe issues with the toggle security and toggle hints.
   	//              DO NOT uncomment until a patch is found.
   	//              header("Expires: Mon, 26 Jul 2050 05:00:00 GMT", TRUE);
   	//              */
   	//             header("Last-Modified: Mon, 26 Jul 2050 05:00:00 GMT", TRUE);
   	//             header('Cache-Control: public', TRUE);
   	//             header("Pragma: public", TRUE);
   	//         }// end if
   	//     } catch (Exception $e) {
   	//         //Bummer: The cahce-control exercise are not working
   	//     }// end try
   	    
    // }//end if
   	
	// switch ($_SESSION["security-level"]){
   	// 	case "0": // This code is insecure
   	// 		$lIncludeFrameBustingJavaScript = FALSE;
   			
   	// 		/* Built-in user-agent defenses */
   	// 		header("X-XSS-Protection: 0", TRUE);
   			
   	// 		/* Disable HSTS */
   	// 		header("Strict-Transport-Security: max-age=0", TRUE);
   			
   	// 	break;
   		
   	// 	case "1":
   	// 	    /* Cross-frame scripting and click-jacking */
   	// 	    $lIncludeFrameBustingJavaScript = TRUE;
   		    
   	// 	    /* Built-in user-agent defenses */
   	// 	    header("X-XSS-Protection: 0", TRUE);
   		    
	// 		/* Disable HSTS */
	// 		header("Strict-Transport-Security: max-age=0", TRUE);
			
	// 	break;
   		
   	// }// end switch
	// /* ------------------------------------------
    // * END Security Headers (Modern Browsers)
    // * ------------------------------------------ */
	 
   	/* ------------------------------------------
   	 * Set the HTTP content-type of this page
   	 * ------------------------------------------ */
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