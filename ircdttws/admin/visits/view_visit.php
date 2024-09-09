<?php
require_once('./../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT v.*, i.code, concat(i.lastname,', ', i.firstname, coalesce(concat(' ', i.middlename), '')) as `inmate` from `visit_list` v inner join inmate_list i on v.inmate_id = i.id where v.id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }else{
		echo '<script>alert("visit ID is not valid."); location.replace("./?page=visits")</script>';
	}
}else{
	echo '<script>alert("visit ID is Required."); location.replace("./?page=visits")</script>';
}
?>
<style>
	#uni_modal .modal-footer{
		display:none;
	}
</style>
<div class="container-fluid">
	<dl>
		<dt class="text-muted">Inmate</dt>
		<dd class="pl-4"><?= isset($code) && isset($inmate) ? $code.' - '.$inmate : "" ?></dd>
		<dt class="text-muted">Visitor's Fullname</dt>
		<dd class="pl-4"><?= isset($fullname) ? $fullname : "" ?></dd>
		<dt class="text-muted">Relation</dt>
		<dd class="pl-4"><?= isset($relation) ? $relation : "" ?></dd>
		<dt class="text-muted">Contact #</dt>
		<dd class="pl-4"><?= isset($contact) ? $contact : "" ?></dd>
	</dl>
</div>
<hr class="mx-n3">
<div class="text-right pt-1">
	<button class="btn btn-sm btn-flat btn-light bg-gradient-light border" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
</div>