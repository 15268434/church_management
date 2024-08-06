<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">قائمة المدونات</h3>
		<div class="card-tools">
			<a href="?page=blogs/manage_blog" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  إنشاء جديد</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-stripped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="25%">
					<col width="10%">
					<col width="15%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>تاريخ الإنشاء</th>
						<th>العنوان</th>
						<th>الوصف</th>
						<th>المؤلف</th>
						<th>الحالة</th>
						<th>الإجراءات</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT b.*,concat(u.firstname,' ',u.lastname) as author from `blogs` b inner join `users` u on b.author_id = u.id order by unix_timestamp(b.date_created) desc ");
						while($row = $qry->fetch_assoc()):
							foreach($row as $k=> $v){
								$row[$k] = trim(stripslashes($v));
							}
                            $row['meta_description'] = strip_tags(stripslashes(html_entity_decode($row['meta_description'])));
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td><a href="<?php echo base_url.$row['blog_url'] ?>" target="_blank"><?php echo $row['title'] ?></a></td>
							<td ><p class="m-0 truncate-1"><?php echo $row['meta_description'] ?></p></td>
							<td ><p class="m-0"><?php echo $row['author'] ?></p></td>
							<td class="text-center">
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge badge-success">منشور</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">غير منشور</span>
                                <?php endif; ?>
                            </td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		إجراء
				                    <span class="sr-only">تبديل القائمة المنسدلة</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item" href="?page=blogs/manage_blog&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> تعديل</a>
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
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("هل أنت متأكد أنك تريد حذف هذه المدونة بشكل دائم؟","delete_blog",[$(this).attr('data-id')])
		})
		$('.table').dataTable();
	})
	function delete_blog($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_blog",
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
