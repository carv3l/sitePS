<?php

	/* ------------------------------------------
	 * Constants used in application
	 * ------------------------------------------ */
	require_once ('./includes/constants.php');
	
	/* ------------------------------------------------------
	 * INCLUDE CLASS DEFINITION PRIOR TO INITIALIZING SESSION
	 * ------------------------------------------------------ */
	require_once (__ROOT__.'/includes/RemoteFileHandler.php');
	require_once (__ROOT__.'/includes/RequiredSoftwareHandler.php');
	
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


	/* ------------------------------------------
 	* initialize remote file handler
 	* ------------------------------------------ */
	$RemoteFileHandler = new RemoteFileHandler(__ROOT__.'/owasp-esapi-php/src/', $_SESSION["security-level"]);

	/* ------------------------------------------
	 * initialize required software handler
	* ------------------------------------------ */
	$RequiredSoftwareHandler = new RequiredSoftwareHandler(__ROOT__.'/owasp-esapi-php/src/', $_SESSION["security-level"]);
	

	
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
			
			//require_once (canonicalize_path($lPage,null));
			
			//require_once ($lPage);
		}else{
			if(!$RemoteFileHandler->curlIsInstalled()){
				echo $RemoteFileHandler->getNoCurlAdviceBasedOnOperatingSystem();
			}//end if
			require_once (__ROOT__."/page-not-found.php");
		}//end if
		
	}// end if page variable not set

	//require_once (__ROOT__."/includes/footer.php");
	



	function canonicalize_path($path, $cwd=null) {

		// don't prefix absolute paths
		if (substr($path, 0, 1) === "/") {
		  $filename = $path;
		}
	  
		// prefix relative path with $root
		else {
		  $root      = is_null($cwd) ? getcwd() : $cwd;
		  $filename  = sprintf("%s/%s", $root, $path);
		}
	  
		// get realpath of dirname
		$dirname   = dirname($filename);
		$canonical = realpath($dirname);
	  
		// trigger error if $dirname is nonexistent
		if ($canonical === false) {
		  trigger_error(sprintf("Directory `%s' does not exist", $dirname), E_USER_ERROR);
		}
	  
		// prevent double slash "//" below
		if ($canonical === "/") $canonical = null;
	  
		// return canonicalized path
		return sprintf("%s/%s", $canonical, basename($filename));
	  }




?>