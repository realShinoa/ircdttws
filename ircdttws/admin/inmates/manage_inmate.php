<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `inmate_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
    if(isset($id)){
        $crimes = $conn->query("SELECT crime_id from `inmate_crimes` where inmate_id = '{$id}' ");
       $crime_ids = array_column($crimes->fetch_all(MYSQLI_ASSOC),'crime_id');
    }
}
?>
<style>
    img#cimg{
		max-height: 15em;
		max-width: 100%;
		object-fit: scale-down;
	}
</style>
<div class="content py-4 bg-gradient-navy px-3">
    <h4 class="mb-0"><?= isset($id) ? "Update Inmate" : "New Inmate Entry" ?></h4>
</div>
<div class="row mt-n4 justify-content-center align-items-center flex-column">
    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
        <div class="card rounded-0 shadow">
            <div class="card-body">
                <div class="container-fluid">
                    <form action="" id="inmate-form">
                        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="code" class="control-label">Code</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="code" id="code" required="required" value="<?= isset($code) ? $code : "" ?>">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="cell_id" class="control-label">Prison & Cell Block</label>
                                        <select class="form-control form-control-sm rounded-0" name="cell_id" id="cell_id" required="required">
                                            <option value="" <?= !isset($cell_id) ? 'selected' : '' ?>></option>
                                            <?php 
                                            $cells = $conn->query("SELECT c.*, p.name as `prison` FROM `cell_list` c inner join prison_list p on c.prison_id = p.id where c.delete_flag = 0 and c.`status` = 1 order by c.`name` asc ");
                                            while($row = $cells->fetch_assoc()):
                                            ?>
                                            <option value="<?= $row['id'] ?>" <?= isset($cell_id) && $cell_id == $row['id'] ? 'selected' : '' ?>><?= $row['prison'] . " - " . $row['name'] ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="firstname" class="control-label">First Name</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="firstname" id="firstname" required="required" value="<?= isset($firstname) ? $firstname : "" ?>">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="middlename" class="control-label">Middle Name</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="middlename" id="middlename" placeholder="optional" value="<?= isset($middlename) ? $middlename : "" ?>">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="lastname" class="control-label">Last Name</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="lastname" id="lastname" required="required" value="<?= isset($lastname) ? $lastname : "" ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="dob" class="control-label">Birthday</label>
                                    <input type="date" class="form-control form-control-sm rounded-0" name="dob" id="dob" required="required" value="<?= isset($dob) ? $dob : "" ?>">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="sex" class="control-label">Sex</label>
                                    <select class="form-control form-control-sm rounded-0" name="sex" id="sex" required="required">
                                    <option value="Male" <?= isset($sex) && $sex == 'Male' ? 'selected' : '' ?>>Male</option>
                                    <option value="Female" <?= isset($sex) && $sex == 'Female' ? 'selected' : '' ?>>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="address" class="control-label">Address</label>
                                    <textarea rows="3" class="form-control form-control-sm rounded-0" name="address" id="address" required="required"><?= isset($address) ? $address : "" ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="marital_status" class="control-label">Marital Status</label>
                                    <select class="form-control form-control-sm rounded-0" name="marital_status" id="marital_status" required="required">
                                    <option value="Single" <?= isset($marital_status) && $marital_status == 'Single' ? 'selected' : '' ?>>Single</option>
                                    <option value="Married" <?= isset($marital_status) && $marital_status == 'Married' ? 'selected' : '' ?>>Married</option>
                                    <option value="Widower" <?= isset($marital_status) && $marital_status == 'Widower' ? 'selected' : '' ?>>Widower</option>
                                    <option value="Widow" <?= isset($marital_status) && $marital_status == 'Widow' ? 'selected' : '' ?>>Widow</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="complexion" class="control-label">Complexion</label>
                                    <input type="complexion" class="form-control form-control-sm rounded-0" name="complexion" id="complexion" required="required" value="<?= isset($complexion) ? $complexion : "" ?>">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="eye_color" class="control-label">Eye Color</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="eye_color" id="eye_color" required value="<?= isset($eye_color) ? $eye_color : "" ?>">
                                </div>
                            </div>
                        </div>
                        <fieldset class="border px-2 py-2">
                            <legend class="w-auto mx-3" >Case Details</legend>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="crime_ids" class="control-label">Crime Committed</label>
                                        <select class="form-control form-control-sm rounded-0" name="crime_ids[]" id="crime_ids" required="required" multiple>
                                            <?php 
                                            $crimes = $conn->query("SELECT * FROM `crime_list` where delete_flag = 0 and `status` = 1 order by `name` asc ");
                                            while($row = $crimes->fetch_assoc()):
                                            ?>
                                            <option value="<?= $row['id'] ?>" <?= isset($crime_ids) && is_array($crime_ids) && in_array($row['id'], $crime_ids) ? 'selected' : '' ?>><?= $row['name'] ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="sentence" class="control-label">Sentence</label>
                                        <input type="sentence" class="form-control form-control-sm rounded-0" name="sentence" id="sentence" required="required" value="<?= isset($sentence) ? $sentence : "" ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="date_from" class="control-label">Time Serve Start</label>
                                        <input type="date" class="form-control form-control-sm rounded-0" name="date_from" id="date_from" required="required" value="<?= isset($date_from) ? date("Y-m-d", strtotime($date_from)) : "" ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="date_to" class="control-label">Time Serve Ends</label>
                                        <input type="date" class="form-control form-control-sm rounded-0" name="date_to" id="date_to" value="<?= isset($date_to) ? date("Y-m-d", strtotime($date_to)) : "" ?>">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border px-2 py-2">
                            <legend class="w-auto mx-3" >Emergency Contact Detials</legend>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="emergency_name" class="control-label">Name</label>
                                        <input type="emergency_name" class="form-control form-control-sm rounded-0" name="emergency_name" id="emergency_name" value="<?= isset($emergency_name) ? $emergency_name : "" ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="emergency_relation" class="control-label">Relation</label>
                                        <input type="text" class="form-control form-control-sm rounded-0" name="emergency_relation" id="emergency_relation" value="<?= isset($emergency_relation) ? $emergency_relation : "" ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="emergency_contact" class="control-label">Contact #</label>
                                        <input type="text" class="form-control form-control-sm rounded-0" name="emergency_contact" id="emergency_contact" value="<?= isset($emergency_contact) ? $emergency_contact : "" ?>">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border px-2 py-2">
                            <legend class="w-auto mx-3" >Image</legend>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="" class="control-label">Inamate Image</label>
                                        <div class="custom-file custom-file-sm rounded-0">
                                            <input type="file" class="custom-file-input rounded-0" id="customFile1" name="img" onchange="displayImg(this)">
                                            <label class="custom-file-label rounded-0" for="customFile1">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <img src="<?php echo validate_image(isset($image_path) ? $image_path : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="card-footer py-1 text-center">
                <button class="btn btn-flat btn-sm btn-navy bg-gradient-navy" form="inmate-form"><i class="fa fa-save"></i> Save</button>
                <?php if(!isset($id)): ?>
                <a class="btn btn-flat btn-sm btn-light bg-gradient-light border" href="./?page=inmates"><i class="fa fa-angle-left"></i> Cancel</a>
                <?php else: ?>
                <a class="btn btn-flat btn-sm btn-light bg-gradient-light border" href="./?page=inmates/view_inmate&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-angle-left"></i> Cancel</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        	$(input).siblings('.custom-file-label').html(input.files[0].name)
	        }
	        reader.readAsDataURL(input.files[0]);
	    }else{
            $('#cimg').attr('src', "<?php echo validate_image(isset($image_path) ? $image_path : '') ?>");
            $(input).siblings('.custom-file-label').html('Choose file')
        }
	}
	$(document).ready(function(){
        $('#crime_ids').select2({
            placeholder:"Please select inmate crimes here",
            width:'100%',
            containerCssClass:'rounded-0 rounded-0 pb-2'
        })
        $('#cell_id').select2({
            placeholder:"Please select inmate cell block here",
            width:'100%',
            containerCssClass:'form-control form-control-sm rounded-0'
        })
		$('#inmate-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
            var el = $('<div>')
            el.addClass('alert alert-danger rounded-0 err-msg')
            el.hide()
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_inmate",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.replace("./?page=inmates/view_inmate&id="+resp.iid)
					}else if(resp.status == 'failed' && !!resp.msg){
                            el.text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").scrollTop(0);
                    }else{
						alert_toast("An error occured",'error');
					}
                    end_loader()
				}
			})
		})

	})
</script>