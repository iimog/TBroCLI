<?php

//TODO: http://jqueryui.com/tooltip/#custom-content
function smarty_function_dbxreflink($params, &$smarty) {
    require_once 'TranscriptDB//db.php';
    global $db_urls, $db;
    if (!isset($db_urls))
        $db_urls = array(
            'GO' => 'http://amigo.geneontology.org/cgi-bin/amigo/term_details?term=GO:',
            'HMMSmart' => 'http://smart.embl-heidelberg.de/smart/do_annotation.pl?BLAST=DUMMY&DOMAIN=',
            'superfamily' => 'http://supfam.cs.bris.ac.uk/SUPERFAMILY/cgi-bin/search.cgi?search_field=',
        );

    if (!isset($db_urls[$params['dbxref']['dbname']])) {
        $stm = $db->prepare('SELECT urlprefix FROM db WHERE name=:dbname');
        $stm->bindValue('dbname', $params['dbxref']['dbname']);
        $stm->execute();
        if (($row = $stm->fetch(PDO::FETCH_ASSOC)) != false) {
            $db_urls[$params['dbxref']['dbname']] = $row['urlprefix'];
        }
        else
            $db_urls[$params['dbxref']['dbname']] = '';
    }
    $description = sprintf('<span class="has-tooltip" data-dbxref="DbxRef|%1$s:%2$s" data-name="Name|%3$s"  data-dbversion="DBVersion|%4$s" data-definition="Definition|%5$s">%1$s:%2$s %3$s</td></span>'
            , $params['dbxref']['dbname']
            , $params['dbxref']['accession']
            , $params['dbxref']['name']
            , !empty($params['dbxref']['dbversion']) ? $params['dbxref']['dbversion'] : ''
            , $params['dbxref']['definition']
        );
    
    // use definition instead of name in the EC table
    if($params['dbxref']['dbname'] === 'EC'){
        $description = sprintf('<span class="has-tooltip" data-dbxref="DbxRef|%1$s:%2$s" data-name="Name|%3$s"  data-dbversion="DBVersion|%4$s" data-definition="Definition|%5$s">%1$s:%2$s %5$s</span>'
            , $params['dbxref']['dbname']
            , $params['dbxref']['accession']
            , $params['dbxref']['name']
            , !empty($params['dbxref']['dbversion']) ? $params['dbxref']['dbversion'] : ''
            , $params['dbxref']['definition']
        );
    }

    if ($db_urls[$params['dbxref']['dbname']] == ''){
        // somewhat special if you are looking for ECs
        if($params['dbxref']['dbname'] === 'EC'){
            $accession_path = str_replace ('.', '/', $params['dbxref']['accession']);
            return sprintf('<a href="%1$s%2$s.html" target="_blank">%3$s</a>', 'http://www.chem.qmul.ac.uk/iubmb/enzyme/EC', $accession_path, $description);
        }
        else
            return $description;
    }
    else
        return sprintf('<a href="%1$s%2$s" target="_blank">%3$s</a>', $db_urls[$params['dbxref']['dbname']], $params['dbxref']['accession'], $description);
}

?>
