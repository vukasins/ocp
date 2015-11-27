<!DOCTYPE html>
<html>
<head>
<title>EU Map - Home</title>

<!-- Meta -->
<meta name="Author" content="Some Author" />
<meta name="Keywords" content="some, key, words" />
<meta name="description" content="Description" />
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no;"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<!-- CSS -->
<link rel="stylesheet" type="text/css" media="screen, projection" href="/css/default.css" />
<link rel="stylesheet" type="text/css" href="/css/bootstrap-custom.css" />
<link rel="stylesheet" type="text/css" href="/css/select2-custom.css" />
<link rel="stylesheet" type="text/css" media="only screen and (max-width: 1200px)" href="/css/mobile.css" />
<link rel="stylesheet" type="text/css" media="print" href="/css/print.css" />

<!-- Java Script -->
<script src="/jscript/jquery-1.10.2.min.js"></script>
<script src="/jscript/select2.min.js"></script>
<script src="/jscript/modernizr.custom.js"></script>
<script src="/jscript/custom.js"></script>

<!-- Icon -->
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="icon" href="/favicon.ico" type="image/ico" />

<!--[if IE 8]><link rel="stylesheet" type="text/css" href="/css/ie8.css" media="screen" /><![endif]-->
<!--[if IE 9]><link rel="stylesheet" type="text/css" href="/css/ie9.css" media="screen" /><![endif]-->
<!--[if lt IE 9]><script src="/jscript/html5.js"></script><![endif]-->

<script>
  $(document).ready(function() {
	$( ".projectTitle" ).hover(
	  function() {
		var cities = $(this).data('city-names');
		var cities_array = cities.split(',');

		for(i = 0; i < cities_array.length; i++)
		{
			var city_class = cities_array[i];
			
			$('.' + city_class).find('a').show();
		}
	  }, function() {
	    $('#map').find('a').hide();
	  }
	);
	
    $('map area').hover(
      function() {
        $('#map div a').hide();
      
        var div_class = $(this).attr('alt');
        $('div.' + div_class + ' a').show();
      }, 
      function() {
      /*
        var div_class = $(this).attr('alt');
        $('div.' + div_class + ' a').hide();
        */
      }
    );
    
    $('.col-md-6.mapBox, #map > img').hover(
      function() {
        $('#map div a').hide();
      },
      function() {
        $('#map div a').hide();
      }
    );
  });
</script>

</head>

<body>
<header>
    <div class="headerBox">
        <div class="within">
            <div class="logoHolder"> <a href="#">
                <h2>
                	<span class="bold">The Delegation of the European Union to the Republic of Serbia</span><br />
                    <span class="light">Database of funded projects</span>
                </h2>
                </a> </div>
            <!-- /logoHolder --> 
            <!-- /menuHolder --> 
        </div>
        <!-- /within --> 
    </div>
</header>
<!-- /header -->
<section class="filter">
	<div class="within">
    	<form class="form" action="" method="POST" enctype="multipart/form-data">
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                <label>Search by project title</label>
                <input type="text" name="name" value="<?=(isset($_POST['name']) ? $_POST['name'] : '')?>" class="required ">
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                <label>Sectors</label>
                <select class="sectors-select" name="sectors[]" multiple="multiple">
                		<?php foreach ($sectors as $sector):?>
	                		<option <?=(isset($_POST['sectors']) && in_array($sector->id, $_POST['sectors']) ? 'selected="selected"' : '')?> value="<?=$sector->id?>"><?=$sector->name?></option>
	                	<?php endforeach;?>
	                
                </select>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                <label>Institutions</label>
                <select class="institutions-select" multiple="multiple">
                  <option>Lorem</option>
                  <option>Ipsum</option>
                  <option>Dolor</option>
                  <option>Sit</option>
                  <option>Amet</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                <label>Regions</label>
                <select class="regions-select" name="regions-select[]" multiple="multiple">
                <?php foreach ($cities as $city): ?>
					<option <?=(isset($_POST['regions-select']) && in_array($city->id, $_POST['regions-select']) ? 'selected="selected"' : '')?> value="<?=$city->id ?>" ><?=str_replace("_", " ", $city->name); ?></option>
                <?php endforeach;?>
                </select>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                <label>NGOs</label>
                <select class="ngos-select" multiple="multiple">
                  <option>Lorem</option>
                  <option>Ipsum</option>
                  <option>Dolor</option>
                  <option>Sit</option>
                  <option>Amet</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                <label>Negotioation chapters</label>
                <select class="chapters-select" multiple="multiple">
                  <option>Lorem</option>
                  <option>Ipsum</option>
                  <option>Dolor</option>
                  <option>Sit</option>
                  <option>Amet</option>
                </select>
            </div>
            
            <input type="submit" value="Pretraži" />
        </form>
    </div>
