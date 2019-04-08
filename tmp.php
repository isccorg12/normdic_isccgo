<?php $__env->startSection('head'); ?>
<!--
    <script src='/js/masonry.pkgd.min.js'></script>
-->

<style>
    #map {
        height: calc(100vh - 365px);
        width: 100%;
    }
    .summary-block .title, .single-block .title {
        display: block;
        padding-top: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #BDBDBD;
        font-weight: bold;
        font-size: 1.2em;
    }
    .summary-block .grid {
        margin-bottom: 40px;
    }

    .summary-block .entry {
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .summary-block .entry .timestamp{
        display: none;
    }

    .single-block {
        margin-bottom: 40px;
    }

    .single-block .entry {
        padding-top: 5px;
        padding-bottom: 5px;
        border-bottom: 1px solid #e0e0e0;
    }

    .single-block .entry .timestamp{
        float: right;
    }

</style>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class='container'>

    <div class='row'>
        <div class='col-md-12'>
            <div style="display: inline-block;">
                <!--
                <?php echo $user->presentPointPhoto(); ?>

                -->
                <img src='<?php echo e($user->profile->avatar); ?>' style='border-radius: 50%;'>
            </div>
            <div style="display: inline-block; vertical-align: top; margin-left: 10px;">
                <div style='font-size: 18px;'> <?php echo e($user->name); ?> </div>
                <div>Experience: <?php echo e($user->getScore()); ?></div>
            </div>
        </div>
    </div>
</div>
<br>

<div class='container'>
    <div class='row'>
        <div class='col-md-12'>
            <ul class="nav nav-tabs">
              <li role="presentation" <?php if($mode === 'summary'): ?> class="active" <?php endif; ?>><a href="/user/<?php echo e($user->id); ?>">總覽</a></li>
              <li role="presentation" <?php if($mode === 'cafes'): ?> class="active" <?php endif; ?>><a href="/user/<?php echo e($user->id); ?>?tab=cafes">新增 (<?php echo e($user->entities->count()); ?>)</a></li>
              <li role="presentation" <?php if($mode === 'reviews'): ?> class="active" <?php endif; ?>><a href="/user/<?php echo e($user->id); ?>?tab=reviews">評分 (<?php echo e($user->reviews->count()); ?>)</a></li>
              <li role="presentation" <?php if($mode === 'editings'): ?> class="active" <?php endif; ?>><a href="/user/<?php echo e($user->id); ?>?tab=editings">編修 (<?php echo e($user->editings->count()); ?>)</a></li>
              <li role="presentation" <?php if($mode === 'comments'): ?> class="active" <?php endif; ?>><a href="/user/<?php echo e($user->id); ?>?tab=comments">留言 (<?php echo e($user->comments->count()); ?>)</a></li>
              <!--
              <li role="presentation" <?php if($mode === 'photos'): ?> class="active" <?php endif; ?>><a href="/user/<?php echo e($user->id); ?>?tab=photos">拍照 (<?php echo e($user->validPhotos()->count()); ?>)</a></li>
              -->
              <li role="presentation" <?php if($mode === 'visits'): ?> class="active" <?php endif; ?>><a href="/user/<?php echo e($user->id); ?>?tab=visits">打卡 (<?php echo e($user->recommendations->count()); ?>)</a></li>
              <li role="presentation" <?php if($mode === 'tags'): ?> class="active" <?php endif; ?>><a href="/user/<?php echo e($user->id); ?>?tab=tags">標籤 (<?php //echo e($user->cafeTags->count()); ?>)</a></li>
            </ul>
        </div>
    </div>
    <br>
    <br>
</div>
<?php if($mode !== 'summary'): ?>
<div class='container single-block'>
    <div class='row'>
        <div class='col-md-12 grid'>
            <?php if($mode === 'cafes'): ?>
                <a class='title' href='/user/<?php echo e($user->id); ?>?tab=cafes'>推薦新增 <?php echo e($user->cafes->count()); ?> 間店家</a>
                <br>
                <?php $__currentLoopData = $user->cafes->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cafe): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <?php echo $__env->make('nomadicore::user/summary/cafe-entry', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            <?php elseif($mode === 'reviews'): ?>
                <a class='title' href='/user/<?php echo e($user->id); ?>?tab=reviews'>對 <?php echo e($user->reviews->count()); ?> 間咖啡廳評分</a>
                <br>
                <?php $__currentLoopData = $user->reviews->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <?php echo $__env->make('nomadicore::user/summary/review-entry', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            <?php elseif($mode === 'editings'): ?>
                <a class='title' href='/user/<?php echo e($user->id); ?>?tab=editings'>編修 <?php echo e($user->editings->count()); ?> 間店家資料</a>
                <br>
                <?php $__currentLoopData = $user->editings->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $editing): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <?php echo $__env->make('nomadicore::user/summary/editing-entry', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            <?php elseif($mode === 'comments'): ?>
                <a class='title' href='/user/<?php echo e($user->id); ?>?tab=comments'>有 <?php echo e($user->comments->count()); ?> 則留言</a>
                <br>
                <?php $__currentLoopData = $user->comments->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <?php echo $__env->make('nomadicore::user/summary/comment-entry', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            <?php elseif($mode === 'photos'): ?>
                <a class='title' href='/user/<?php echo e($user->id); ?>?tab=photos'>上傳 <?php echo e($user->validPhotos()->count()); ?> 張相片</a>
                <br>
                <?php $__currentLoopData = $user->validPhotos()->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <?php echo $__env->make('nomadicore::user/summary/photo-entry', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            <?php elseif($mode === 'visits'): ?>
                <a class='title' href='/user/<?php echo e($user->id); ?>?tab=visits'>造訪過 <?php echo e($user->recommendations->count()); ?> 間咖啡廳</a>
                <br>
                <?php $__currentLoopData = $user->recommendations->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <?php echo $__env->make('nomadicore::user/summary/visit-entry', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            <?php elseif($mode === 'tags'): ?>
                <a class='title' href='/user/<?php echo e($user->id); ?>?tab=tags'>加上 <?php echo e($user->cafeTags->count()); ?> 個標籤</a>
                <br>
                <?php $__currentLoopData = $user->cafeTags->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cafeTag): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <?php echo $__env->make('nomadicore::user/summary/tag-entry', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if($mode === 'summary'): ?>
<div class='container summary-block'>
    <div class='row'>
        <div class='col-md-6 grid'>
            <a class='title' href='/user/<?php echo e($user->id); ?>?tab=cafes'>推薦新增 <?php echo e($user->entities->count()); ?> 間店家</a>
            <br>
            <?php $__currentLoopData = $user->entities->sortByDesc('created_at')->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cafe): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <?php echo $__env->make('nomadicore::user/summary/cafe-entry', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            <a href='/user/<?php echo e($user->id); ?>?tab=cafes'>... 顯示全部</a>
        </div>
        <div class='col-md-6 grid'>
            <a class='title' href='/user/<?php echo e($user->id); ?>?tab=reviews'>對 <?php echo e($user->reviews->count()); ?> 間咖啡廳評分</a>
            <br>
            <?php $__currentLoopData = $user->reviews->sortByDesc('created_at')->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <?php echo $__env->make('nomadicore::user/summary/review-entry', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            <a href='/user/<?php echo e($user->id); ?>?tab=reviews'>... 顯示全部</a>
        </div>
    </div>
    <div class='row'>
        <div class='col-md-6 grid'>
            <a class='title' href='/user/<?php echo e($user->id); ?>?tab=editings'>編修 <?php echo e($user->editings->count()); ?> 間店家資料</a>
            <br>
            <?php $__currentLoopData = $user->editings->sortByDesc('created_at')->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $editing): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <?php echo $__env->make('nomadicore::user/summary/editing-entry', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            <a href='/user/<?php echo e($user->id); ?>?tab=editings'>... 顯示全部</a>
        </div>
        <div class='col-md-6 grid'>
            <a class='title' href='/user/<?php echo e($user->id); ?>?tab=comments'>有 <?php echo e($user->comments->count()); ?> 則留言</a>
            <br>
            <?php $__currentLoopData = $user->comments->sortByDesc('created_at')->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <?php echo $__env->make('nomadicore::user/summary/comment-entry', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            <a href='/user/<?php echo e($user->id); ?>?tab=comments'>... 顯示全部</a>
        </div>
    </div>
    <div class='row'>
        <!--
        <div class='col-md-6 grid'>
            <a class='title' href='/user/<?php echo e($user->id); ?>?tab=photos'>上傳 <?php echo e($user->validPhotos()->count()); ?> 張相片</a>
            <br>
            <?php $__currentLoopData = $user->validPhotos()->sortByDesc('created_at')->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <?php echo $__env->make('nomadicore::user/summary/photo-entry', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            <a href='/user/<?php echo e($user->id); ?>?tab=photos'>... 顯示全部</a>
        </div>
        -->
        <div class='col-md-6 grid'>
            <a class='title' href='/user/<?php echo e($user->id); ?>?tab=visits'>造訪過 <?php echo e($user->recommendations->count()); ?> 間咖啡廳</a>
            <br>
            <?php $__currentLoopData = $user->recommendations->sortByDesc('created_at')->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <?php echo $__env->make('nomadicore::user/summary/visit-entry', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            <a href='/user/<?php echo e($user->id); ?>?tab=visits'>... 顯示全部</a>
        </div>
        <div class='col-md-6 grid'>
            <a class='title' href='/user/<?php echo e($user->id); ?>?tab=tags'>加上 <?php echo e($user->entityTags->count()); ?> 個標籤</a>
            <br>
            <?php $__currentLoopData = $user->entityTags->sortByDesc('created_at')->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cafeTag): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <?php echo $__env->make('nomadicore::user/summary/tag-entry', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            <a href='/user/<?php echo e($user->id); ?>?tab=tags'>... 顯示全部</a>
        </div>
    </div>

</div>
<?php endif; ?>

<?php echo $__env->make('nomadicore::partial/_footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('nomadicore::layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
