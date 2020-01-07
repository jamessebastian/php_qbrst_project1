<?php

isLoggedOut();

$searchWord = (isset($_GET['search'])) ? $_GET['search'] : '';

$totalRecords = countRows($searchWord);
$totalPages   = ceil($totalRecords / PAGINATION_LIMIT);
$pageNumber   = (isset($_GET['page'])) ? $_GET['page'] : 1;
$startFrom    = ($pageNumber - 1) * PAGINATION_LIMIT;

$orderLink = "asc"; //default value

$column = (isset($_GET['column'])) ? $_GET['column'] : "f_name";

if (!isset($_GET['order'])) {
    $order = "asc";
} else {
    $order     = $_GET['order'];
    $orderLink = ($order == "asc") ? "desc" : "asc";
}

$constraints = array(
    "column" => $column,
    "order" => $order,
    "searchItem" => empty($_GET['search']) ? '' : $_GET['search'],
    "start" => $startFrom,
    "limit" => PAGINATION_LIMIT
);


$paginationConstraints = array(
    "totalPages" => $totalPages,
    "pageNumber" => $pageNumber,
    "paginationLink" => USERS_LISTING_PAGE,
    "searchWord" => $searchWord,
    "column" => $column,
    "order" => $order
);

$tableHeadDetails = array(
    array("column" => "f_name","label" => "Name" ),
    array("column" => "email","label" => "Email" ),
    array("column" => "dob","label" => "Date of birth" ),
    array("column" => "gender","label" => "Gender" ),
    array("column" => "creation_date","label" => "Join Date" )
);

/**
 * Generates table head
 *
 * @param Array $tableHeadDetails Details of each column of the table.
 *
 * @return void
 */
function generateTableHead($tableHeadDetails = []) 
{  
    global $column,$order,$searchWord,$orderLink;
    for ($i=0 ; $i< count($tableHeadDetails) ; $i++) {

        $icon = ($column == $tableHeadDetails[$i]['column']) ? (($order == 'asc') ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '';
        echo  '<th scope="col"><a href="'.USERS_LISTING_PAGE.'?search='.$searchWord.'&column='.$tableHeadDetails[$i]['column'].'&order='.$orderLink.'">'.$tableHeadDetails[$i]['label'].'  </a>'.$icon.'</th>';

    }
}

$result = getUsersList($constraints);



?>