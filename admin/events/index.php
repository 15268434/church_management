<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">قائمة الأحداث</h3>
		<div class="card-tools">
			<a href="?page=events/manage_event" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  إنشاء جديد</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-bordered table-stripped">
				<colgroup>
					<col width="5%">
					<col width="35%">
					<col width="25%">
					<col width="25%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>الجدول الزمني</th>
						<th>العنوان</th>
						<th>الوصف</th>
						<th>الإجراء</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT * from `events` order by unix_timestamp(schedule) desc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("M d,Y",strtotime($row['schedule'])) ?></td>
							<td><?php echo $row['title'] ?></td>
							<td><p class="m-0 truncate"><?php echo $row['description'] ?></p></td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		الإجراء
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item" href="?page=events/manage_event&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> تعديل</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> حذف</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("هل أنت متأكد من رغبتك في حذف هذا الحدث بشكل دائم؟","delete_event",[$(this).attr('data-id')])
		})
		$('.table').dataTable();
	})
	function delete_event($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_event",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("حدث خطأ.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("حدث خطأ.",'error');
					end_loader();
				}
			}
		})
	}
</script>
