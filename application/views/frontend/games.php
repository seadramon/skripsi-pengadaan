<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
        <title>Matahari Mall</title>
        <meta name="author" content="Matahari Mall">
        <meta name="description" content="Online shop MatahariMall.com menyediakan ratusan ribu pilihan produk dengan harga terbaik dari segala kebutuhan, mulai dari fashion wanita, fashion pria, produk kecantikan, handphone, laptop, gadget, elektronik, hobi, makanan & minuman, dan lainnya.">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="developer" content="PT. Jayadata Indonesia">

        <meta property="og:locale" content="id_ID"/>
        <meta property="og:url" content="<?=base_url()?>" />
        <meta property="og:title" content="Matahari Mall" />
        <meta property="og:description" content="Online shop MatahariMall.com menyediakan ratusan ribu pilihan produk dengan harga terbaik dari segala kebutuhan, mulai dari fashion wanita, fashion pria, produk kecantikan, handphone, laptop, gadget, elektronik, hobi, makanan & minuman, dan lainnya." />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="<?=base_url()?>assets/frontend/img/mataharimall-og.jpg" />
        <meta property="og:site_name" content="Matahari Mall"/>

        <meta name="twitter:card" content="summary">
        <meta name="twitter:creator" content="@mataharimallcom">
        <meta name="twitter:site" content="@mataharimallcom">
        <meta name="twitter:title" content="Matahari Mall">
        <meta name="twitter:description" content="Online shop MatahariMall.com menyediakan ratusan ribu pilihan produk dengan harga terbaik dari segala kebutuhan">
        <meta name="twitter:image" content="<?=base_url()?>assets/frontend/img/mataharimall-og.jpg" />

		<!-- FAVICON -->
		<link rel="shortcut icon" href="https://cdn2.mataharimall.co/sites/default/files/favicon.ico" />

		<!-- STYLESHEETS -->
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/grid.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/main.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/style.css" >
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/js/fancybox/jquery.fancybox.css" >

		<!-- FONTS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">
	</head>
	<body>
	<div id="fb-root"></div>
		<section class="container">
			<!-- TOP MENU -->
			<div class="header col-12">
				<div class="left-menu col-8">
					<ul>
						<li><a href="<?php echo base_url() ?>">Home</a></li>
						<li><a href="https://twitter.com/" target="_blank">Twitter</a></li>
						<?php
						if ($this->session->userdata('spgConnected')['group_id']=='1') {
						?>
							<li><a href="<?php echo base_url() ?>participation">Participation</a></li>
						<?php
						}
						?>
					</ul>
				</div>
				<div class="right-menu col-4">
					<ul>
						<li><a href=""><?php echo $this->session->userdata('spgConnected')['name'] ?></a></li>
						<li><a href="<?php echo base_url() ?>users/logout">Logout</a></li>
					</ul>
				</div>
			</div>

			<!-- WHEEL GAMES -->
			<div class="games-page gap">
				<div class="col-6 center game">
					<div id="wof"></div><!-- Game container -->
				</div>
				<div class="col-6 center acc-start">
					<img src="<?php echo base_url() ?>uploads/avatars/<?php echo $this->session->userdata('userConnected')['avatar']; ?>">
					<?php
						$firstname = "";
						$arrTemp = explode(" ", $this->session->userdata('userConnected')['name']);
						if (count($arrTemp) > 0) $firstname = $arrTemp[0];
					?>
					<h1>Hi <?php echo $firstname; ?>,</h1>
					<div class="start">
						<h2>Semoga Beruntung Ya!</h2>
						<button id="play" class="yellow rnd6">Putar!</button>
					</div>

					<div class="results hidden">
						<a href="#winning" id="winningTrigger" class="show-result">Win</a>
						<a href="#chance" id="chanceTrigger" class="show-result">Putar Lagi</a>
						<a href="#zonk" id="zonkTrigger" class="show-result">Kosong</a>
					</div>

				</div>
			</div>

			<!-- BOTTOM LOGO -->
			<div class="bottom-logo col-2">
				<a class="landscape" href=""><img src="<?php echo base_url() ?>assets/frontend/img/mm-logo.png"></a>
			</div>

		</section>

		<div id="winning" class="result-container hidden">
			<div class="result-image result-winning"></div>
			<h3>Selamat <?php echo $firstname; ?>,</h3>
			<p>Kamu mendapatkan <span id="prize"></span></p>
			<div class="action">
				<button id="retry" class="yellow">Putar Lagi</button>
				<form action="<?=base_url();?>games/submit" method="post">
					<input type="hidden" name="prize" id="rPrize" value="">
					<button type="submit" class="blue">Ambil Hadiah</button>
				</form>
			</div>
		</div>

		<div id="chance" class="result-container hidden">
			<div class="result-image chance-image"></div>
			<h3>Selamat <?php echo $firstname; ?>,</h3>
			<p>Kamu mempunyai kesempatan untuk mencoba lagi!</p>
			<div class="action">
				<button id="putar" class="yellow">Putar Lagi</button>
			</div>
		</div>

		<div id="zonk" class="result-container hidden">
			<div class="result-image zonk-image"></div>
			<h3>Maaf <?php echo $firstname; ?>,</h3>
			<p>Kamu belum beruntung</p>
			<div class="action">
				<a href="<?=base_url()?>" class="red">Home</a>
			</div>
		</div>

		<script type="text/javascript" src="<?php echo base_url() ?>assets/frontend/js/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/frontend/js/d3.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/frontend/js/fancybox/jquery.fancybox.pack.js"></script>
		<script>
			var padding = {top:20, right:40, bottom:0, left:0},
	            w = 500 - padding.left - padding.right,
	            h = 500 - padding.top  - padding.bottom,
	            r = Math.min(w, h)/2,
	            rotation = 0,
	            oldrotation = 0,
	            picked = 100000,
	            oldpick = [],
	            supergift = 10,
	            color = d3.scale.ordinal().range(["#1560ae", "#f6a02c", "#e6271e", "#40a73b"]);

	        var data = [
	            {"label":"Putar Lagi",  "value":0},
	            {"label":"Gift B",  	"value":3},
	            {"label":"Kosong",  	"value":0},
	            {"label":"Gift A",  	"value":2},
	            {"label":"Super Gift",  "value":1},
	            {"label":"Gift B",  	"value":3},
	            {"label":"Kosong",  	"value":0},
	            {"label":"Gift A",  	"value":2}
	        ];

	        var svg = d3.select('#wof')
	            .append("svg")
	            .data([data])
	            .attr("width",  w + padding.left + padding.right)
	            .attr("height", h + padding.top + padding.bottom);

	        var container = svg.append("g")
	            .attr("class", "chartholder")
	            .attr("transform", "translate(" + (w/2 + padding.left) + "," + (h/2 + padding.top) + ")");

	        var vis = container
	            .append("g");

	        var pie = d3.layout.pie().sort(null).value(function(d){return 1;});

	        // declare an arc generator function
	        var arc = d3.svg.arc().outerRadius(r);

	        // select paths, use arc generator to draw
	        var arcs = vis.selectAll("g.slice")
	            .data(pie)
	            .enter()
	            .append("g")
	            .attr("class", "slice");

	        arcs.append("path")
	            .attr("fill", function(d, i){ return color(i); })
	            .attr("d", function (d) { return arc(d); });

	        // add the text
	        arcs.append("text").attr("transform", function(d){
	                d.innerRadius = 0;
	                d.outerRadius = r;
	                d.angle = (d.startAngle + d.endAngle)/2;
	                return "rotate(" + (d.angle * 180 / Math.PI - 90) + ")translate(" + (d.outerRadius -40) +")";
	            })
	            .attr("text-anchor", "end")
	            .attr("fill", "#fff")
	            .text( function(d, i) {
	                return data[i].label;
	            });

	        container.on("click", spin);


	        function spin(d){

	            //all slices have been seen, all done
	            if(oldpick.length == data.length){
	                console.log("done");
	                container.on("click", null);
	                return;
	            }

	            var  ps       = 360/data.length,
	                 pieslice = Math.round(1440/data.length),
	                 rng      = Math.floor((Math.random() * 1440) + 360);

	            rotation = (Math.round(rng / ps) * ps);

	            picked = Math.round(data.length - (rotation % 360)/ps);
	            picked = picked >= data.length ? (picked % data.length) : picked;


	            if(oldpick.indexOf(picked) !== -1){
	                d3.select(this).call(spin);
	                return;
	            } else {
	                oldpick.push(picked);
	             }

	            rotation += 90 - Math.round(ps/2);

	            vis.transition()
	                .duration(3000)
	                .attrTween("transform", rotTween)
	                .each("end", function(){
	                    var rPrize = data[picked].label;
	                    $('#prize').html(rPrize);
	                    $('#rPrize').val(rPrize);

	                    if((rPrize === "Putar Lagi") || (rPrize === "")){
							$('.results a#chanceTrigger').click();
							canSpin = true;
						} else if (rPrize === "Kosong") {
							$('.results a#zonkTrigger').click();
							canSpin = false;
						} else {
							$('.result-winning').addClass(rPrize+"-image");
							$('.results a#winningTrigger').click();
							canSpin = true;
						};

	                    oldrotation = rotation;
	                });
	        }

	        //make arrow
	        svg.append("g")
	            .attr("transform", "translate(" + (w + padding.left + padding.right) + "," + ((h/2)+padding.top) + ")")
	            .append("path")
	            .attr("d", "M-" + (r*.15) + ",0L0," + (r*.05) + "L0,-" + (r*.05) + "Z")
	            .style({"fill":"#333"});

	        //draw spin circle
	        container.append("circle")
	            .attr("cx", 0)
	            .attr("cy", 0)
	            .attr("r", 60)
	            .style({"fill":"white","cursor":"pointer"});

	        //spin text
	        container.append("text")
	            .attr("x", 0)
	            .attr("y", 15)
	            .attr("text-anchor", "middle")
	            .text("SPIN")
	            .style({"font-weight":"bold", "font-size":"30px"});


	        function rotTween(to) {
	          var i = d3.interpolate(oldrotation % 360, rotation);
	          return function(t) {
	            return "rotate(" + i(t) + ")";
	          };
	        }


	        function getRandomNumbers(){
	            var array = new Uint16Array(1000);
	            var scale = d3.scale.linear().range([360, 1440]).domain([0, 100000]);

	            if(window.hasOwnProperty("crypto") && typeof window.crypto.getRandomValues === "function"){
	                window.crypto.getRandomValues(array);
	                console.log("works");
	            } else {
	                //no support for crypto, get crappy random numbers
	                for(var i=0; i < 1000; i++){
	                    array[i] = Math.floor(Math.random() * 100000) + 1;
	                }
	            }
	            return array;
	        }

	        // Document Ready
			$(function(){
				$('#play').on('click', function() {
					spin();
					$('.result-winning').removeClass("A-image B-image Super Gift-image");
				});

				$('#retry, #putar').on('click', function() {
					$.fancybox.close();
				});

				$('.show-result').fancybox({
					openEffect  : 'fade',
			        closeEffect : 'fade',
			        closeBtn    : true,
			        padding     : 0,
			        helpers 	: {
									overlay : {closeClick: true}
								  }
				});
			});
		</script>
	</body>
</html>
