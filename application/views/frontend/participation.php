<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Participation</title>
		<meta name="author" content="">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- FAVICON -->
		<link rel="icon" href="apple-touch-icon.png">

		<!-- STYLESHEETS -->
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/grid.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/main.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/style.css" >
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/style.css" >
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/js/jqueryui/jquery-ui.min.css" >
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/js/jqueryui/jquery-ui.theme.min.css" >
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/js/jqueryui/jquery-ui.structure.min.css" >

		<!-- FONTS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">
	</head>
	<body class="participant-page">
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
						<li><a href=""><?php echo $this->session->userdata('spgConnected')['name']; ?></a></li>
						<li><a href="<?php echo base_url() ?>users/logout">Logout</a></li>
					</ul>
				</div>
			</div>

			<!-- PARTICIPATION -->
			<div class="participation">
				<div class="participant-status col-12 gap">
					<div class="col-4">
						<span class="jumlah"><h4><?php echo $jmlPeserta ?></h4></span>
						<span class="status-desc">Total Peserta</span>
					</div>
					<div class="col-4">
						<span class="jumlah"><h4><?php echo $jmlMenang; ?></h4></span>
						<span class="status-desc">Total Menang</span>
					</div>
					<div class="col-4">
						<span class="jumlah"><h4><?php echo $jmlKalah; ?></h4></span>
						<span class="status-desc">Total Kalah</span>
					</div>
				</div>

				<div class="participant-search gap">
					<form method="post" name="fsearchparticipant" id="fsearchparticipant" data-url="<?php echo base_url() ?>participation/indexMirror">
						<input type="search" name="searchVal" placeholder="Cari nama, nomor telepon, email, status dan hadiah">
						<label for="searchby">Search By
							<?php echo form_dropdown('searchBy', $searchBy, "", "id='searchby'"); ?>
						</label>
						<label for="periode">Periode
							<input type="text" name="from" id="datepickerFrom">
						</label>
						<label for="hingga">s/d
							<input type="text" name="to" id="datepickerTo">
						</label>
						<button class="btn rnd6 searchbtn yellow" onclick="searchParticipant()">Submit</button>
						<a href="<?php echo base_url() ?>Participation/eksport" class="btn rnd6 searchbtn green">EXPORT DATA</a>
					</form>
				</div>

				<div class="participant-table col-12">
					<div id="divAjax">
						<table>
							<thead>
								<tr>
									<th width="16%">Tanggal &amp; Jam</th>
									<th width="14%">Mall &amp; Kota</th>
									<th width="14%">Nama</th>
									<th width="14%">No. Telepon</th>
									<th width="14%">Email</th>
									<th width="14%">Provider</th>
									<th width="14%">Hadiah</th>
								</tr>
							</thead>
							<tbody>
								<?php
	                            if (count($dataParticipant['myCode']) > 0) {
	                                foreach ($dataParticipant['myCode'] as $val) {
	                            ?>
	                                    <tr>
	                                        <td><?php echo $val['datetime'] ?></td>
	                                        <td><?php echo $val['mall'] ?></td>
	                                        <td><?php echo $val['name'] ?></td>
	                                        <td><?php echo $val['phone'] ?></td>
	                                        <td><?php echo $val['email'] ?></td>
	                                        <td>
	                                        	<?php
	                                        		echo $val['provider'];
	                                        		/*if ($val['status']=='1') {
	                                        			echo 'Menang';
	                                        		} else {
	                                        			echo 'Kalah';
	                                        		}*/
	                                        	?>
	                                        </td>
	                                        <td><?php echo $val['prize'] ?></td>
	                                    </tr>
	                            <?php
	                                }
	                            } else {
	                            ?>
	                                <tr>
										<td colspan="7">Data Kosong</td>
									</tr>
	                            <?php
	                            }
	                            ?>
							</tbody>
						</table>

						<div class="pagination">
							<?php echo $dataParticipant['page_links']; ?>
						</div>
					</div>
				</div>
			</div>

			<!-- BOTTOM LOGO -->
			<div class="bottom-logo col-2">
				<a class="landscape" href=""><img src="<?php echo base_url() ?>assets/frontend/img/mm-logo.png"></a>
			</div>

		</section>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/frontend/js/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/frontend/js/jqueryui/jquery-ui.min.js"></script>
		<script type="text/javascript">

		    $(document).ready(function(){
		    	$("#datepickerFrom").datepicker({
		    		defaultDate: "+1w",
		    		dateFormat: "yy-mm-dd",
					changeMonth: true,
					numberOfMonths: 3,
					onClose: function( selectedDate ) {
						$( "#datepickerTo" ).datepicker( "option", "minDate", selectedDate );
					}
		    	});

		    	$("#datepickerTo").datepicker({
		    		defaultDate: "+1w",
		    		dateFormat: "yy-mm-dd",
					changeMonth: true,
					numberOfMonths: 3,
					onClose: function( selectedDate ) {
						$( "#datepickerFrom" ).datepicker( "option", "maxDate", selectedDate );
					}
		    	});

		    	// Paging
		        function bindClicks() {
		            $("ul.tsc_pagination a").click(paginationClick);
		        }

		        function paginationClick() {
		            var href = $(this).attr('href');
		            var arrPath = href.split("/");

		            $("#rounded-corner").css("opacity","0.4");
		            $.ajax({
		                type: "GET",
		                url: href,
		                data: {},
		                success: function(response)
		                    {
		                    /*alert(response);*/
		                    $("#rounded-corner").css("opacity","1");
		                    $("#divAjax").html(response);

		                    bindClicks();
		                    }
		            });
		            return false;
		        }

		        bindClicks();
		    });

		    function searchParticipant()
			{
			    var link = $("#fsearchparticipant").data("url");
			    var postData = $("#fsearchparticipant").serializeArray();
			     // alert(link);return false;
			    $.ajax(
			    {
			        url: link,
			        type: "POST",
			        data: postData,
			        success: function(data, textStatus, jqXHR)
			        {
			            /*alert(data);*/
			            $("#rounded-corner").css("opacity","1");
			            $("#divAjax").html(response);
			        },
			        error: function(jqXHR, textStatus, errorThrown)
			        {
			            $("#tableRelation").html('<pre><code class="prettyprint">AJAX Request Failed<br/> textStatus='+textStatus+', errorThrown='+errorThrown+'</code></pre>');
			        }
			    });
			}
		</script>
	</body>
</html>
