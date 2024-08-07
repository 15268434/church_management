<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">قائمة المواضيع</h3>
		<div class="card-tools">
			<a href="?page=maintenance/manage_topic" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  إنشاء جديد</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-bordered table-stripped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="35%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>تاريخ الإنشاء</th>
						<th>الاسم</th>
						<th>الوصف</th>
						<th>الحالة</th>
						<th>العمليات</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT * from `topics` order by unix_timestamp(date_created) desc ");
						while($row = $qry->fetch_assoc()):
                            $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td><?php echo $row['name'] ?></td>
							<td ><p class="truncate-1 m-0"><?php echo $row['description'] ?></p></td>
							<td class="text-center">
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge badge-success">نشط</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">غير نشط</span>
                                <?php endif; ?>
                            </td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		العمليات
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item" href="?page=maintenance/manage_topic&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> تعديل</a>
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
			_conf("هل أنت متأكد من حذف هذا الموضوع بشكل دائم؟","delete_topic",[$(this).attr('data-id')])
		})
		$('.table').dataTable();
	})
	function delete_topic($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_topic",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:function(err){
				console.log(err);
				alert_toast("حدث خطأ ما.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp == 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("حدث خطأ ما.",'error');
					end_loader();
				}
			}
		})
	}
</script>
