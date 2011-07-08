<?php

// NOTE: Do not edit this file, otherwise it's very likely your changes 
// will be overwritten with an upgrade.  

// Instead, create the file "inc/config.inc.php" and set the variables you
// want to set there. Your changes will override the defaults provided by us.

// Better description of available configuration settings you can find here:
// <https://www.poweradmin.org/trac/wiki/Documentation/ConfigurationFile>

// Database settings
$db_host		= '';
$db_port		= '';
$db_user		= '';
$db_pass		= '';
$db_name		= '';
$db_type		= '';
//$db_file		= '';		# used only for SQLite, provide full path to database file
//$db_debug		= false;	# show all SQL queries

// Security settings
// This should be changed upon install
$cryptokey		= 'p0w3r4dm1n';
$password_encryption	= 'md5';	// or md5salt

// Interface settings
$iface_lang		= 'en_EN';
$iface_style		= 'example';
$iface_rowamount	= 50;
$iface_expire		= 1800;
$iface_zonelist_serial	= false;
$iface_title 		= 'Poweradmin';

// Predefined DNS settings
$dns_hostmaster		= '';
$dns_ns1		= '';
$dns_ns2		= '';
$dns_ttl		= 86400;
$dns_fancy		= false;
$dns_strict_tld_check	= true;

// Timezone settings
// See <http://www.php.net/manual/en/timezones.php> for help.
//$timezone		= 'UTC';

// Logging settings

// Syslog usage - writes authentication attempts to syslog
// This facility could be used in combination with fail2ban to
// ban IPs with break-in attempts
$syslog_use = false;
$syslog_ident = 'poweradmin';
// On Windows usually only LOG_USER is available
$syslog_facility = LOG_USER;

?>
