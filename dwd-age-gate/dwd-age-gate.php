<?php
/*
Plugin Name: AgeGate by DWD
Plugin URI: https://dwd.tech
Description: This plugin shows a popup for age verification.
Author: Philip Deatherage / DWD
Author URI: https://dwd.tech
Version: 1.1.0
*/

// function to check if bots that we want to exclude the pop-up from are the one accessing it. This is to prevent being penalized with SEO 
function isBotDetected() {
    if ( preg_match('/abacho|accona|AddThis|AdsBot|ahoy|AhrefsBot|AISearchBot|alexa|altavista|anthill|appie|applebot|arale|araneo|AraybOt|ariadne|arks|aspseek|ATN_Worldwide|Atomz|baiduspider|baidu|bbot|bingbot|bing|Bjaaland|BlackWidow|BotLink|bot|boxseabot|bspider|calif|CCBot|ChinaClaw|christcrawler|CMC\/0\.01|combine|confuzzledbot|contaxe|CoolBot|cosmos|crawler|crawlpaper|crawl|curl|cusco|cyberspyder|cydralspider|dataprovider|digger|DIIbot|DotBot|downloadexpress|DragonBot|DuckDuckBot|dwcp|EasouSpider|ebiness|ecollector|elfinbot|esculapio|ESI|esther|eStyle|Ezooms|facebookexternalhit|facebook|facebot|fastcrawler|FatBot|FDSE|FELIX IDE|fetch|fido|find|Firefly|fouineur|Freecrawl|froogle|gammaSpider|gazz|gcreep|geona|Getterrobo-Plus|get|girafabot|GTmetrix|golem|googlebot|\-google|grabber|GrabNet|griffon|Gromit|gulliver|gulper|hambot|havIndex|hotwired|htdig|HTTrack|ia_archiver|iajabot|IDBot|Informant|InfoSeek|InfoSpiders|INGRID\/0\.1|inktomi|inspectorwww|Internet Cruiser Robot|irobot|Iron33|JBot|jcrawler|Jeeves|jobo|KDD\-Explorer|KIT\-Fireball|ko_yappo_robot|label\-grabber|larbin|legs|libwww-perl|linkedin|Linkidator|linkwalker|Lockon|logo_gif_crawler|Lycos|m2e|majesticsEO|marvin|mattie|mediafox|mediapartners|MerzScope|MindCrawler|MJ12bot|mod_pagespeed|moget|Motor|msnbot|muncher|muninn|MuscatFerret|MwdSearch|NationalDirectory|naverbot|NEC\-MeshExplorer|NetcraftSurveyAgent|NetScoop|NetSeer|newscan\-online|nil|none|Nutch|ObjectsSearch|Occam|openstat.ru\/Bot|packrat|pageboy|ParaSite|patric|pegasus|perlcrawler|phpdig|piltdownman|Pimptrain|pingdom|pinterest|pjspider|PlumtreeWebAccessor|PortalBSpider|psbot|rambler|Raven|RHCS|RixBot|roadrunner|Robbie|robi|RoboCrawl|robofox|Scooter|Scrubby|Search\-AU|searchprocess|search|SemrushBot|Senrigan|seznambot|Shagseeker|sharp\-info\-agent|sift|SimBot|Site Valet|SiteSucker|skymob|SLCrawler\/2\.0|slurp|snooper|solbot|speedy|spider_monkey|SpiderBot\/1\.0|spiderline|spider|suke|tach_bw|TechBOT|TechnoratiSnoop|templeton|teoma|titin|topiclink|twitterbot|twitter|UdmSearch|Ukonline|UnwindFetchor|URL_Spider_SQL|urlck|urlresolver|Valkyrie libwww\-perl|verticrawl|Victoria|void\-bot|Voyager|VWbot_K|wapspider|WebBandit\/1\.0|webcatcher|WebCopier|WebFindBot|WebLeacher|WebMechanic|WebMoose|webquest|webreaper|webspider|webs|WebWalker|WebZip|wget|whowhere|winona|wlm|WOLP|woriobot|WWWC|XGET|xing|yahoo|YandexBot|YandexMobileBot|yandex|yeti|Zeus/i', $_SERVER['HTTP_USER_AGENT'])
    ) {
        return true; // 'Above given bots detected'
    }
    return false;
}

//first, lets check if it's a bot, because there is no need to give warning to a bot, and it's better not to for SEO
if (isBotDetected() === true) {
	// do nothing if it's a bot.
} else {
	// if it's NOT a bot
	// add the action to see if we are logged in - as there is not a need to show it to logged in users.
	add_action('init', 'only_if_not_logged_in');
	
	function only_if_not_logged_in() {
		if ( !is_admin() && !is_user_logged_in() ) {
			//if not logged in, then add scripts
			add_action('wp_enqueue_scripts', 'age_gate_enqueue_script');
		}
	}

	function age_gate_enqueue_script() { 
		if (!is_admin()) {  
		    wp_enqueue_script('js_cookie', plugin_dir_url( __FILE__ ) . 'assets/js/js-cookie.js', array('jquery'));
		    wp_enqueue_script('age_gate', plugin_dir_url( __FILE__ ) . 'assets/js/age.js', array('jquery'));
		    wp_enqueue_style('age_gate', plugin_dir_url(__FILE__) . 'assets/css/age.css', false);
		}
	}

	// add the code for the popup.
	add_action('wp_footer','age_gate_call');

	function age_gate_call() {
		// if ( !is_admin() && !is_checkout() && !is_page('checkout') ) {
			// first check if they are logged in
			if ( !is_admin() && !is_user_logged_in() ) {
			?>
			<div id="popup" data-popup="popup-1" style="display:none;">
			    <div class="verify-window">
			        <h3>Age Verification</h3>
			        <p>Are you at least 21 years old?</p>

			        <div class="button-yes" data-popup-close="popup-1">
			            Yes
			        </div>

			        <a href="https://www.google.com" target="_parent">
			            <div class="button-no">
			                No
			            </div>
			        </a>
			    </div><!-- // verify window -->
			</div>
		<?php }
	}
}
