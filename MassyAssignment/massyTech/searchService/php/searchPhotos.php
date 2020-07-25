<?php
//This script retrieves the flicker feed irrespective of tag and displays the results
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
	header('Access-Control-Allow-Headers: Origin, Content-Type, Host');

	
	$sortCategory = $_GET["orderByCategory"];
	$sortOrder = $_GET["orderBy"];
	$authorID = $_GET["authorID"];
	$tags = $_GET["tags"];
	
	$url = "https://api.flickr.com/services/feeds/photos_public.gne?format=php_serial&id=$authorID&tags=$tags";
	$feed = unserialize(file_get_contents($url));
	
	$photos = $feed['items'];

	$usableDisplayURL = array();
	$usableURL = array(); ;
	$usableTitle = array() ;
	$usableAuthorName = array();
	$usableAuthorDisName =array();
	$usableAuthorID = array();
	$usableImgTags = array();
	$usableDisplayDate = array();
	$usableDate = array();
	
	$rowNumber = 0;

	//Load values into array and check if the user wants the array sorted at all
	foreach($photos as $photo)
	{
		array_push($usableDisplayURL, $photo["m_url"]);
		array_push($usableURL, '"'.$photo["url"].'"');
		array_push($usableTitle, $photo["title"]);
		array_push($usableAuthorName, '"'.$photo["author_name"].'"');
		array_push($usableAuthorDisName, $photo["author_name"]);
		array_push($usableAuthorID, "'".$photo["author_nsid"]."'");
		array_push($usableImgTags, $photo["tags"]);
		array_push($usableDisplayDate, $photo["date_taken_nice"]);
		array_push($usableDate, $photo["date_taken"]);
		
	}
	
	//Order the array if necessary
	if($sortCategory == "Title" && $sortOrder == "ASC")
	{
		array_multisort($usableTitle, SORT_ASC, SORT_NATURAL, $usableDisplayURL, $usableDisplayDate, $usableDate, $usableURL, $usableAuthorName, $usableAuthorDisName, $usableAuthorID, $usableImgTags);
	}
	elseif($sortCategory == "Title" && $sortOrder == "DESC")
	{
		array_multisort($usableTitle, SORT_DESC, SORT_NATURAL, $usableDisplayURL, $usableDisplayDate, $usableDate, $usableURL, $usableAuthorName, $usableAuthorDisName, $usableAuthorID, $usableImgTags);
	}
	elseif($sortCategory == "User" && $sortOrder == "ASC")
	{
		array_multisort($usableAuthorName, SORT_ASC, SORT_NATURAL , $usableDisplayURL, $usableDisplayDate, $usableDate, $usableURL, $usableTitle, $usableAuthorDisName, $usableAuthorID, $usableImgTags);
	}
	elseif($sortCategory == "User" && $sortOrder == "DESC")
	{
		array_multisort($usableAuthorName, SORT_DESC, SORT_NATURAL, $usableTitle, $usableDisplayURL, $usableDisplayDate, $usableDate, $usableURL, $usableAuthorDisName, $usableAuthorID, $usableImgTags);
	}
	elseif($sortCategory == "Date" && $sortOrder == "ASC")
	{
		array_multisort($usableDate, SORT_ASC, SORT_NATURAL, $usableAuthorName, $usableDisplayURL, $usableDisplayDate, $usableURL, $usableTitle, $usableAuthorDisName, $usableAuthorID, $usableImgTags);
	}
	elseif($sortCategory == "Date" && $sortOrder == "DESC")
	{
		array_multisort($usableDate, SORT_DESC, SORT_NATURAL, $usableAuthorName,$usableTitle, $usableDisplayURL, $usableDisplayDate, $usableURL, $usableAuthorDisName, $usableAuthorID, $usableImgTags);
	}
	
	//Return HTML response
	for($i = 0; $i < count($usableURL); $i++)
	{
		//Store it in variables as I need to pass these to a js function. Capturing them inline will cause triple nested quotes
		$imgTags = "'".$photo["tags"][$i]."'";
		//The medium size image makes it a little easier to view
		$photoDisplayUrl = $usableDisplayURL[$i];
		$photoUrl = $usableURL[$i];
		$photoTitle = "'".$usableTitle[$i]."'";
		$authorName = "'".$usableAuthorDisName[$i]."'";
		$authorDisplayName = $usableAuthorDisName[$i];
		$authorID = $usableAuthorID[$i];
		$date = $usableDate[$i];
		$displayDate = $usableDisplayDate[$i];
		
		//The method signature for searchPhotos will also result in triple nested quotes, so store it in a variable
		$sortBySelector = "$('#sortBy option:selected').text()";
		$ascSelector = "$('#ASC')";
		$descSelector = "$('#DESC')";
		$searchBarSelector = "$('#searchBar').val()";

		$searchPhotos = 'onclick="searchPhotos('.$sortBySelector.','. $ascSelector.','. $descSelector.', '.$authorID.','. $authorName.', true)"';
		
		//These are the rows, partitions and information displayed to the screen
		echo	"<div id='rowNumber$rowNumber' class='row' style='width: 98%; margin-left: 20px; margin-top: 20px; height:250px; border-width: 1px; border-style: solid; border-color:#337ab7; border-radius:5px; box-shadow:0px 2px 5px 6px #ccc'>
					<div class='col-xs-4 col-md-4' style='margin-right:20px; height: 100%; width: 300px; border-width: 0px 1px 0px 0px; border-style: solid; border-color:#337ab7; border-radius:5px 0px 0px 5px; position: relative;'>
						<img style='cursor:pointer; margin-left:20px; top: 50%; position: absolute; transform: translateY(-50%);' src='$photoDisplayUrl' onclick='toggleImgInfo($rowNumber)'>
					</div>
					<div class='col-xs-4 col-offset-xs-0 col-md-4 col-offset-md-3'>
						<button id='viewOnFlickrButton' class='form-control button-primary' style='margin-top:20px' onclick='goToFlickr($photoUrl)'>
							View on Flickr
						</button>
						<div id='imgDetails' style='display:none'>
							<div id='imgTitle' style='margin-top:10px'>
								Image Title: $photoTitle
							</div>
							<div id='imgAuthor' style='margin-top:10px'>
								Author: <a style='cursor:pointer' $searchPhotos>$authorDisplayName</a>
							</div>
							<div id='imgDate' class='$date' style='margin-top:10px'>
								Date Taken: $displayDate
							</div>
							<div id='imgTags' style='margin-top:10px'>
								Tags: $tags
							</div>
						</div>
					</div>
				</div>";
		$rowNumber++;
	}
?>