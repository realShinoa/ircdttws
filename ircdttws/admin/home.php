<style>
  #system-cover{
    width:100%;
    height:35em;
    object-fit:cover;
    object-position:center center;
  }
</style>
<h1 class="">Welcome, <?php echo $_settings->userdata('firstname')." ".$_settings->userdata('lastname') ?>!</h1>
<hr>
<div class="row">
  <div class="col-12 col-sm-3 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-light elevation-1"><i class="fas fa-th-list"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Prison List</span>
        <span class="info-box-number text-right h5">
          <?php 
            $prison = $conn->query("SELECT * FROM prison_list where delete_flag = 0 and `status` = 1")->num_rows;
            echo format_num($prison);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-3 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-navy elevation-1"><i class="fas fa-border-all"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Cell Block</span>
        <span class="info-box-number text-right h5">
          <?php 
            $cells = $conn->query("SELECT id FROM cell_list where delete_flag = 0 and `status` = 1")->num_rows;
            echo format_num($cells);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-3 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-dark elevation-1"><i class="fas fa-list"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Crimes</span>
        <span class="info-box-number text-right h5">
          <?php 
            $crimes = $conn->query("SELECT id FROM crime_list where  `status` =1 and delete_flag = 0")->num_rows;
            echo format_num($crimes);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  
  <div class="col-12 col-sm-3 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-navy elevation-1"><i class="fas fa-bars"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Actions</span>
        <span class="info-box-number text-right h5">
          <?php 
            $actions = $conn->query("SELECT id FROM action_list where `status` =1 and delete_flag = 0")->num_rows;
            echo format_num($actions);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-3 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-user"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Currrent Inmates</span>
        <span class="info-box-number text-right h5">
          <?php 
            $inmates = $conn->query("SELECT id FROM inmate_list where `status` =1  and (date(date_to) > '".date('Y-m-d')."' or date_to is NULL )")->num_rows;
            echo format_num($inmates);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-3 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-user"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Released Inmates</span>
        <span class="info-box-number text-right h5">
          <?php 
            $inmates = $conn->query("SELECT id FROM inmate_list where date(date_to) <= '".date('Y-m-d')."'")->num_rows;
            echo format_num($inmates);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  
  <div class="col-12 col-sm-3 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-warning elevation-1"><i class="fas fa-file-alt"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Today's Visits</span>
        <span class="info-box-number text-right h5">
          <?php 
            $visits = $conn->query("SELECT id FROM visit_list where date(date_created) = '".date('Y-m-d')."'")->num_rows;
            echo format_num($visits);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>
<div class="container-fluid text-center">
  <img src="<?= validate_image($_settings->info('cover')) ?>" alt="system-cover" id="system-cover" class="img-fluid">
</div>