</section>
<section class="content">
	<div class="within">
    	<div class="col-md-6">
        	<div class="titleBox">
            	<h2>List of projects</h2>
            </div>
            <div class="tableBox">
                <table width="" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <th>FATE - From army to enterpreneurship</th>
                        <th>PERIOD</th>
                    </tr>
                    <?php foreach ($projects as $project): ?>
                    	<?php 
                    		$project_cities = $project->getCitiesForProject();
                    		$cities_names = '';
                    		foreach($project_cities as $city)
                    		{
                    			if ($city->name == "Serbia")
                    			{
                    				foreach ($cities as $only_city)
                    				{
                    					$cities_names .= $only_city->name . ',';
                    				}
                    			}
                    			else
                    			{
                    				$cities_names .= $city->name . ',';
                    			}
                    		}
                    		
                    		$cities_names = trim($cities_names, ',');
                    	?>
	                    <tr>
	                        <td class="projectTitle" data-city-names="<?=$cities_names?>"><?=$project->title ?></td>
	                        <td><?=date(("Y"), strtotime($project->period_from)) ?> - <?=date(("Y"), strtotime($project->period_to)) ?></td>
	                    </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
        <div class="col-md-6 mapBox">
        	<div class="titleBox">
            	<h2>Projects on a map</h2>
            </div>
            <div style="" id="mapwrap"> 
            <!-- Start - put your content here ---> 
                <div id="map">
                        <?php foreach ($cities as $city): ?>
                          <?php if($city->coordinates == '') continue; ?>
                                  <div class="<?=$city->name; ?>"><a href="/map/projects?city_name=<?=$city->name; ?>" style="display: none;"></a></div>
                        <?php endforeach;?>
            <!--
                        <div class="Kosovska_Mitrovica"></div>
                        <div class="Kosovo"></div>
            -->
                        <div class="Pcinja"><a href="/map/projects?city_name=Pcinja" style="display: none;"></a></div>
                        <!--
            <div class="Kosovo_Pomoravlje"></div>
                        <div class="Prizren"></div>
                        <div class="Pec"></div>
            -->
                        
                        <img border="0" title="" usemap="#Map" alt="" src="/images/basic/map/serbia_map_new.png">
                            <map id="Map" name="Map">
                            	<?php foreach ($cities as $city): ?>
                                  <?php if($city->coordinates == '') continue; ?>
                                	<area alt="<?=$city->name; ?>" href="#" coords="<?=$city->coordinates; ?>" shape="poly">
                            	<?php endforeach;?>
                            </map>
                    </div><!-- end #map -->
            <!-- End   - put your content here ---> 
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="within">
        <div class="copyrightHolder">
            <p class="copyright">Copyright (c) 2015. Information Centre of European Union</p>
        </div>
    </div>
</footer>
</body>
<script>
	$(".sectors-select").select2({
		placeholder: "Select sector"
	});
	$(".institutions-select").select2({
		placeholder: "Select institutions"
	});
	$(".regions-select").select2({
		placeholder: "Select regions"
	});
	$(".ngos-select").select2({
		placeholder: "Select NGOs"
	});
	$(".chapters-select").select2({
		placeholder: "Select chapters"
	});
</script>

</html>
