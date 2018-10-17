<?php require_once('../../private/initialize.php'); ?>
<?php 
if(isset($_GET['psy'])) {
	$get_id = $_GET['psy'];
	$property = Property::find_by_id($get_id);
	if($property == false || !Property::is_my_property($get_id)) {
		redirect_to('index.php');
	}
	$property->amenities = explode(', ', $property->amenities);
	$property->sale_rent = explode(', ', $property->sale_rent);

	if(is_post_request()) {
		$args = [];
		$args['address'] = $_POST['address'] ?? NULL;
		$args['state'] = $_POST['state'] ?? NULL;
		$args['area'] = $_POST['area'] ?? NULL;
		$args['bed'] = $_POST['bed'] ?? NULL;
		$args['bath'] = $_POST['bath'] ?? NULL;


		if(isset($_POST['amenities'])) {
			if(!empty($_POST['amenities'])) {
				$args['amenities'] = implode(', ', $_POST['amenities']);
			} else {
				$args['amenities'] = $_POST['amenities'];
			}
		} else {
			$args['amenities'] = [];
		}

		if(isset($_POST['sale_rent'])) {
			if(!empty($_POST['sale_rent'])) {  
				$args['sale_rent'] = implode(', ', $_POST['sale_rent']);
			} else {
				$args['sale_rent'] = $_POST['sale_rent'];
			}
		} else {
			$args['sale_rent'] = [];
		}


		$args['description'] = $_POST['description'] ?? NULL;
		$args['no_years'] = $_POST['no_years'] ?? NULL;
		$args['price'] = $_POST['price'] ?? NULL;
		$args['files'] = $_FILES['files'] ?? NULL;


		$property->merge_attrib($args);
		$result = $property->update();


		if(isset($_POST['amenities']) && !empty($_POST['amenities'])) {   
			$property->amenities = explode(', ', $property->amenities);
		}
		if(isset($_POST['sale_rent']) && !empty($_POST['sale_rent'])) {
			$property->sale_rent = explode(', ', $property->sale_rent);
		}


		if($result === true) {
			$session->message('Property Edited Successfully');
			redirect_to('my_listings.php');
		} else {
			//show errors
		}
	}
}else {
	redirect_to('index.php');
}

$page_title = "Reesa.com - Edit Property";
$custom_css_library = '
';

