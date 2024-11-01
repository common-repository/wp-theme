<?php
/*
 * Plugin Name: WP Themes Plugin
 * Plugin URI: http://extremedata.eu/projects/wp-theme
 * Description: WP Theme plugin allow you to preview a theme without activating it from admin panel.
 * Author: Extremedata
 * Author URI: http://extremedata.eu
 * Version: 1.2
 */

/*
 * USAGE:
 *
 *  http://example.com/index.php?wp_theme=MyTheme&wp_css=MyCss
 */

$x_wp_theme = $_GET['wp_theme'];
$x_wp_css = $_GET['wp_css'];
function wpthemes_add_options_page() 
{
	add_options_page('WpThemes Optons', 'WpThemes', 8, 'wp_theme.php','WpThemesDisply');
}

if ( function_exists("is_plugin_page") && is_plugin_page() ) {
	WpThemesDisply(); 
	return;
}

if (! $x_wp_css ) 
	$x_wp_css = $x_wp_theme;

if($x_wp_theme && file_exists(get_theme_root() . "/$x_wp_theme")) {
	add_filter('template','use_wp_theme');
}

if($x_wp_css && file_exists(get_theme_root() . "/$x_wp_css")) {
	add_filter('stylesheet','use_wp_css');
}

function use_wp_theme($themename) {
	global $x_wp_theme;
	return $x_wp_theme;
}

function use_wp_css($cssname) {
	global $x_wp_css;
	return $x_wp_css;
}

function WpThemesDisply() {
$themesdir = get_theme_root();
$TrackDir=opendir($themesdir);

echo <<<END
<h2>WpThemes Options Page</h2>
<br />
To see how a theme looks without activating it from admin panel you just need to add <strong><em>?wp_theme=YourThemeName</em></strong> to the end of your wordpress url.<br />Also you can add <strong><em>&wp_css=....</em></strong> to use another css file.
<br /><br /><br />Below is a list of your installed themes available on <strong><em>wp-content/themes</em></strong> directory.<br />
To add a new theme you need to upload the theme to <strong><em>wp-content/themes</em></strong> directory
<br /><br />
<table width="100%" border="0" cellspacing="5" cellpadding="5" style="text-align:left">
	<tr>
	<th scope="col">Theme name and live link</th>
	<th scope="col">Theme link</th>
  </tr>
END;

while ($file = readdir($TrackDir)) {
if ($file == "." || $file == ".." || is_file($file)) { }

else {
$siteurl = get_bloginfo('siteurl');
$themeurl = $siteurl."/index.php?wp_theme=".$file;
echo <<<END
	<tr>
	<td>
	<a href="$themeurl" target="_blank">$file</a>
	</td>
	<td>$themeurl</td>
	</tr>
END;

}

}
echo "</table>";
echo <<<END
<br /><br />
You can get free wordpress themes and plugins from <a href="http://extremedata.eu/projects">extremedata.eu</a> 
<br /><br />
<a href="http://extremedata.eu/projects/doteu-blue">DotEU Blue Theme</a> (<a href="http://extremedata.eu/projects/doteu-blue">Demo</a>)
<br />
<hr width="50%" align="left" />
This is a free plugin.If you like it
<br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input name="cmd" value="_s-xclick" type="hidden" />
<input name="hosted_button_id" value="4780128" type="hidden" />
<input alt="PayPal - The safer, easier way to pay online!" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" type="image" />
<img src="https://www.paypal.com/en_US/i/scr/pixel.gif" alt="" border="0" height="1" width="1" /><br />
</form>
END;
closedir($TrackDir);
return;
}

add_action('admin_menu', 'wpthemes_add_options_page');
?>