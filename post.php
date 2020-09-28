<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<main id="main" class="main">
  <div class="main-inner">
    <div id="content" class="content">
        <div id="posts" class="posts-expand">
            <article class="post post-type-normal " itemscope itemtype="http://schema.org/Article">
              <header class="post-header">

                  <h1 class="post-title" itemprop="name headline">
                     <?php $this->title() ?>
                 </h1>

                 <div class="post-meta">
                     <span class="post-time">
                        发表于
                        <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date('Y-m-d'); ?></time>
                    </span>
                     <span class="post-time">
                        &nbsp; | &nbsp;最近修改于<?php echo date('Y-m-d' , $this->modified); ?>
                    </span>

                    <span class="post-category" >
                      &nbsp; | &nbsp; 分类于

						<span itemprop="about" itemscope itemtype="https://schema.org/Thing">
                       <?php $this->category(' , '); ?>
						</span>


               </span>

              <span class="post-comments-count">
                &nbsp; | &nbsp;
                <?php if(!empty($this->options->next_comments)): ?>
                <a rel="nofollow" href="<?php $this->permalink() ?>#comments"><span class="ds-thread-count" data-thread-key="<?php echo $this->cid;?>" data-count-type="comments"></span></a>
                <?php else: ?>
                <a rel="nofollow" href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('暂无评论', '1 条评论', '%d 条评论'); ?></a>
                <?php endif; ?>
				</span>
				<span class="post-time">
					&nbsp; | &nbsp;<?php Postviews($this); ?>
				</span>

      </div>
  </header>

  <div class="post-body">


    <span itemprop="articleBody">
        <?php $this->content(); ?>
    </span>

</div>
<blockquote class="blockquote-center" style = "font-weight:bold;font-size:20px;color: #333;padding: 18px;">完</blockquote>
        
<div class="post-well" style="background-color:#f6f6f6;padding:10px;margin-bottom: 10px;white-space: nowrap;">
    <p>文章版权：<a style="color:#15A7F0;" href="<?php $this->options->siteUrl() ?>"><?php $this->options->title() ?> - <?php $this->options->description() ?> </a></p>
    <p>本文链接：<a  style="color:#15A7F0;"href="<?php $this->permalink() ?>"><?php $this->permalink() ?></a></p>
    <p>版权声明：本文为作者原创，转载请注明文章原始出处 !</p>
</div>
<footer class="post-footer">

    <div class="post-tags">
        <?php $this->tags(' ', true); ?>
    </div>

    <div class="post-nav">
    
    <div class="post-nav-prev post-nav-item">
        <?php $this->thePrev('%s',''); ?>
    </div>  
    <div class="post-nav-next post-nav-item">
        <?php $this->theNext('%s',''); ?>
    </div>

</div>


</footer>
</article>

</div>
</div>
<?php $this->need('comments.php'); ?>
</div>
<?php $this->need('sidebar.php'); ?>
</main>

<?php $this->need('footer.php'); ?>
