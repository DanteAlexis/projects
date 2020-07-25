<!DOCTYPE html>
<html lang="en">
	<head>
	  <meta charset="UTF-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="css/bootstrap.css" />
	  <link rel="stylesheet" href="css/styles.css">
	  <title>myFlickrApp</title>
	</head>

	<body onload="retrieveAll($('#sortBy option:selected').text(), $('#ASC'), $('#DESC'))">
		<script src="js/jQuery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/customJS.js"></script>
	
		<div class="navbar navbar-primary" role="navigation" style="height:5%;">
			<div class="navbar-header navbar-btn navbar navbar-primary">		
				<span class="navbar-brand"><p href="home.jsp"><font size="+2" color="#ffffff">myFlickrApp</font></p></span>
			</div>
        </div>
		
		<div class="container">
			<div class="row" style="margin-bottom: 15px">
				<div class="col-xs-5 col-md-7">
					<input type="text" id="searchBar" class="form-control" placeholder="Search by tag..."/>
				</div>
				<div class="col-xs-2">
                    <button type="search" class="btn-primary form-control" onclick="searchPhotos($('#sortBy option:selected').text(), $('#ASC'), $('#DESC'), $('#searchBar').val(), null, false)">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
				</div>
				<div class="col-xs-3 col-md-2">
                    <select id="sortBy" class="form-control" onchange="sortManager($('#sortBy option:selected').text(), $('#ASC'), $('#DESC'), $('#searchBar').val())">
						<option>No Sort</option>
						<option>Title</option>
						<option>Date</option>
						<option>User</option>
					</select>
				</div>
				<div class="col-xs-2 col-md-1">
                    <button id="ASC" class="btn-primary form-control" onclick="sortToggle(); sortManager($('#sortBy option:selected').text(), $('#ASC'), $('#DESC'), $('#searchBar').val())">
                        <span class="glyphicon glyphicon-sort-by-attributes"></span>
                    </button>
					<button id="DESC" class="btn-primary form-control" style="display:none" onclick="sortToggle(); sortManager($('#sortBy option:selected').text(), $('#ASC'), $('#DESC'), $('#searchBar').val())">
                        <span class="glyphicon glyphicon-sort-by-attributes-alt"></span>
                    </button>
				</div>
			</div>
			
			<div class="row">
				<div class="panel panel-primary">
					<div class="panel-heading" style="height: 40px">
						<div style="margin-bottom:10px; height:30px; overflow-y:auto" id="searchDescription">
							<!--Populate this depending on the user query-->
							
						</div>
					</div>
					<div class="panel-body" style="height: 510px; overflow-y:auto;">
						<div id="imageContainer">
							<!--Returned image data to be place here-->
							<center><h2>Loading...</h2></center>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</body>
</html>