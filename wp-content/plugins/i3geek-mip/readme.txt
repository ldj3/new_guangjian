=== MIP改造 ===
Contributors: i3geek
Donate link: http://www.i3geek.com/
Tags: MIP, mobile, Baidu, Seo, 百度, 百度收录
Requires at least: 3.0.1
Tested up to: 4.9.5
Requires PHP: 5.2.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Enable Mobile Instant Pages (MIP) on your WordPress site.
使站点按照MIP规范进行改造,并自动提交文章,加快百度收录提高站点SEO

== Description ==
[插件首页](http://mip.i3geek.com/)

安装MIP改造插件后，能保留原主题和样式的情况下，额外创造MIP页面，使网站移动端页面可以极速加载，无需等待，提高百度权重。
插件主要功能如下：

* 一键MIP改造：无需安装主题或第三方插件，轻松完成站点的MIP改造
* 保留原主题：改造后原主题和样式不变，只是额外增加MIP页面用于搜索引擎检索，使站点同时存在电脑端+移动端+MIP三类形式

使用本插件有助于：

* 移动端页面加速，无需等待加载
* MIP由百度开发并推广，极利于百度检索，提高索引量，提升权重
* 优化后的页面质量、速度有助于百度提权，增加用户量，减少流失率

获得专业版：[GET PRO](http://mip.i3geek.com/)

* 全站改造：不仅仅可以改造文章页，包括首页、内容页等全部页面均可以改造
* 自定义文章类型改造：用户站点自定义的文章类型也支持MIP改造
* 百度熊掌号：支持对MIP页面进行百度熊掌号改造
* 自动推送：文章发布时，自动推送MIP页面至百度，提高检索速度
* 样式完善：改造后的文章样式功能更全，模块更多
* 高级支持：一对一的技术支持
* 更多功能：插件会不断完善，并第一时间更新到专业版中

This plugin adds support for the [Mobile Instant Pages](https://www.mipengine.org/) (MIP) Project, which is an open source initiative that aims to provide mobile optimized content that can load instantly everywhere.(developed by Baidu )

With the plugin active, all posts on your site will have dynamically generated MIP-compatible versions, accessible by appending `/mip/` to the end your post URLs instead of installing MIP format theme. For example, if your post URL is `http://example.com/archives/123/`, you can access the MIP version at `http://example.com/archives/123/mip/`. If you do not have [pretty permalinks](https://codex.wordpress.org/Using_Permalinks#mod_rewrite:_.22Pretty_Permalinks.22) enabled, you can do the same thing by appending `?mip`, i.e. `http://example.com/?p=123&mip` or `http://example.com/?p=123&mip=1`

Note #1: ONLY single post is currently supported. 

Note #2: this plugin only creates MIP content but does not automatically display it to your users when they visit from a mobile device. That is handled by MIP consumers such as Baidu Search. For more details, see the [MIP Project Wiki](https://github.com/mipengine/mip/wiki).

本插件可以使你的站点完成[Mobile Instant Pages](https://www.mipengine.org/) (MIP)改造，完成改造后可以加快站点移动端的访问速度。（MIP是由百度推出的移动端加速框架，能很好的被百度检索）

当开启插件后，站点的所有内容都将会产生一个MIP格式的副本，并自动与原界面保持关联且同时存在。即省去了安装新MIP主题的烦恼，也不用修改域名等配置。例如，你的文章链接是`http://example.com/archives/123/`，那么支持MIP的页面会是`http://example.com/archives/123/mip/`。如果你的页面不支持固定链接格式，那么也可以通过添加`?mip`参数达到同样的效果，如`http://example.com/?p=123&mip` 或  `http://example.com/?p=123&mip=1`

注意1：目前的版本只支持对文章页的改造

注意2：本插件只是创建了MIP页面，并不能在用户浏览时自动的展示MIP页面。MIP页面的展示是在如百度等搜索引擎的结果中。具体可以参考[MIP Project Wiki](https://github.com/mipengine/mip/wiki)

== Screenshots ==

1. Settings page (插件设置界面)
2. Customizing appearance of MIP template.(header)(MIP改造后的界面 头部)
3. Customizing appearance of MIP template.(footer)(MIP改造后的界面 底部)

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/mip` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the "MIP改造" to configure the plugin

安装：

1. 上传插件全部文件到`/wp-content/plugins/mip`目录，或者在wordpress插件中心进行安装。
2. 进入后台开启插件。
3. 通过侧边栏"MIP改造"进行设置插件。


== Changelog ==

= 1.1.0 =
* Initial version

== Upgrade Notice ==

暂无
