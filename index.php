<?php
	// $lPage = basename(realpath($lPage)); 
	// 	require_once ($lPage);
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

   	//Definir o url com a váriavel de página , assim aparece "?page=home.php"
   	global $lPage;
   	$lPage = __ROOT__.'/home.php';

	if (isset($_REQUEST["page"])) {
		$lPage = $_REQUEST["page"];
		}
	    		


	//Mostrar o cabeçalho
	require_once (__ROOT__."/includes/header.php");
	
	//Pagina de default do website
	if (strlen($lPage)==0 || !isset($lPage)){
		require_once(__ROOT__."/home.php");
	}else{
		/* Todas as outras páginas */

		/* Nota:O PHP usa avaliação lenta portanto se file_exists então o php não executa remote_file_exists */
		if (file_exists($lPage) || $RemoteFileHandler->remoteSiteIsReachable($lPage)){
			
			require_once (whitelist($lPage));

		}else{ //Caso a pagina não exista
			if(!$RemoteFileHandler->curlIsInstalled()){
				echo $RemoteFileHandler->getNoCurlAdviceBasedOnOperatingSystem();
			}
			require_once (__ROOT__."/page-not-found.php");
		}
		
	}

//Função para "estudar o url"
	function whitelist($path) {
		if (substr($path, strlen($path)-6, 6) === "passwd") {
		  
			echo "<script type='text/javascript'>alert('encontrou path traversal');</script>";

		}else{

			return $path;
		}
		
	  }




?>