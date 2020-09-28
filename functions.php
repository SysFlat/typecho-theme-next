<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form) {

    $siteUrl = Helper::options()->siteUrl;

    $next_name = new Typecho_Widget_Helper_Form_Element_Text('next_name', NULL, '', _t('侧边栏显示的昵称'), _t('显示在头像下方'));
    $next_name->input->setAttribute('class', 'w-100 mono');
    $form->addInput($next_name);


    $next_gravatar = new Typecho_Widget_Helper_Form_Element_Text('next_gravatar', NULL, '', _t('侧边栏头像'), _t('填写头像地址'));
    $next_gravatar->input->setAttribute('class', 'w-100 mono');
    $form->addInput($next_gravatar);

    $next_tips = new Typecho_Widget_Helper_Form_Element_Text('next_tips', NULL, '一个高端大气上档次的网站', _t('站点描述'), _t('将显示在侧边栏的昵称下方'));
    $form->addInput($next_tips);
    
    //ICP备案号
    $next_icp = new Typecho_Widget_Helper_Form_Element_Text('next_icp', NULL, '', _t('ICP备案号'));
    $next_icp->input->setAttribute('class', 'w-100 mono');
    $form->addInput($next_icp);
    
    $next_cdn = new Typecho_Widget_Helper_Form_Element_Text('next_cdn', NULL, $siteUrl, _t('CDN 镜像地址'), _t('静态文件 CDN 镜像加速地址，加速js和css，如七牛，又拍云等<br>格式参考：'.$siteUrl.'<br>不用请留空或者保持默认'));
    $form->addInput($next_cdn);

    $sidebar = new Typecho_Widget_Helper_Form_Element_Radio('sidebar', 
    array(_t('始终自动弹出'),
        _t('文章中有目录时弹出'),
        _t('不自动弹出')
        ),
    1, _t('侧边栏自动弹出设置'));
    
    $form->addInput($sidebar);

    $next_comments =  new Typecho_Widget_Helper_Form_Element_Text('next_comments', NULL, '', _t('多说评论'), _t('填写多说评论的short_name,如果使用自带评论则不填'));

    $form->addInput($next_comments);

    $search_form = new Typecho_Widget_Helper_Form_Element_Checkbox('search_form', 
    array('Motion' => _t('启用动画效果'),
        'ShowSearch' => _t('显示搜索框'),
        'ShowFeed' => _t('显示 RSS 订阅'),
        ),
    array('ShowSearch','ShowFeed','Motion'), _t('其他设置'));
    
    $form->addInput($search_form->multiMode());
}

function getGravatar($email, $s = 40, $d = 'mm', $g = 'g') {

    $hash = md5($email);

    $avatar = "//cdn.v2ex.com/gravatar/$hash?s=$s&d=$d&r=$g";

    return $avatar;

}

function getTagCount()
{
    $tags = Typecho_Widget::widget('Widget_Metas_Tag_Cloud');
    // 获取标签数目
    $count = 0;
    while ($tags->next()):
        $count++;
    endwhile;
    return $count;
}

/*
function themeFields($layout) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('站点LOGO地址'), _t('在这里填入一个图片URL地址, 以在网站标题前加上一个LOGO'));
    $layout->addItem($logoUrl);
}
*/
function themeInit($archive) {

    //归档列表全部输出
    if ($archive->is('archive')&& !$archive->is('search')) {
        $archive->parameter->pageSize = 10000; // 自定义条数
    }
}
/**
 * 加载时间
 * @return bool
 */
function timer_start() {
    global $timestart;
    $mtime     = explode( ' ', microtime() );
    $timestart = $mtime[1] + $mtime[0];
    return true;
}
timer_start();
function timer_stop( $display = 0, $precision = 3 ) {
    global $timestart, $timeend;
    $mtime     = explode( ' ', microtime() );
    $timeend   = $mtime[1] + $mtime[0];
    $timetotal = number_format( $timeend - $timestart, $precision );
    $r         = $timetotal < 1 ? $timetotal * 1000 . " ms" : $timetotal . " s";
    if ( $display ) {
        echo $r;
    }
    return $r;
}
/**
 * 阅读次数
 * @return bool
 */
function Postviews($archive) {
    $db = Typecho_Db::get();
    $cid = $archive->cid;
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `'.$db->getPrefix().'contents` ADD `views` INT(10) DEFAULT 0;');
    }
    $exist = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid))['views'];
    if ($archive->is('single')) {
        $cookie = Typecho_Cookie::get('contents_views');
        $cookie = $cookie ? explode(',', $cookie) : array();
        if (!in_array($cid, $cookie)) {
            $db->query($db->update('table.contents')
                ->rows(array('views' => (int)$exist+1))
                ->where('cid = ?', $cid));
            $exist = (int)$exist+1;
            array_push($cookie, $cid);
            $cookie = implode(',', $cookie);
            Typecho_Cookie::set('contents_views', $cookie);
        }
    }
    echo $exist == 0 ? '暂无阅读' : $exist.' 次阅读';
}
/*
* 访问总数
*/
function get_post_view($archive)
{
	$cid = $archive->cid;
	$db = Typecho_Db::get();
	$prefix = $db->getPrefix();
	if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
	$db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
	echo 0;
	return;
	}
	$row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
	if ($archive->is('single')) {
	$db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
	}
	echo $row['views'];
}