//An array to store all tags. To allow user to search by more than one tag
//Also, in case the user
var tags = [];
var authorID = null;
var authorName = null;

function retrieveAll(sortByCategory, asc, desc)
{
	var orderBy;
	
	if(asc.is(':visible'))
		orderBy = "ASC";
	else
		orderBy = "DESC";
	
	$.ajax({
		type  : 'GET',
		url  : 'http://localhost:8081/php/retrieveAll.php',
		data : {orderByCategory: sortByCategory, orderBy:orderBy},
		success: function (data){
			document.getElementById("imageContainer").innerHTML = data;
		},
		error: function(){
			document.getElementById("imageContainer").innerHTML = '<center><h2>An error has occurred, please try again later</h2></center>';
		}
	});
}

function removeTag(inputTag, isUserID)
{
	if(!isUserID)
	{
		tags.splice(tags.indexOf(inputTag.text()),1);
	}
	else
	{
		authorName = null;
		authorID = null;
	}
	
	inputTag.remove();
	
	//if the user removes a tag and both the tags array and the authorID are empty, retrieve all photos from feed
	if(authorID == null && tags.length == 0)
	{
		retrieveAll($('#sortBy option:selected').text(), $("#ASC"), $("#DESC"));
	}
	else
	{
		searchPhotos($('#sortBy option:selected').text(), $("#ASC"), $("#DESC"), $('#searchBar').val(), authorName, isUserID);
	}	
}

//A call to the search microservice. Treat user ID like a tag to be able to display it, but don't store it in the tag array
function searchPhotos(sortByCategory, asc, desc, inputTag, authorN, isUserID)
{	
	var orderBy;
	
	if(asc.is(':visible'))
		orderBy = "ASC";
	else
		orderBy = "DESC";
	
	if(inputTag.trim() != "")
	{
		//userID can also be null, in the event you just want to sort the list, in which case it is not necessary to change any of the global variables
		if(isUserID == false)
		{
			if(!tags.includes(inputTag))
			{
				tags.push(inputTag.trim());
				
				$("#searchDescription").append("<span id='"+inputTag.trim()+"' style='margin-bottom:10px; margin-left:5px; font-size:12px' class='label label-info' onclick='removeTag($(this), "+isUserID+")'>"+inputTag.trim()+"  <span class='glyphicon glyphicon-remove'></span></span>");
				$("#searchBar").val("");
			}
			else
			{
				alert("'"+inputTag + "' tag already included in search.");
			}
		}
		else if(isUserID == true)
		{
			authorID = inputTag;
			authorName = authorN;
			$("#searchDescription").append("<span id='"+inputTag.trim()+"' style='margin-bottom:10px; margin-left:5px; font-size:12px' class='label label-info' onclick='removeTag($(this), "+isUserID+")'>"+authorName+"  <span class='glyphicon glyphicon-remove'></span></span>");
		}
	}
	
	var tempTags = tags.join(",");
	
	document.getElementById("imageContainer").innerHTML = '<center><h2>Loading...</h2></center>';
	$.ajax({
		type  : 'GET',
		//headers: {'Access-Control-Allow-Origin': 'http://localhost:80'},
		url  : 'http://localhost:8082/php/searchPhotos.php',
		data : {authorID : authorID, tags: tempTags, orderByCategory: sortByCategory, orderBy:orderBy},
		success: function (data){
			document.getElementById("imageContainer").innerHTML = data;
		},
		error: function(){
			document.getElementById("imageContainer").innerHTML = '<center><h2>An error has occurred, please try again later</h2></center>';
		}
	});
	
}

//This function is used to determine which microservice to call when the user tries to order the results
function sortManager(sortByCategory, asc, desc, inputTag)
{
	if(sortByCategory != "No Sort")
	{
		if(tags.length == 0 && authorID == null)
		{
			retrieveAll(sortByCategory, asc, desc);
		}
		else
		{
			searchPhotos(sortByCategory, asc, desc, inputTag, authorName, null);
		}
	}
}

function sortToggle()
{
	if(!$("#DESC").is(':visible'))
	{
		$("#ASC").hide();
		$("#DESC").show();
	}
	else
	{
		$("#DESC").hide();
		$("#ASC").show();
	}
}

function toggleImgInfo(rowNumber)
{
	if(!$("#rowNumber"+rowNumber).find('#imgDetails').is(':visible'))
	{
		$("#rowNumber"+rowNumber).find('#viewOnFlickrButton').hide();
		$("#rowNumber"+rowNumber).find('#imgDetails').fadeIn(1000);
	}
	else
	{
		$("#rowNumber"+rowNumber).find('#imgDetails').hide();
		$("#rowNumber"+rowNumber).find('#viewOnFlickrButton').fadeIn(1000);
	}
}



function goToFlickr(url)
{
	window.open(url, '_blank');
}