<?php
/*
**
**  jquery.kyco.easyshare
**  =====================
**
**  Version 1.3.3
**
**  Brought to you by
**  https://www.kycosoftware.com
**
**  Copyright 2015 Cornelius Weidmann
**
**  Distributed under the GPL
**
*/

header('Access-Control-Allow-Origin: *');

if (!empty($_SERVER['HTTP_REFERER'])) {
    define('SHARED_URL', $_GET['url']);
    define('FLAG_HTTP', $_GET['http'] == 'true' ? TRUE : FALSE);
    define('FLAG_HTTPS', $_GET['https'] == 'true' ? TRUE : FALSE);
    define('FACEBOOK_API_URL', 'https://graph.facebook.com/?ids=');
    define('GOOGLE_API_URL', 'https://plusone.google.com/_/+1/fastbutton?url=');
    define('LINKEDIN_API_URL', 'https://www.linkedin.com/countserv/count/share?url=');
    define('PINTEREST_API_URL', 'https://widgets.pinterest.com/v1/urls/count.json?callback=receiveCount&url=');
    define('XING_API_URL', 'https://www.xing-share.com/app/share?op=get_share_button;counter=top;lang=de;url=');

    if (filter_var(SHARED_URL, FILTER_VALIDATE_URL) === FALSE) {
        exit('There is nothing for you here... Seems like you supplied an invalid URL...');
    }

    function get_fb_shares_count($url)
    {
        $file_contents = @file_get_contents(FACEBOOK_API_URL . $url);
        $response = json_decode($file_contents, true);

        if (isset($response[$url]['share'])) {
            return intval($response[$url]['share']['share_count']);
        }

        return 0;
    }

    function get_plusone_count($url)
    {
        $file_contents = @file_get_contents(GOOGLE_API_URL . urlencode($url));
        preg_match('/window\.__SSR = {c: ([\d]+)/', $file_contents, $response);

        if (isset($response[0])) {
            $total = intval(str_replace('window.__SSR = {c: ', '', $response[0]));
            return $total;
        }

        return 0;
    }

    function get_linkedin_count($url = FALSE)
    {
        $file_contents = @file_get_contents(LINKEDIN_API_URL . urlencode($url) . '&format=json');
        $response = json_decode($file_contents, true);

        if (isset($response['count'])) {
            return intval($response['count']);
        }

        return 0;
    }

    function get_pinterest_count($url = FALSE)
    {
        $file_contents = @file_get_contents(PINTEREST_API_URL . urlencode($url));
        $file_contents = preg_replace('/^receiveCount\((.*)\)$/', '\\1', $file_contents);
        $response = json_decode($file_contents, true);

        if (isset($response['count'])) {
            return intval($response['count']);
        }

        return 0;
    }

    function get_xing_count($url = FALSE)
    {
        $file_contents = @file_get_contents(XING_API_URL . urlencode($url));
        preg_match('/<span class=\"xing-count top\">([\d]+)/', $file_contents, $response);

        if (isset($response[0])) {
            $total = $response[1];

            return $total;
        }

        return 0;
    }

    $counts = $_GET['counts'];
    $url_parts = parse_url(SHARED_URL);
    $http_url = '';
    $https_url = '';

    if ($url_parts['scheme'] == 'https') {
        $http_url = preg_replace('/^https:/i', 'http:', SHARED_URL);
        $https_url = SHARED_URL;
    } else {
        $http_url = SHARED_URL;
        $https_url = preg_replace('/^http:/i', 'https:', SHARED_URL);
    }

    if ((FLAG_HTTP && FLAG_HTTPS) || (!FLAG_HTTP && !FLAG_HTTPS)) {
        $fb_shares = $counts['facebook'] ? get_fb_shares_count(SHARED_URL) : 0;
        $plusones = $counts['google'] ? get_plusone_count(SHARED_URL) : 0;
        $linkedins = $counts['linkedin'] ? get_linkedin_count(SHARED_URL) : 0;
        $pins = $counts['pinterest'] ? get_pinterest_count(SHARED_URL) : 0;
        $xings = $counts['xing'] ? get_xing_count(SHARED_URL) : 0;
    } elseif (FLAG_HTTP) {
        $fb_shares = $counts['facebook'] ? get_fb_shares_count($http_url) : 0;
        $plusones = $counts['google'] ? get_plusone_count($http_url) : 0;
        $linkedins = $counts['linkedin'] ? get_linkedin_count($http_url) : 0;
        $pins = $counts['pinterest'] ? get_pinterest_count($http_url) : 0;
        $xings = $counts['xing'] ? get_xing_count($http_url) : 0;
    } else {
        $fb_shares = $counts['facebook'] ? get_fb_shares_count($https_url) : 0;
        $plusones = $counts['google'] ? get_plusone_count($https_url) : 0;
        $linkedins = $counts['linkedin'] ? get_linkedin_count($https_url) : 0;
        $pins = $counts['pinterest'] ? get_pinterest_count($https_url) : 0;
        $xings = $counts['xing'] ? get_xing_count($https_url) : 0;
    }

    $total = $fb_shares + $plusones + $linkedins + $pins + $xings;

    $response = array(
        'URL' => SHARED_URL,
        'Facebook' => $fb_shares,
        'Google' => $plusones,
        'Linkedin' => $linkedins,
        'Pinterest' => $pins,
        'Xing' => $xings,
        'Total' => $total
    );

    echo json_encode($response);
} else {
    // Request is not from a valid source...
    echo 'There is nothing for you here...';
}
?>
