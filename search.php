<style>
    .img-banner-list{
        width:25%;
        height:18vh;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<!-- العنوان-->
<header class="bg-dark py-5" id="main-header">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">نتائج البحث</h1>
            <p class="lead fw-normal text-white-50 mb-0"></p>
        </div>
    </div>
</header>
<!-- القسم-->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="list-group">
                <?php 
                $page= isset($_GET['page'])? $_GET['page']: 0;
                $limit = 10; 
                $offset = $page > 0 ? ($page * $limit) : $page;
                $count_all = $conn->query("SELECT b.*,concat(u.firstname,' ',u.lastname) as author FROM `blogs` b inner join `users` u on b.author_id = u.id where b.`status` =1 and (b.`title` LIKE '%{$_GET['search']}%' OR b.`meta_description` LIKE '%{$_GET['search']}%' OR b.`keywords` LIKE '%{$_GET['search']}%' OR b.`content` LIKE '%{$_GET['search']}%' )")->num_rows;
                $blogs = $conn->query("SELECT b.*,concat(u.firstname,' ',u.lastname) as author FROM `blogs` b inner join `users` u on b.author_id = u.id where b.`status` =1 and (b.`title` LIKE '%{$_GET['search']}%' OR b.`meta_description` LIKE '%{$_GET['search']}%' OR b.`keywords` LIKE '%{$_GET['search']}%' OR b.`content` LIKE '%{$_GET['search']}%' ) order by unix_timestamp(b.date_created) desc limit $limit offset $offset");
                while($row=$blogs->fetch_assoc()):
                    ?>
                        <a class="list-group-item list-group-item-action my-2 border" href="<?php echo base_url.$row['blog_url'] ?>">
                            <div class="w-100">
                                <img src="<?php echo validate_image($row['banner_path']) ?>" alt="<?php echo addslashes($row['title']) ?>" align="left" class="bg-dark img-banner-list img-thumbnail m-2">
                                <p class="truncate-5 pt-3"><?php echo strip_tags(stripslashes(html_entity_decode($row['content']))) ?></p><br>
                            </div>
                            <div class="w 100 d-flex justify-content-end">
                                <span class="text-muted">نشر في: <?php echo date("M d, Y h:i A", strtotime($row['date_created'])) ?></span><br>
                                <span class="text-muted">بواسطة: <?php echo ucwords($row['author']) ?></span>
                            </div>
                        </a>
                <?php endwhile; ?>
                </div>
                <?php if($count_all <= 0): ?>
                    <h4 class="text-center">لا توجد مقالات تحتوي على كلمة "<?php echo $_GET['search'] ?>".</h4>
                    <?php else:  ?>
                <div class="btn-group">
                    <a href="<?php echo base_url ?>?p=search&search=<?php echo $_GET['search'] ?>&page=<?php echo $page - 1 ?>" class="btn btn-default border <?php echo $page == 0 ? 'disabled': '' ?>"><i class="fa fa-step-backward"></i></a>
                        <a href="<?php echo base_url ?>?p=search&search=<?php echo $_GET['search'] ?>" class="btn btn-default border <?php echo $page == 0 ? 'bg-primary': '' ?>">1</a>
                        <?php for($i = 1; $i < ceil(intval($count_all) / intval($limit)); $i++): ?>
                        <a href="<?php echo base_url ?>?p=search&search=<?php echo $_GET['search'] ?>&page=<?php echo $i ?>" class="btn btn-default border <?php echo $page == $i ? 'bg-primary': '' ?>""><?php echo $i + 1; ?></a>
                        <?php endfor; ?>

                    <a href="<?php echo base_url ?>?p=search&search=<?php echo $_GET['search'] ?>&page=<?php echo $page + 1 ?>" class="btn btn-default border <?php echo $page == (ceil($count_all/$limit) - 1) || $count_all == 0 ? 'disabled': '' ?>"><i class="fa fa-step-forward"></i></a>

                    </div>
                    <?php endif;  ?>

            </div>
            <div class="col-lg-4 border-left">
                <p>لوريم إيبسوم هو نص شائع في صناعات التصميم. بدأ كنص خيالي غير مفهوم في القرن الخامس عشر، حيث أخذ جزءًا من كتاب "دي فينسي لاتينوروم دي فينسي" بواسطة سيسيليوس وأوبيس. تم توضيحه لأول مرة في "لوريم إيبسوم دولور سيت أميت"، من قبل فوغليري إيبرين. الآن يستخدم النص منذ العصور الوسطى بشكل أساسي في ترتيب الأرقام والأحرف في تصميم الطباعة الفنية، وكذلك في تخطيط التصميم.</p>
            </div>
       </div>
    </div>
</section>
