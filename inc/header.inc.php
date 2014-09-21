<?php

/*  Poweradmin, a friendly web-based admin tool for PowerDNS.
 *  See <http://www.poweradmin.org> for more details.
 *
 *  Copyright 2007-2009  Rejo Zenger <rejo@zenger.nl>
 *  Copyright 2010-2014  Poweradmin Development Team
 *      <http://www.poweradmin.org/credits.html>
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Web interface header
 *
 * @package     Poweradmin
 * @copyright   2007-2010 Rejo Zenger <rejo@zenger.nl>
 * @copyright   2010-2014 Poweradmin Development Team
 * @license     http://opensource.org/licenses/GPL-3.0 GPL
 */
global $iface_style;
global $iface_title;
global $ignore_install_dir;
global $session_key;

header('Content-type: text/html; charset=utf-8');
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\n";
echo "<html>\n";
echo " <head>\n";
echo "  <title>" . $iface_title . "</title>\n";
//echo "  <link rel=stylesheet href=\"style/" . $iface_style . ".css\" type=\"text/css\">\n";
echo "<link rel=\"stylesheet\" href=\"style/bootstrap/bootstrap.min.css\">\n";
echo "<link rel=\"stylesheet\" href=\"style/bootstrap/custom.css\">\n";
echo "<script src=\"/style/bootstrap/js/jquery-1.11.1.min.js\"></script>\n";
echo "<script src=\"/style/bootstrap/js/bootstrap.min.js\"></script>\n";
echo "  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\n";
echo " </head>\n";
echo " <body>\n";
echo " <div id=\"wrap\">\n";

/*if (file_exists('inc/custom_header.inc.php')) {
    include('inc/custom_header.inc.php');
} else {
    echo "  <h1>" . $iface_title . "</h1>\n";
}*/

// this config variable is used only for development, do not use it in production
//if (($ignore_install_dir == NULL || $ignore_install_dir == false) && file_exists ( 'install' )) {
if (file_exists('install')) {
    echo "<div>\n";
    error(ERR_INSTALL_DIR_EXISTS);
    include ('inc/footer.inc.php');
    exit();
} elseif (isset($_SESSION ["userid"])) {
    do_hook('verify_permission', 'search') ? $perm_search = "1" : $perm_search = "0";
    do_hook('verify_permission', 'zone_content_view_own') ? $perm_view_zone_own = "1" : $perm_view_zone_own = "0";
    do_hook('verify_permission', 'zone_content_view_others') ? $perm_view_zone_other = "1" : $perm_view_zone_other = "0";
    do_hook('verify_permission', 'supermaster_view') ? $perm_supermaster_view = "1" : $perm_supermaster_view = "0";
    do_hook('verify_permission', 'zone_master_add') ? $perm_zone_master_add = "1" : $perm_zone_master_add = "0";
    do_hook('verify_permission', 'zone_slave_add') ? $perm_zone_slave_add = "1" : $perm_zone_slave_add = "0";
    do_hook('verify_permission', 'supermaster_add') ? $perm_supermaster_add = "1" : $perm_supermaster_add = "0";
    do_hook('verify_permission', 'user_is_ueberuser') ? $perm_is_godlike = "1" : $perm_is_godlike = "0";

    if ($perm_is_godlike == 1 && $session_key == 'p0w3r4dm1n') {
        error(ERR_DEFAULT_CRYPTOKEY_USED);
        echo "<br>";
    }

    echo "<nav class=\"navbar navbar-inverse navbar-static-top\" role=\"navigation\">\n";
    echo "<div class=\"container-fluid\">\n";

    echo "<div class=\"navbar-header\">\n";
    echo "<a class=\"navbar-brand\" href=\"index.php\">" . $iface_title . "</a>\n";
    echo "</div>\n";

    echo "<ul class=\"nav navbar-nav\">\n";
    if ($perm_view_zone_own == "1" || $perm_view_zone_other == "1") {
        echo "  <li><a href=\"list_zones.php\">" . _('Zones') . "</a></li>\n";
    }
    if ($perm_zone_master_add) {
        echo "  <li><a href=\"list_zone_templ.php\">" . _('Templates') . "</a></li>\n";
    }
    if ($perm_supermaster_view) {
        echo "  <li><a href=\"list_supermasters.php\">" . _('Supermasters') . "</a></li>\n";
    }
    if ($perm_zone_master_add or $perm_zone_slave_add or $perm_supermaster_add or $perm_zone_master_add) {
      echo "  <li class=\"dropdown\">\n";
      echo "    <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Add <span class='caret'></span></a>\n";
      echo "    <ul class='dropdown-menu' role='menu'>\n";
      if ($perm_zone_master_add) {
          echo "      <li><a href=\"add_zone_master.php\">" . _('Add master zone') . "</a></li>\n";
      }
      if ($perm_zone_slave_add) {
          echo "      <li><a href=\"add_zone_slave.php\">" . _('Add slave zone') . "</a></li>\n";
      }
      if ($perm_supermaster_add) {
          echo "      <li><a href=\"add_supermaster.php\">" . _('Add supermaster') . "</a></li>\n";
      }
      if ($perm_zone_master_add) {
          echo "      <li><a href=\"bulk_registration.php\">" . _('Bulk registration') . "</a></li>\n";
      }
      echo "    </ul>\n  </li>\n";
    }
    if ($perm_search == "1") {
        echo "  <li><a href=\"search.php\">" . _('Search') . "</a></li>\n";
    }
    echo "</ul>\n";

    echo "<ul class=\"nav navbar-nav navbar-right\">";
    echo "<li class=\"dropdown\">\n";
    echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$_SESSION["name"]." <span class=\"caret\"><span></a>\n";
    echo "<ul class=\"dropdown-menu\" role=\"menu\">\n";
    if ($_SESSION ["auth_used"] != "ldap") {
        echo "    <li><a href=\"change_password.php\">" . _('Change password') . "</a></li>\n";
    }
    echo "    <li><a href=\"users.php\">" . _('User administration') . "</a></li>\n";
    echo "    <li><a href=\"index.php?logout\">" . _('Logout') . "</a></li>\n";
    echo "</ul></li></ul>\n";

    echo "</div>\n"; // .container-fluid
    echo "</nav>\n"; // nav
}
echo "    <div class=\"container-fluid\">\n";