?>
<?php include("includes/header.php"); ?>
<!-- End header header -->

        <!-- Left Sidebar  -->
        <?php include("includes/sidebar.php"); ?>
        <!-- End Left Sidebar  -->

        <!-- Page wrapper  -->

        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                	
                    <h3 class="text-primary"><a class="m-r-10 bckEdtImgs" href="my_listings.php"><i class="fa fa-reply"></i><a>Edit Property</h3> 
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="my_listings.php">My Listings</a></li>
                        <li class="breadcrumb-item active">Edit Property</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->

            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <?php echo display_errors($property->errors); ?>
                
            	<form action="" method="post" enctype="multipart/form-data">
	                <div class="row bg-white m-l-0 m-r-0 box-shadow pb-5">
		                    <div class="col-lg-6">
		                        <div class="card">
		                            <div class="card-body">
			                            <div class="basic-form">

			                            	<div class="upPrAdWrp">
				                            	<div class="form-group upPrAdrs upPrice">
													<input class="form-control input-default" type="text" value="<?php echo escape($property->address); ?>" name="address" required placeholder="Address">
				                            	</div>
												<select name="state" required class="upPrSlct">
													<option value="">Select State</option>
													<option value="anambra">Anam'sbra</option>
													<option value="oka_spelt_wrong">oka_spelt_wrong</option>
													<option value="lagos" <?php echo ($property->state == 'lagos') ? 'selected':''; ?> >lagos</option>
												</select>
											</div>

			                            	<div class="row mb-4">
				                            	<div class="col-md-4">
				                            		<select required class="form-control input-default" name="bath">
				                            			<option value="">Baths</option>
														<?php 
															for ($i=1; $i<5 ; $i++) { 
																echo "<option value=\"{$i}\" ";?>
																<?php if($property->bath == $i) {echo " selected";} ?>
																<?php echo ">{$i}</option>";
															}
														?>				                            			
				                            		</select>
				                            	</div>
				                            	<div class="col-md-4">
													<select required class="form-control input-default" name="bed">
														<option value="">Beds</option>
														<?php 
															for ($i=1; $i<5 ; $i++) { 
																echo "<option value=\"{$i}\" ";?>
																<?php if($property->bed == $i) {echo " selected";} ?>
																<?php echo ">{$i}</option>";
															}
														?>								
													</select>
				                            	</div>
				                            	<div class="col-md-4">
													<input class="form-control input-default" type="text"  value="<?php echo escape($property->area); ?>" name="area" required placeholder="Area">
				                            	</div>
			                            	</div>

											<div class="row">
			                            		<div class="col-md-6 basic-group">
			                            			<div class="form-group">
			                            				<input type="checkbox" value="electricity" id="elec" name="amenities[]" <?php echo (in_array("electricity", $property->amenities)) ? 'checked' : ''; ?> >
			                            				<label for="elec">Electricity</label>
			                            			</div>
			                            			<div class="form-group">
			                            				<input type="checkbox" value="water" id="water" name="amenities[]"<?php echo (in_array("water", $property->amenities)) ? 'checked' : ''; ?> > 
			                            				<label for="water">Running Water</label>
			                            			</div>
			                            			<div class="form-group">
			                            				<input type="checkbox" value="furnished" id="furnished" name="amenities[]"<?php echo (in_array("furnished", $property->amenities)) ? 'checked' : ''; ?> > 
			                            				<label for="furnished">Furnished</label>
			                            			</div>
			                            		</div>
			                            		<div class="col-md-6 basic-group">
			                            			<div class="form-group">
			                            				<input type="checkbox" value="garage" id="garage" name="amenities[]"<?php echo (in_array("garage", $property->amenities)) ? 'checked' : ''; ?> > 
			                            				<label for="garage">Garage</label>
			                            			</div>
			                            			<div class="form-group">
			                            				<input type="checkbox" value="balcony" id="deck" name="amenities[]"<?php echo (in_array("balcony", $property->amenities)) ? 'checked' : ''; ?> > 
			                            				<label for="deck">Balcony/Deck</label>
			                            			</div>
			                            		</div>
			                            	</div>


		                                    <div class="form-group">
		                                        <textarea class="textarea_editor form-control" rows="15" placeholder="Description" required name="description" style="height:220px"><?php echo escape($property->description); ?></textarea>
		                                    </div>
										</div>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-lg-6">
		                    	<div class="card">
		                    		<div class="card-body">
		                    			<div class="basic-form">
	                    					<div class="row">
	                    						<div class="col-md-8">
													<input id="uPrTxtbx" class="form-control input-default"" name="price" value="<?php echo escape($property->price); ?>" type="text" required placeholder="Price">
												</div>
												<div class="col-md-4">
													<select id="upPYSlct" class="form-control input-default" required name="no_years">
														<option value="">No. of years</option>
														<?php 
															for ($i=1; $i<5 ; $i++) { 
																echo "<option value=\"{$i}\" ";?>
																<?php if($property->no_years == $i) {echo " selected";} ?>
																<?php echo ">{$i}</option>";
															}
														?>			
													</select>
												</div>

												<div class="row m-t-27">
				                            		<div class="col-md-6 basic-group">

								                        <?php
								                        //echo $property->no_years;
								                        $monthly_price = '';
								                        if($property->no_years > 0) {
								                        	if($property->price != '') {
								                            	$monthly_price = $property->price / ($property->no_years * 12) ;
								                        	}
								                        }else {
								                            $monthly_price = 0;
								                        }
								                        ?>

				                            			N<span id="upPaMntClc"><?php echo round($monthly_price, 3); ?></span> per month
				                            		</div>
				                            		<div class="col-md-6 basic-group m-t-1">
				                            			<div class="form-group">
				                            				<div class="row">
					                            				<div class="col-md-6">
					                            					<input type="radio" value="sale" id="sale" name="sale_rent[]" <?php echo (in_array("sale", $property->sale_rent)) ? 'checked' : ''; ?> > 
					                            					<label for="sale">Sale</label>	
					                            				</div>
					                            				<div class="col-md-6">
					                            					<input type="radio" value="rent" id="rent" name="sale_rent[]" <?php echo (in_array("rent", $property->sale_rent)) ? 'checked' : ''; ?> >	
					                            					<label for="rent">Rent</label>	
					                            				</div>
				                            				</div>
				                            			</div>
				                            			<div class="form-group">
				                            				
				                            			</div>
				                            		</div>
												</div>

												<div class="form-group mt-4">
													

												</div>
											</div>
											<div class="row" style="text-align: center;">
												
													<div class="col-md-12 m-t-50">
														<a href="edit_property_images.php?psy=<?php echo $property->id;?>&eup=rsano3/listing/gs_l=16d" class="btn btn-dark btn-outline btn-rounded">Edit Images</a>
													</div>
													
											</div>
										</div>
		                    		</div>
		                    	</div>
							</div>
							<div class="col-lg-12">
								<div class="row">
									<div class="col-md-6 text-center">
										<button type="submit" name="new_prop" class="btn btn-primary btn-md m-b-10 m-l-5">Edit</button>
									</div>
								</div>
							</div>
	                </div>
				</form>

            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <?php include("includes/dashboard_footer.php"); ?>
            <!-- End footer -->            
        </div>

        <!-- End Page wrapper  -->


<?php include("includes/footer.php"); ?>