<?php

?>

<div class="wrap">  
    <h2>百度熊掌号设置</h2>  
    <?php if( !is_writable(dirname(__FILE__).'/log/') || get_transient('I3GEEK_XZH_LOG_WRITABLE')==1 ){ set_transient('I3GEEK_XZH_LOG_WRITABLE', 0, 3600);?>
          <div id="message" class="updated" style="border-left-color: #d54e21;background: #fef7f1;">
            <p>log目录没有写权限！请设置/wp-content/plugins/i3geek_baiduXZH/log/目录及其中所有文件777权限.(若不设置不影响使用，但是无法查看提交记录) <a href="http://bbs.i3geek.com/forum.php?mod=viewthread&tid=21" target="_blank">查看帮助</a></p>
          </div>
    <?php } ?>
    <?php if( is_array($i3geek_xzh_notice) && $i3geek_xzh_notice['version'] > $plugin_data['Version'] ){?>
          <div id="message" class="updated" style="border-left-color: #f0ad4e;background: #fcf8e4;">
            <p>百度熊掌号 插件已有新版本啦！请更新插件到最新版，以避免百度处罚 <a href=<?php echo '"'.$i3geek_xzh_notice['download'].'"'; ?> target="_blank">查看详情</a></p>
          </div>
    <?php } ?>
    <?php if( is_array($i3geek_xzh_notice) && $i3geek_xzh_notice['msg_switch']==0 ){}else{ ?>
          <div id="notice_msg" class="updated" style="border-left-color: #00a0d2;background: #f7fcfe;">
            <p><strong>公告</strong>： <?php echo is_array($i3geek_xzh_notice)?$i3geek_xzh_notice['content']:'请更新插件到最新版，以避免百度处罚，详情查看插件主页：<a href="http://xzh.i3geek.com" target="_blank">百度熊掌号</a> <a href="http://bbs.i3geek.com" target="_blank">交流论坛</a>'; ?></p>
          </div>
    <?php } ?>
    <?php if( get_transient('I3GEEK_XZH_MSG_STATUS') > 0){ ?>
        <div id="message" class="updated" style="border-left-color: #d54e21;background: #fef7f1;">
            <p><?php echo get_transient('I3GEEK_XZH_MSG_CONTENT'); ?></p>
        </div>
        <?php }elseif( get_transient('I3GEEK_XZH_MSG_STATUS') < 0){ ?>
        <div id="message" class="updated">
            <p><?php echo get_transient('I3GEEK_XZH_MSG_CONTENT'); ?></p>
        </div>
    <?php } ?>
         <!-- Nav tabs -->
        <h2 class="nav-tab-wrapper" style="border-bottom: 1px solid #ccc;">
          <a class="nav-tab" href="javascript:;" id="tab-title-setting">基本配置</a>
          <a class="nav-tab" href="javascript:;" id="tab-title-log">提交记录</a>
          <a class="nav-tab" href="http://xzh.i3geek.com" target="_blank" id="tab-title-about">帮助/关于</a>
          <a class="nav-tab" href="http://bbs.i3geek.com/forum.php?mod=forumdisplay&fid=39" target="_blank"  id="tab-title-about"><font color="red">交流反馈</font></a>
        </h2>
        <?php $Settings = get_option('I3GEEK_XZH_SETTING');?>
        <div id="tab-setting" class="div-tab hidden" style="display: none;" >
          <h3>熊掌号设置</h3>
            <p><strong>* 获取相关参数：注册百度熊掌号并绑定站点，在“提交方式”中查看所需参数填写在下方。<a href="http://ziyuan.baidu.com/xzh/commit/method" target="_blank">百度熊掌号</a></strong></p>
            <table class="form-table">
              <form method="post" action >
              <tbody>
                <tr>
                  <th scope="row">
                    <label for="host">appid</label>
                  </th>
                  <td>
                    <input type="text" name="appid" class="type-text regular-text" value="<?php echo $Settings['Appid']?>">
                    <p><i>您的熊掌号唯一识别ID</i></p>
                  </td>
                </tr>
                <tr>
                  <th scope="row">
                    <label for="bucket">token</label>
                  </th>
                  <td>
                    <input type="text" name="token" class="type-text regular-text" value="<?php echo $Settings['Token']?>">
                    <p><i>在搜索资源平台申请的推送用的准入密钥</i></p>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><label>文章类型支持</label></th>
                  <td><?php
                     $args = array('public' => true,);
                     $post_types = get_post_types($args);
                     foreach ( $post_types  as $post_type ) {
                        if($post_type != 'attachment'){
                          $postType = get_post_type_object($post_type);
                          echo '<label><input type="checkbox" name="Types[]" value="'.$post_type.'" '.'disabled ';
                          if( $post_type == 'post') echo 'checked';
                          echo '>'.$postType->labels->singular_name.' &nbsp; &nbsp; </label>';
                        }
                     }?>
                     <p><i>选择支持的内容类型（免费版只支持文章，更多请升级专业版）</i></p>
                  </td>
                </tr>
                <tr>
                  <th scope="row">
                    <label for="access">自动提交</label>
                  </th>
                  <td>
                    <input type="radio" name="auto_submit" value="y" checked/>是 <input type="radio" name="auto_submit" value="n" />否
                    <p><i>当发布新文章时自动提交链接到百度官方熊掌号（若关闭则必须在本插件中手动提交）</i></p>
                  </td>
                </tr>
                <tr>
                  <th scope="row">
                    <label for="access">默认原创</label>
                  </th>
                  <td>
                    <input type="radio" name="auto_original" value="y"/>是 <input type="radio" name="auto_original" value="n" checked/>否
                    <p><i>当发布新文章时默认原创保护提交至百度（可以在页面中修改）</i><br><font color="red">一定要有原创权限后再勾选“是”，否则会提交失败！<a href="http://bbs.i3geek.com/forum.php?mod=viewthread&tid=22" target="_blank">查看说明</a></font></p>
                  </td>
                </tr>
                <tr>
                  <th scope="row">
                    <input type="hidden" name="action" value="i3geek_xzh_setting" /> 
                    <input type="hidden" name="current_tab" value="setting"/>
                    <?php wp_nonce_field( 'i3geek-xzh-post', '_i3geek_xzh_post_nonce', false, true ); ?>
                    <input type="submit" value="保存" class="button-primary" />
                  </th>
                </tr>
              </tbody>
              </form>
            </table>
            <p>
              <strong>温馨提示</strong>：<br>
              1. 若关闭自动提交，可通过文章列表后面按钮进行手动提交；<br>
              2. 请正常操作，以免被百度封号；<br>
              3. 其他问题、使用帮助或反馈建议 <a target="_blank" href="http://bbs.i3geek.com/forum.php?mod=forumdisplay&fid=39">进入论坛</a> 进行反馈交流。<br>
            </p>
        </div>
        <div id="tab-log" class="div-tab hidden" style="display: none;">
        <h3>提交记录</h3>
        <form method="post" action>
          <input type="hidden" name="action" value="i3geek_xzh_log" /> 
          <input type="hidden" name="current_tab" value="log"/>
          <?php wp_nonce_field( 'i3geek-xzh-post', '_i3geek_xzh_post_nonce', false, true ); ?>
          <input type="submit" value="获取" class="button-primary" />
        </form>
        <p><strong>* 点击“获取”按钮，加载操作记录（只能显示最近10条记录）</strong></p>
            <?php

              if(is_array(i3geek_baiduXZH_function::$success_log) && !empty(i3geek_baiduXZH_function::$success_log[0][0])){
                echo '<div style="border-left: solid #5ab961;background: #dff0d9;padding: 10px;"><p>成功记录</p><table border="1">';
                echo '<tr><td>ID</td><td>日期</td><td>链接</td><td>类型</td><td>原创</td></tr>';
                foreach (i3geek_baiduXZH_function::$success_log as $key => $value) {
                  echo '<tr><td>'.($key+1).'</td><td>'.$value[0].'</td><td>'.$value[1].'</td><td>'.($value[2]=='realtime'?'实时内容':'历史内容').'</td><td>'.($value[3]==1?'是':' ').'</td></tr>';
                }
                echo '</table></div>';
              }
            ?>
            <?php
              if( is_array(i3geek_baiduXZH_function::$fail_log) && !empty(i3geek_baiduXZH_function::$fail_log[0][0])){
                echo '<div id="message" style="border-left: solid #d54e21;background: #fef7f1;padding: 10px;"><p>失败记录</p><table border="1">';
                echo '<tr><td>ID</td><td>日期</td><td>链接</td><td>类型</td><td>原因</td></tr>';
                foreach (i3geek_baiduXZH_function::$fail_log as $key => $value) {
                  echo '<tr><td>'.($key+1).'</td><td>'.$value[0].'</td><td>'.$value[1].'</td><td>'.($value[2]=='realtime'?'实时内容':'历史内容').'</td><td>'.$value[3].'</td></tr>';
                }
                echo '</table></div>';
              }
            ?>
    </div>
    <div id="tab-about" class="div-tab hidden" style="display: none;">
      <div class="welcome_inner">
        <div class="welcometxt">
          <img class="backwpup-banner-img" src=<?php echo '"'.plugin_dir_url(__FILE__).'logo.png"'; ?>>
          <h1>感谢使用</h1>
          <p>本插件主要是为了使百度熊掌号（原百家号）以及百度搜索的实时收录，进行自动的URL提交，站点的SEO优化等</p>
          <p>在使用中遇到问题或建议请及时和我联系：yan#i3geek.com(请把#替换成@)</p>
          <p>同时为了维护插件，欢迎使用者进行捐赠并提供了专业版进行购买</p>
        </div>
      </div>
      <div class="backwpup_comp">
            <h3>免费版和专业版</h3>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tbody><tr class="even ub">
                <td>功能</td>
                <td class="free">FREE</td>
                <td class="pro">PRO</td>
              </tr>
              <tr class="odd">
                <td>自动推送</td>
                <td class="tick">YES</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="even">
                <td>手动推送</td>
                <td class="tick">YES</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="odd">
                <td>实时内容推送</td>
                <td class="tick">YES</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="even">
                <td>原创内容推送</td>
                <td class="tick">YES</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="odd">
                <td>历史内容推送</td>
                <td class="tick">YES</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="even">
                <td>推送结果展示</td>
                <td class="tick">YES</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="odd">
                <td>可选内容类型</td>
                <td class="tick">YES</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="even">
                <td>提交记录查看</td>
                <td class="tick">YES</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="odd">
                <td>页面结构化改造</td>
                <td class="error">NO</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="even">
                <td>MIP页面改造</td>
                <td class="error">NO</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="odd">
                <td>H5页面改造</td>
                <td class="error">NO</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="even">
                <td>粉丝关注按钮改造</td>
                <td class="error">NO</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="odd">
                <td>未提交文章检索</td>
                <td class="error">NO</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="even">
                <td>历史内容批量提交</td>
                <td class="error">NO</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="odd">
                <td>手动批量提交</td>
                <td class="error">NO</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="even">
                <td><strong>高级支持</strong></td>
                <td class="error">NO</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="odd">
                <td><strong>自动更新</strong></td>
                <td class="error" style="border-bottom:none;">NO</td>
                <td class="tick" style="border-bottom:none;">YES</td>
              </tr>
              <tr class="odd ubdown">
                <td></td>
                <td></td>
                <td class="pro buylink"><a href="http://xzh.i3geek.com/#pro">GET PRO</a></td>
              </tr>
            </tbody></table>
          </div>
    </div>
    <hr>
    <div style='text-align:center;'>
      <a href="http://xzh.i3geek.com" target="_blank">插件主页</a> | <a href="http://bbs.i3geek.com/forum.php?mod=forumdisplay&fid=39" target="_blank">插件讨论</a> | <a href="http://bbs.i3geek.com/home.php?mod=spacecp&ac=pm&op=showmsg&handlekey=showmsg_1&touid=1" target="_blank">联系作者</a> | <a href="http://www.i3geek.com/archives/1681" target="_blank">插件介绍</a> | <a href="http://bbs.i3geek.com/forum.php?mod=viewthread&tid=8" target="_blank">更新记录</a> | QQ群：194895016
      <br> Powered by <a href="http://www.i3geek.com" target="_blank">i3geek.com</a>
    </div>
