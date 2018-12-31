<?php
/*
 * Display all entries in a table list
 */

$result = "";
$nb_entries = 0;
$entries = array();
$size_limit_reached = false;

require_once("../conf/config.inc.php");
require_once("../lib/ldap.inc.php");

# Connect to LDAP
$ldap_connection = wp_ldap_connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw);

$ldap = $ldap_connection[0];
$result = $ldap_connection[1];

if ($ldap) {

    # Search attributes
    foreach ($supannentite_items as $item) $supann_attributes[] = $attributes_map[$item]['attribute'];

    # Search for users
    $search = ldap_search($ldap, $ldap_structure_base, $ldap_structure_filter, $supann_attributes, 0, $ldap_size_limit);

    $errno = ldap_errno($ldap);

    if ( $errno == 4) {
        $size_limit_reached = true;
    }
    if ( $errno != 0 and $errno != 4 ) {
        $result = "ldaperror";
        error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
    } else {

        # Sort entries
        if (isset($search_result_sortby)) {
            $sortby = $attributes_map[$supannentite_sortby]['attribute'];
            ldap_sort($ldap, $search, $sortby);
        }

        # Get search results
        $nb_entries = ldap_count_entries($ldap, $search);

        if ($nb_entries === 0) {
            $result = "noentriesfound";
        } else {
            $entries = ldap_get_entries($ldap, $search);
            unset($entries["count"]);
        }
    }
}

$smarty->assign("supann_entite_nomenclature_array",$supannentite_nomenclature_array);
$smarty->assign("nb_entries", $nb_entries);
$smarty->assign("entries", $entries);
$smarty->assign("size_limit_reached", $size_limit_reached);

$smarty->assign("listing_columns", $supannentite_items);
$smarty->assign("listing_linkto", $supannentite_linkto);
$smarty->assign("listing_sortby", array_search($supannentite_sortby, $supannentite_items));

$smarty->assign("show_undef", $supannentite_show_undefined);
$smarty->assign("truncate_value_after", 100000 );
?>
