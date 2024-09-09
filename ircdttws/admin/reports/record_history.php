<?php 
$month = isset($_GET['month']) ? $_GET['month'] : date("Y-m");
?>
<div class="content py-5 px-3 bg-gradient-navy">
    <h2>Monthly Inmate Record Reports</h2>
</div>
<div class="row flex-column mt-4 justify-content-center align-items-center mt-lg-n4 mt-md-3 mt-sm-0">
    <div class="col-lg-11 col-md-11 col-sm-12 col-xs-12">
        <div class="card rounded-0 mb-2 shadow">
            <div class="card-body">
                <fieldset>
                    <legend>Filter</legend>
                    <form action="" id="filter-form">
                        <div class="row align-items-end">
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="month" class="control-label">Choose Month</label>
                                    <input type="month" class="form-control form-control-sm rounded-0" name="month" id="month" value="<?= $month ?>" required="required">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <button class="btn btn-sm btn-flat btn-primary bg-gradient-primary"><i class="fa fa-filter"></i> Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="col-lg-11 col-md-11 col-sm-12 col-xs-12">
        <div class="card rounded-0 mb-2 shadow">
            <div class="card-header py-1">
                <div class="card-tools">
                    <button class="btn btn-flat btn-sm btn-light bg-gradient-light border text-dark" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
            <div class="card-body">
                <div class="container-fluid" id="printout">
                    <table class="table table-bordered">
                        <colgroup>
                            <col width="10%">
                            <col width="15%">
                            <col width="20%">
                            <col width="20%">
                            <col width="35%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="px-1 py-1 text-center">#</th>
                                <th class="px-1 py-1 text-center">Date</th>
                                <th class="px-1 py-1 text-center">Inmate</th>
                                <th class="px-1 py-1 text-center">Action</th>
                                <th class="px-1 py-1 text-center">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            $records = $conn->query("SELECT r.*, a.name as `action`, i.code, concat(i.lastname,', ', i.firstname, coalesce(concat(' ', i.middlename), '')) as `inmate` FROM `record_list` r inner join inmate_list i on r.inmate_id = i.id inner join action_list a on r.action_id = a.id where date_format(r.`date`, '%Y-%m') = '{$month}' order by date(r.date) asc, abs(unix_timestamp(r.date_created)) asc");
                            while($row = $records->fetch_assoc()):
                               
                            ?>
                            <tr>
                                <td class="px-1 py-1 align-middle text-center"><?= $i++ ?></td>
                                <td class="px-1 py-1 align-middle"><?= date("M d, Y", strtotime($row['date'])) ?></td>
                                <td class="px-1 py-1 align-middle">
                                    <div style="line-height:1em">
                                        <div><b><?= $row['inmate'] ?></b></div>
                                        <div>Inmate - <?= $row['code'] ?></div>
                                    </div>
                                </td>
                                <td class="px-1 py-1 align-middle"><?= $row['action'] ?></td>
                                <td class="px-1 py-1 align-middle"><?= $row['remarks'] ?></td>
                            </tr>
                            <?php endwhile; ?>
                            <?php if($records->num_rows <= 0): ?>
                                <tr>
                                    <td class="py-1 text-center" colspan="5">No records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<noscript id="print-header">
    <div>
        <style>
            html{
                min-height:unset !important;
            }
        </style>
        <div class="d-flex w-100 align-items-center">
            <div class="col-2 text-center">
                <img src="<?= validate_image($_settings->info('logo')) ?>" alt="" class="rounded-circle border" style="width: 5em;height: 5em;object-fit:cover;object-position:center center">
            </div>
            <div class="col-8">
                <div style="line-height:1em">
                    <div class="text-center font-weight-bold h5 mb-0"><large><?= $_settings->info('name') ?></large></div>
                    <div class="text-center font-weight-bold h5 mb-0"><large>Monthly Inmate Record Report</large></div>
                    <div class="text-center font-weight-bold h5 mb-0">as of <?= date("F Y", strtotime($month.'-01')) ?></div>
                </div>
            </div>
        </div>
        <hr>
    </div>
</noscript>
<script>
    function print_r(){
        var h = $('head').clone()
        var el = $('#printout').clone()
        var ph = $($('noscript#print-header').html()).clone()
        h.find('title').text("Monthly Inmate Record Report - Print View")
        var nw = window.open("", "_blank", "width="+($(window).width() * .8)+",left="+($(window).width() * .1)+",height="+($(window).height() * .8)+",top="+($(window).height() * .1))
            nw.document.querySelector('head').innerHTML = h.html()
            nw.document.querySelector('body').innerHTML = ph[0].outerHTML
            nw.document.querySelector('body').innerHTML += el[0].outerHTML
            nw.document.close()
            start_loader()
            setTimeout(() => {
                nw.print()
                setTimeout(() => {
                    nw.close()
                    end_loader()
                }, 200);
            }, 300);
    }
    $(function(){
        $('#filter-form').submit(function(e){
            e.preventDefault()
            location.href = './?page=reports/record_history&'+$(this).serialize()
        })
        $('#print').click(function(){
            print_r()
        })

    })
</script>