</div>  
<script type='text/javascript'>
  <?php
    if(is_array($Settings)){
      echo 'jQuery("input[type=\'radio\'][name=\'auto_submit\'][value=\''.$Settings['auto'].'\']").attr("checked",true);';
      echo 'jQuery("input[type=\'radio\'][name=\'auto_original\'][value=\''.$Settings['original'].'\']").attr("checked",true);';
    }
    echo "var current_tab='".$_POST['current_tab']."';";
  ?>
  jQuery(function(jQuery){
    if(jQuery('div.div-tab').length){
      if(jQuery('#current_tab').length)
        current_tab = jQuery('#current_tab').first().val();      
      if(current_tab == '')
        current_tab = jQuery('div.div-tab').first()[0].id.replace('tab-','');
      var htitle    = jQuery('#tab-title-'+current_tab).parent()[0].tagName;
      jQuery('div.div-tab').hide();
      jQuery('#tab-title-'+current_tab).addClass('nav-tab-active');
      jQuery('#tab-'+current_tab).show();
      jQuery('#current_tab').val(current_tab);
      jQuery(htitle+' a.nav-tab').on('click',function(){
        var prev_tab  = current_tab;
        current_tab   = jQuery(this)[0].id.replace('tab-title-','');
        jQuery('#tab-title-'+prev_tab).removeClass('nav-tab-active');
        jQuery(this).addClass('nav-tab-active');
        jQuery('#tab-'+prev_tab).hide();
        jQuery('#tab-'+current_tab).show();
        if(jQuery('#current_tab').length){
          jQuery('#current_tab').val(current_tab);
        }
      });
    }
    jQuery('input[type=checkbox]').click(function() {
      jQuery("input[name='fans[]']").attr('disabled', true);
      if (jQuery("input[name='fans[]']:checked").length >= 2) {
          jQuery("input[name='fans[]']:checked").attr('disabled', false);
      } else {
          jQuery("input[name='fans[]']").attr('disabled', false);
      }
    });
  return false;
});
</script>