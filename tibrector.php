<?php
/*
Plugin Name: Tibrector
Plugin URI: hasanozsezgin.com
Description: Direk olarak gelen trafiği yönlendirme
Version: 1.0
Author: Hasan Özsezgin
Author URI: hasanozsezgin.com
License: GNU
*/
checkReferer();
add_action('admin_menu', 'tibrector_include');
function tibrector_include(){
        add_menu_page('Tibrector','Tibrector', '8', 'tibrector', 'tibrector_func');
}

function checkReferer(){
    if (is_admin()) return;
    if (isset($GLOBALS['pagenow']) && ($GLOBALS['pagenow'] === 'wp-login.php') ) return;
    if (in_array( $_SERVER['PHP_SELF'], array( '/wp-login.php', '/wp-register.php' ) ) ) return;

    $referer = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
    $tibData = get_option('tibrectorData');
    $searchEngineDetected = false;
    if(preg_match('/www\.google.*/i',$referer) && !preg_match('/^http:\/\/www\.google\.com\//i', $referer)) $searchEngineDetected = 'google';
    if(preg_match('/go\.google\.com/i', $referer))                  $searchEngineDetected = 'google';
    if(preg_match('/search\.atomz.*/i',$referer))                   $searchEngineDetected = 'atomz';
    if(preg_match('/search\.msn.*/i',$referer))                     $searchEngineDetected = 'msn';
    if(preg_match('/search\.yahoo.*/i',$referer))                   $searchEngineDetected = 'yahoo';
    if(preg_match('/msxml\.excite\.com/i', $referer))               $searchEngineDetected = 'excite';
    if(preg_match('/search\.lycos\.com/i', $referer))               $searchEngineDetected = 'lycos';
    if(preg_match('/www\.alltheweb\.com/i', $referer))              $searchEngineDetected = 'alltheweb';
    if(preg_match('/search\.aol\.com/i', $referer))                 $searchEngineDetected = 'aol';
    if(preg_match('/search\.iwon\.com/i', $referer))                $searchEngineDetected = 'iwon';
    if(preg_match('/ask\.com/i', $referer))                         $searchEngineDetected = 'ask';
    if(preg_match('/search\.cometsystems\.com/i', $referer))        $searchEngineDetected = 'cometsystems';
    if(preg_match('/www\.hotbot\.com/i', $referer))                 $searchEngineDetected = 'hotbot';
    if(preg_match('/www\.overture\.com/i', $referer))               $searchEngineDetected = 'overture';
    if(preg_match('/www\.metacrawler\.com/i', $referer))            $searchEngineDetected = 'metacrawler';
    if(preg_match('/search\.netscape\.com/i', $referer))            $searchEngineDetected = 'netscape';
    if(preg_match('/www\.looksmart\.com/i', $referer))              $searchEngineDetected = 'looksmart';
    if(preg_match('/dpxml\.webcrawler\.com/i', $referer))           $searchEngineDetected = 'webcrawler';
    if(preg_match('/search\.earthlink\.net/i', $referer))           $searchEngineDetected = 'earthlink';
    if(preg_match('/search\.viewpoint\.com/i', $referer))           $searchEngineDetected = 'viewpoint';
    if(preg_match('/www\.mamma\.com/i', $referer))                  $searchEngineDetected = 'mamma';
    if(preg_match('/home\.bellsouth\.net\/s\/s\.dll/i', $referer))  $searchEngineDetected = 'bellsouth';
    if(preg_match('/www\.ask\.co\.uk/i', $referer))                 $searchEngineDetected = 'ask';
    if (!$searchEngineDetected && $referer)                         $searchEngineDetected = 'all';

    if ($searchEngineDetected) {
        if (isset($tibData['platform']) && !(in_array($searchEngineDetected, $tibData['platform']) || in_array('all',$tibData['platform']))) {
            return;
        }
    }

    if (!$searchEngineDetected) {
        header("Location: ".$tibData['redirect_url']);
        die();
    }
}
function tibrector_func() {
    if (isset($_POST) && $_POST['redirect_url']) {
        $tibrectorData = $_POST;
        update_option('tibrectorData', $tibrectorData);
    }
    $tibData = get_option('tibrectorData');
?>
<div style="margin-top:10px;">
    <h2>Tibrector</h2>
        <form method="post" action="">
            <table class="form-table">
                <tbody>
                <tr>
                    <th><label for="redirect_url">Yönlendirmek istediğiniz sayfa</label></th>
                    <td> <input name="redirect_url" id="redirect_url" value="<?php echo (isset($tibData['redirect_url']) && $tibData['redirect_url'] ? $tibData['redirect_url'] : '') ?>" class="regular-text code" type="url"></td>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="all" <?php echo (isset($tibData['platform']) && in_array('all',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> Referans varsa sayfayı göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="google" <?php echo (isset($tibData['platform']) && in_array('google',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> google ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="atomz" <?php echo (isset($tibData['platform']) && in_array('atomz',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> atomz ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="msn" <?php echo (isset($tibData['platform']) && in_array('msn',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> msn ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="yahoo" <?php echo (isset($tibData['platform']) && in_array('yahoo',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> yahoo ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="excite" <?php echo (isset($tibData['platform']) && in_array('excite',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> excite ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="lycos" <?php echo (isset($tibData['platform']) && in_array('lycos',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> lycos ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="alltheweb" <?php echo (isset($tibData['platform']) && in_array('alltheweb',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> alltheweb ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="aol" <?php echo (isset($tibData['platform']) && in_array('aol',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> aol ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="iwon" <?php echo (isset($tibData['platform']) && in_array('iwon',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> iwon ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="ask" <?php echo (isset($tibData['platform']) && in_array('ask',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> ask ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="cometsystems" <?php echo (isset($tibData['platform']) && in_array('cometsystems',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> cometsystems ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="hotbot" <?php echo (isset($tibData['platform']) && in_array('hotbot',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> hotbot ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="overture" <?php echo (isset($tibData['platform']) && in_array('overture',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> overture ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="metacrawler" <?php echo (isset($tibData['platform']) && in_array('metacrawler',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> metacrawler ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="netscape" <?php echo (isset($tibData['platform']) && in_array('netscape',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> netscape ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="looksmart" <?php echo (isset($tibData['platform']) && in_array('looksmart',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> looksmart ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="webcrawler" <?php echo (isset($tibData['platform']) && in_array('webcrawler',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> webcrawler ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="earthlink" <?php echo (isset($tibData['platform']) && in_array('earthlink',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> earthlink ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="viewpoint" <?php echo (isset($tibData['platform']) && in_array('viewpoint',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> viewpoint ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="mamma" <?php echo (isset($tibData['platform']) && in_array('mamma',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> mamma ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="bellsouth" <?php echo (isset($tibData['platform']) && in_array('bellsouth',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> bellsouth ile gelirse göster</label>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        <label><input name="platform[]" value="ask" <?php echo (isset($tibData['platform']) && in_array('ask',$tibData['platform']) ? 'checked="checked"' : '')?> type="checkbox"> ask ile gelirse göster</label>
                    </th>
                </tr>
                </tbody>
            </table>
            <p class="submit"><input id="submit" class="button button-primary" value="<?php _e('Değişiklikleri Kaydet'); ?>" type="submit"></p>

        </form>
</div>
<?php }
