<?php
/*
 * Display an entry 
 */ 

$result = "";
$dn = "";
$entry = "";
$type = "";

if (isset($_GET["dn"]) and $_GET["dn"]) {
    $dn = $_GET["dn"];
} elseif (isset($entry_dn)) {
    $dn = $entry_dn;
} else {
    $result = "dnrequired";
}

if ($result === "") {

    require_once("../conf/config.inc.php");
    require_once("../lib/ldap.inc.php");
    require_once("../lib/supann.inc.php");

    # Connect to LDAP
    $ldap_connection = wp_ldap_connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw);

    $ldap = $ldap_connection[0];
    $result = $ldap_connection[1];

    # Find object type
    if ($ldap) {

        # Search attributes
        $attributes = array();
        $search_items = $display_items;
        foreach( $search_items as $item ) {
            $attributes[] = $attributes_map[$item]['attribute'];
        }
        $attributes[] = $attributes_map[$display_title]['attribute'];

        # Search entry
        $ldap_filter = $ldap_structure_filter;
        $search = ldap_read($ldap, $dn, $ldap_filter, $attributes);

        $errno = ldap_errno($ldap);

        if ( $errno ) {
            $result = "ldaperror";
            error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
        } else {
            $entry = ldap_get_entries($ldap, $search);
	}

	# search daught entity
	#


	###### RESEARCH SUPANN SUB ENTITIIES


	$ldap_filter = "(supanncodeentiteparent=".$entry[0]['supanncodeentite'][0].")";
	$search = ldap_search($ldap, $ldap_structure_base, $ldap_filter, $supann_attributes, 0, $ldap_size_limit);

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
			#$result = "noentriesfound";
			$has_subentities = false;
	       	} else {
	            $entries = ldap_get_entries($ldap, $search);
		    unset($entries["count"]);
		    $has_subentities = true;
	        }
	}


	###### RESEARCH MEMBER OF ENTITIE

        $ldap_filter = "(supannentiteaffectation=".$entry[0]['supanncodeentite'][0].")";
        $search = ldap_search($ldap, $ldap_user_base, $ldap_filter, $attributes, 0, $ldap_size_limit);

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
                    $sortby = $attributes_map[$user_sortby]['attribute'];
                    ldap_sort($ldap, $search, $sortby);
                }
        
                # Get search results
                $nb_entries = ldap_count_entries($ldap, $search);

                if ($nb_entries === 0) {
                        #$result = "noentriesfound";
                        $has_members = false;
                } else {
                    $member_entries = ldap_get_entries($ldap, $search);
                    unset($member_entries["count"]);
                    $has_members = true;
                }
        }

    }
}

$smarty->assign("supann_entite_nomenclature_array",$supannentite_nomenclature_array);
$smarty->assign("show_subentities",$has_subentities);
$smarty->assign("show_members",$has_members);
$smarty->assign("entry", $entry[0]);
$smarty->assign("entries",$entries);
$smarty->assign("member_entries",$member_entries);
$smarty->assign("structure_base",$ldap_structure_base);
$smarty->assign("listing_columns",$supannentite_items);
$smarty->assign("listing_columns_member",$directory_items);

$smarty->assign("truncate_value_after", 20);
$smarty->assign("card_title", $display_title);
$smarty->assign("card_items", $search_items);
$smarty->assign("show_undef", $display_show_undefined);
$smarty->assign("type", $type);
?>
