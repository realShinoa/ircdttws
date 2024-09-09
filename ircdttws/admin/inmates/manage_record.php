<?php 
require_once('./../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * FROM `record_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<div class="container-fluid">
    <form action="" id="record-form">
        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
        <input type="hidden" name="inmate_id" value="<?= isset($inmate_id) ? $inmate_id : (isset($_GET['inmate_id']) ? $_GET['inmate_id'] : '') ?>">
        <div class="form-group">
            <label for="date" class="control-label">Date</label>
            <input type="date" class="form-control form-control-sm rounded-0" name="date" id="date" required="required" value="<?= isset($date) ? date("Y-m-d", strtotime($date)) : date('Y-m-d') ?>">
        </div>
        <div class="form-group">
            <label for="action_id" class="control-label">Action</label>
            <select class="form-control form-control-sm rounded-0" name="action_id" id="action_id" required="required">
                <option value="" <?= !isset($action_id) ? 'selected' : '' ?>></option>
                <?php 
                $actions = $conn->query("SELECT * FROM `action_list` where delete_flag = 0 and `status` = 1 order by `name` asc");
                while($row = $actions->fetch_assoc()):
                ?>
                <option value="<?= $row['id'] ?>" <?= isset($action_id) && $row['id'] == $action_id ? 'selected' : '' ?>><?= $row['name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="remarks" class="control-label">Remarks</label>
            <textarea id="remarks" name="remarks" rows="5" class="form-control form-control-sm rounded-0" required><?= isset($remarks) ? $remarks : '' ?></textarea>
        </div>
    </form>
</div>
<script>
    $(function(){
        $('#uni_modal').on('shown.bs.modal', function(){
            $('#action_id').select2({
                placeholder:"Please Select Action Here",
                width:'100%',
                dropdownParent:$('#uni_modal'),
                containerCssClass:'form-control form-control-sm rounded-0'
            })
        })
        $('#record-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_record",
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
                        location.reload()
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").scrollTop(0);
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})
    })
</script>