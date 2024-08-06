<h1 class="text-light text-right">مرحباً بكم في <?php echo $_settings->info('name') ?></h1>
<hr class="border-light">
<div class="row text-right">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-light elevation-1"><i class="fas fa-quote-left"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">إجمالي الآيات اليومية</span>
        <span class="info-box-number text-right">
          <?php 
            $verses = $conn->query("SELECT count(id) as total FROM daily_verses ")->fetch_assoc()['total'];
            echo number_format($verses);
          ?>
        </span>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-calendar-check"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">المواعيد المؤكدة</span>
        <span class="info-box-number text-right">
          <?php 
            $appointment = $conn->query("SELECT count(id) as total FROM appointment_request ")->fetch_assoc()['total'];
            echo number_format($appointment);
          ?>
        </span>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-blog"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">المدونات/المشاركات المنشورة</span>
        <span class="info-box-number text-right">
          <?php 
            $blogs = $conn->query("SELECT id FROM `blogs` where status = '1' ")->num_rows;
            echo number_format($blogs);
          ?>
        </span>
      </div>
    </div>
  </div>

  <div class="clearfix hidden-md-up"></div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-calendar-day"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">الأحداث القادمة</span>
        <span class="info-box-number text-right">
          <?php 
            $event = $conn->query("SELECT id FROM `events` where date(schedule) >= '".date('Y-m-d')."' ")->num_rows;
            echo number_format($event);
          ?>
        </span>
      </div>
    </div>
  </div>
</div>
