<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">قائمة الآيات اليومية</h3>
		<div class="card-tools">
			<a href="?page=daily_verse/manage_daily_verse" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> إضافة جديدة</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-bordered table-stripped">
				<colgroup>
					<col width="5%">
					<col width="25%">
					<col width="35%">
					<col width="25%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>تاريخ العرض</th>
						<th>الآية</th>
						<th>من</th>
						<th>الإجراءات</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT * from `daily_verses` order by unix_timestamp(`display_date`) desc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("d M Y",strtotime($row['display_date'])) ?></td>
							<td><p class="m-0 truncate"><?php echo $row['verse'] ?></p></td>
							<td><?php echo $row['verse_from'] ?></td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		الإجراءات
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item" href="?page=daily_verse/manage_daily_verse&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> تعديل</a>
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
			_conf("هل أنت متأكد من حذف هذه الآية اليومية بشكل دائم؟","delete_daily_verse",[$(this).attr('data-id')])
		})
		$('.table td,.table th').addClass("py-0 px-1")
		$('.table').dataTable();
	})
	function delete_daily_verse($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_daily_verse",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("حدث خطأ أثناء الحذف.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("حدث خطأ أثناء الحذف.",'error');
					end_loader();
				}
			}
		})
	}
</script>
