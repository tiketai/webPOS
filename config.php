<?php
defined('TIKETAI_FLOW') OR exit('No direct script access allowed');

/*
* ========================================
*   CONFIGURATION
*   'BUSINESS_SUBDOMAIN' = Your business subdomain provide by tiket.ai
* ========================================
*/

define('BUSINESS_SUBDOMAIN' , 'my_own_subdomain_from_tiket.ai');

/*
* ========================================
*   END CONFIGURATION
* ========================================
*/


date_default_timezone_set('America/Santiago');
setlocale(LC_TIME, "es_CL");
