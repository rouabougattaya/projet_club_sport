<?php
// Redirect root entry to public front controller while keeping the query string
$queryString = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== ''
    ? ('?' . $_SERVER['QUERY_STRING'])
    : '';
header('Location: public/index.php' . $queryString, true, 302);
exit;


