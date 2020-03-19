-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 28, 2018 at 10:17 PM
-- Server version: 5.7.24-0ubuntu0.18.04.1
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `commentable_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `commentable_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `commented_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `commented_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '1',
  `rate` double(15,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `anonymous_username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `love_likes`
--

CREATE TABLE `love_likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `likeable_id` int(10) UNSIGNED NOT NULL,
  `likeable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `type_id` enum('LIKE','DISLIKE') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'LIKE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `love_like_counters`
--

CREATE TABLE `love_like_counters` (
  `id` int(10) UNSIGNED NOT NULL,
  `likeable_id` int(10) UNSIGNED NOT NULL,
  `likeable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type_id` enum('LIKE','DISLIKE') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'LIKE',
  `count` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `parent_id`, `order`, `name`, `url`, `type`, `created_at`, `updated_at`) VALUES
(3, NULL, 1, 'Home', '/', 'none', '2019-01-06 01:52:06', '2019-01-08 12:09:07'),
(4, NULL, 6, 'Pages', '/pages', 'none', '2019-01-06 02:33:01', '2019-01-31 13:57:16'),
(5, 4, 7, 'F.A.Q.s', '/page/faq', 'none', '2019-01-07 16:26:13', '2019-01-31 13:57:16'),
(11, NULL, 4, 'Videos', '', 'videos', '2019-01-11 00:14:53', '2019-01-31 13:57:16'),
(12, NULL, 5, 'Posts', '', 'posts', '2019-01-11 00:16:26', '2019-01-31 13:57:16');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0000_00_00_000000_create_comments_table', 1),
(2, '2018_07_30_100604_create_subscription_table', 2),
(3, '2018_07_31_203252_video_categories_table', 3),
(4, '2016_09_02_153301_create_love_likes_table', 4),
(5, '2016_09_02_163301_create_love_like_counters_table', 4),
(6, '2018_08_09_124219_create_jobs_table', 5),
(10, '2018_08_09_132855_create_video_converteds_table', 6),
(12, '2018_08_15_194157_create_failed_jobs_table', 8),
(14, '2018_08_16_085703_create_videos_table', 9),
(15, '2018_08_29_125959_add_locale_to_settings_table', 10),
(16, '2018_09_11_160043_add_max_height_to_videos_table', 11),
(17, '2018_09_17_152233_add_comments_settings_settings_table', 12),
(18, '2018_09_19_094823_add_anonymous_username_comments', 12),
(19, '2018_10_07_091512_add_index_to_tag_video_table', 13),
(20, '2018_10_24_154812_create_sessions_table', 14),
(21, '2018_10_30_132639_add_parent_id_comments', 14),
(22, '2018_11_22_162310_add_social_websites', 15),
(23, '2017_00_00_000001_create_seo_metas_table', 16),
(24, '2017_00_00_000002_create_seo_redirects_table', 16);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `user_id`, `title`, `slug`, `body`, `active`, `created_at`, `updated_at`) VALUES
(1, 1, 'VMS - Video Content Management platform', 'faq', '<p><strong>VMS</strong> is your Video Subscription Platform. The easiest way to create your own video sharing platform. Add unlimited videos, posts, and pages to your subscription site. Earn re-curring revenue and require users to subscribe to access premium content on your website.</p><p>&nbsp;<img title="VMS - Video Content Management platform" src="https://lp.noxls.net/wp-content/uploads/2018/12/vms-responsive.png" alt="" width="1000" height="506" /></p><h1>VMS Overview</h1><ol><li><strong>Easy to monetize.</strong> All options to monetize your video content - ready integration with Google Ads, in-video overlay ads, subscription model.</li><li><strong>Fully customizable.</strong> More that 200 parameters to configure your platform, not including content itself. If it&apos;s not enough - develop your own plugins and themes!</li><li><strong>Add unlimited videos to your platform.</strong> Setup VMS Platform on your servers and forget about limitations. Now you have full control and easy tools to manage content of your website. Build your own media sharing platform.</li><li><strong>Accept payments to monetize.</strong> VMS Video integrated with Stripe to allow you accept re-current subscription payments from your users.</li><li><strong>Custom Pages and Posts in website Blog.</strong> Blog is integral part of any serious website in nowaday world. Update clients with most recent news of your company and stories about your product. Your Blog is powerful SEO tool. Search Engines loves content, generate it as many as you can</li><li><strong>Advanced content management with categories.</strong> Organize content of your platform in the best possible way. Custom categories tree available for videos and blog posts. Each of your category, video and post has advanced SEO setting to make sure Search Engines love content of your platform More than 100 properties available for customization of your platform, including configurations like website name and logo. Sophisticated tool to moderate user comments</li></ol><p><img title="VMS - Video Content Management platform" src="https://lp.noxls.net/wp-content/uploads/2018/12/VMS-Demo-Video-Content-Management-platform-2018-12-30-12-36-13.png" alt="" width="1000" height="981" /></p><h2>"It was a pleasure to work with VMS Platform..."</h2><blockquote>For years we used self-developed media platform for our project, so we have much experience in this area. I can say that VMS Platform is really mature. In 5 years we didn&apos;t develop even half of features available in VMS Platform. It&apos;s right choice if you are looking for video/blog framework - VMS is quite mature to beat any solution on the market.</blockquote><h3>With VMS platform you can</h3><ul><li><strong>Upload videos</strong> in convenient way - from your computer, with download assistances, direct url</li><li><strong>Customizable Video Player</strong> integrated with ads services.</li><li><strong>Extended API</strong> to integrate VMS platform with your CRM or any other platform?</li></ul><p>&nbsp;</p>', 1, '2019-01-10 01:47:27', '2018-02-05 12:05:39');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_settings`
--

CREATE TABLE `payment_settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `live_mode` tinyint(1) NOT NULL DEFAULT '0',
  `test_secret_key` varchar(100) NOT NULL DEFAULT '',
  `test_publishable_key` varchar(100) NOT NULL DEFAULT '',
  `live_secret_key` varchar(100) NOT NULL DEFAULT '',
  `live_publishable_key` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `payment_settings` (`id`, `live_mode`, `test_secret_key`, `test_publishable_key`, `live_secret_key`, `live_publishable_key`) VALUES (1, 0, 'sk_test_Xlj8AVMmjHWRkKMbkNp64fBh', 'pk_test_UMpELe4zCMeUjdb4ej37opoX', '', '');


-- --------------------------------------------------------

--
-- Table structure for table `plugins`
--

CREATE TABLE `plugins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `plugins`
--

INSERT INTO `plugins` (`id`, `name`, `description`, `version`, `slug`, `active`, `created_at`, `updated_at`) VALUES
(3, 'Hi, VMS', 'This is an example plugin for VMS', '1.0', 'hello', 0, '2018-06-12 00:50:47', '2018-06-12 00:50:47');

-- --------------------------------------------------------

--
-- Table structure for table `plugin_data`
--

CREATE TABLE `plugin_data` (
  `id` int(10) UNSIGNED NOT NULL,
  `plugin_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `plugin_data`
--

INSERT INTO `plugin_data` (`id`, `plugin_slug`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'hello', 'value1', 'asdfasdf', '2018-06-12 00:57:47', '2018-06-12 01:02:47'),
(2, 'hello', '_token', 'm2CP6Lp6rXfQZLxcFkTZSEwqnwMDDszJzYEvsEGd', '2018-06-12 00:57:47', '2018-06-12 00:57:47'),
(3, 'hello', 'value2', 'testval212312312f', '2018-06-12 19:01:02', '2018-06-12 19:01:51');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) UNSIGNED NOT NULL,
  `post_category_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `body` mediumtext NOT NULL,
  `body_guest` mediumtext,
  `access` varchar(20) NOT NULL DEFAULT 'guest',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post_categories`
--

CREATE TABLE `post_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `post_categories`
--

INSERT INTO `post_categories` (`id`, `parent_id`, `order`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(6, NULL, 1, 'Example Category 1', 'example-category-1', '2019-01-03 23:15:33', '2018-02-05 12:08:36'),
(7, NULL, 3, 'Example Category 2', 'example-category-2', '2019-01-03 23:16:27', '2018-02-05 12:08:33'),
(8, 6, 2, 'Example Sub-category 1', 'example-sub-category-1', '2019-01-03 23:16:42', '2018-02-05 12:08:36');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `website_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'VMS',
  `website_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Your Premium Video CMS',
  `logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'logo.png',
  `favicon` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'favicon.png',
  `system_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'email@domain.com',
  `demo_mode` tinyint(1) NOT NULL DEFAULT 0,
  `enable_https` tinyint(1) NOT NULL DEFAULT 0,
  `theme` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  `facebook_page_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `google_page_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter_page_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `youtube_page_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `google_tracking_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_tag_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_oauth_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `videos_per_page` int(11) NOT NULL DEFAULT 12,
  `posts_per_page` int(11) NOT NULL DEFAULT 12,
  `free_registration` tinyint(1) NOT NULL DEFAULT 0,
  `activation_email` tinyint(1) NOT NULL DEFAULT 0,
  `premium_upgrade` tinyint(1) NOT NULL DEFAULT 1,
  `locale` char(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enable_video_comments` tinyint(4) NOT NULL DEFAULT 1,
  `enable_post_comments` tinyint(4) NOT NULL DEFAULT 1,
  `video_comments_per_page` int(11) NOT NULL DEFAULT 10,
  `post_comments_per_page` int(11) NOT NULL DEFAULT 10,
  `enable_anonymous_comments` tinyint(4) NOT NULL DEFAULT 1,
  `enable_google_captcha_comments` tinyint(4) NOT NULL DEFAULT 0,
  `instagram_page_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vimeo_page_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `website_name`, `website_description`, `logo`, `favicon`, `system_email`, `demo_mode`, `enable_https`, `theme`, `facebook_page_id`, `google_page_id`, `twitter_page_id`, `youtube_page_id`, `google_tracking_id`, `google_tag_id`, `google_oauth_key`, `created_at`, `updated_at`, `videos_per_page`, `posts_per_page`, `free_registration`, `activation_email`, `premium_upgrade`, `locale`, `enable_video_comments`, `enable_post_comments`, `video_comments_per_page`, `post_comments_per_page`, `enable_anonymous_comments`, `enable_google_captcha_comments`, `instagram_page_id`, `vimeo_page_id`) VALUES
(1, 'VMS', 'Your Online Video Subscription Platform', '', '', 'admin@admin.com', 1, 0, 'default', 'vms-app', 'vms-app', 'vms-app', '', 'UA-1398385-23', 'GTM-58NHVD8', '', '0000-00-00 00:00:00', '2019-09-08 20:19:19', 12, 12, 1, 0, 1, 'en_US', 1, 1, 10, 10, 1, 0, '', '');


-- --------------------------------------------------------

--
-- Table structure for table `seo_metas`
--

CREATE TABLE `seo_metas` (
  `id` int(10) UNSIGNED NOT NULL,
  `seoable_id` int(10) UNSIGNED NOT NULL,
  `seoable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `noindex` tinyint(1) NOT NULL DEFAULT '0',
  `extras` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seo_redirects`
--

CREATE TABLE `seo_redirects` (
  `id` int(10) UNSIGNED NOT NULL,
  `old_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `new_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8_unicode_ci,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_plan` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tag_video`
--

CREATE TABLE `tag_video` (
  `id` int(10) UNSIGNED NOT NULL,
  `video_id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `description`, `version`, `slug`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Default Theme', 'This is the theme for Premium Video CMS - VMS. It is a clean and responsive template for any type of video website.', '1.0', 'default', 1, '2019-01-03 23:10:21', '2019-01-03 23:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `theme_settings`
--

CREATE TABLE `theme_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `theme_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Dumping data for table `theme_settings`
--

INSERT INTO `theme_settings` (`id`, `theme_slug`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'system', 'settings', '{\"locale\":\"en_US\",\"website_name\":\"VMS\",\"website_description\":\"Your Premium Video VMS\",\"enable_video_comments\":\"1\",\"video_comments_per_page\":\"10\",\"enable_post_comments\":\"1\",\"post_comments_per_page\":\"10\",\"videos_per_page\":\"12\",\"posts_per_page\":\"12\",\"free_registration\":\"1\",\"activation_email\":\"0\",\"premium_upgrade\":\"0\",\"system_email\":\"mail@noxls.net\",\"mail_host\":\"\",\"mail_port\":\"587\",\"mail_username\":\"\",\"mail_password\":\"\",\"webmasters_google\":\"\",\"webmasters_bing\":\"\",\"webmasters_alexa\":\"\",\"webmasters_yandex\":\"\",\"facebook_page_id\":\"\",\"google_page_id\":\"\",\"twitter_page_id\":\"\",\"youtube_page_id\":\"\",\"instagram_page_id\":\"\",\"vimeo_page_id\":\"\",\"google_tracking_id\":\"\",\"google_tag_id\":\"\",\"google_oauth_key\":\"\",\"_token\":\"\",\"demo_mode\":0,\"enable_https\":0,\"logo\":\"\",\"favicon\":\"\",\"theme\":\"default\"}', '2019-04-17 13:06:20', '2019-04-22 12:52:16');
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'subscriber',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `stripe_active` tinyint(4) NOT NULL DEFAULT '0',
  `stripe_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_subscription` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_plan` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_four` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `subscription_ends_at` timestamp NULL DEFAULT NULL,
  `card_brand` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `avatar`, `password`, `role`, `active`, `created_at`, `updated_at`, `activation_code`, `remember_token`, `stripe_active`, `stripe_id`, `stripe_subscription`, `stripe_plan`, `last_four`, `trial_ends_at`, `subscription_ends_at`, `card_brand`, `card_last_four`) VALUES
(1, 'admin', 'admin@admin.com', '', '$2y$10$dOdZKtH3TZI8/fUt6DJoIuZ0gpTY8on8InOnlkwrqszpM0xA1Jwa6', 'admin', 1, '2014-08-26 20:43:33', '2018-12-07 20:26:41', NULL, 'FrRbUapIuNs0VA03wIdBvA9XR7diYip7ckfpVpIsmuy0SgM2vpcr2knZgQS9', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'demo', 'demo@demo.com', '539183.jpg', '$2y$10$ltJIM5z0dHJalcAYIS5OduHzsmVEGO9rhaSStTu8fBdZPTw82BhVK', 'admin', 1, '2014-12-21 17:26:04', '2018-09-04 16:05:36', NULL, '7Xi5xmjdFcw1Cx6yPLZYXQanylgKJa6uQWZU0xExdJJAQxMtvxiKDnMdUuaL', 0, 'cus_DXThRRC9OpJSFj', NULL, NULL, NULL, NULL, NULL, 'Visa', '4242'),
(3, 'anonymous', '', 'default.jpg', '', 'subscriber', 1, '2018-10-05 21:00:00', '2018-10-05 21:00:00', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `video_category_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `access` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'guest',
  `details` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `featured` tinyint(4) NOT NULL DEFAULT '0',
  `duration` int(11) DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `embed_code` text COLLATE utf8_unicode_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mime_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `process_status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `max_height` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_categories`
--

CREATE TABLE `video_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `thumb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `video_categories`
--

INSERT INTO `video_categories` (`id`, `parent_id`, `order`, `name`, `slug`, `created_at`, `updated_at`, `thumb`) VALUES
(11, NULL, 1, 'Animation', 'animation', '2019-01-11 03:32:27', '2018-08-17 08:50:28', 'animation-image.jpg'),
(13, NULL, 3, 'Sports', 'sports', '2019-01-30 14:34:33', '2018-08-17 08:41:44', 'sport.png'),
(14, 19, 10, 'Trailers', 'trailers', '2019-01-30 14:34:50', '2018-08-17 08:42:52', 'movie-trailer-nollyconnect-1132x509.jpg'),
(15, NULL, 4, 'Comedy', 'comedy', '2018-02-04 12:16:23', '2018-08-17 08:44:54', 'comedy.jpg'),
(17, 23, 6, 'How-to & DIY', 'how-to-diy', '2018-02-04 12:21:14', '2018-08-17 08:45:31', 'how-to.png'),
(18, NULL, 8, 'Tech', 'tech', '2018-02-04 12:21:40', '2018-08-17 08:46:09', 'tech.jpg'),
(19, NULL, 9, 'Movies', 'movies', '2018-02-04 12:22:07', '2018-08-17 08:46:46', 'movies.jpeg'),
(20, NULL, 11, 'TV Shows', 'tv-shows', '2018-02-04 12:22:15', '2018-08-17 08:47:36', 'tv-shows.jpg'),
(21, NULL, 2, 'Education', 'education', '2018-02-04 12:23:03', '2018-08-17 08:40:53', 'coe_hp_new.png'),
(22, 23, 7, 'Cooking & Health', 'cooking-and-health', '2018-02-04 12:23:42', '2018-08-17 08:49:36', 'Cooking-family.jpg'),
(23, NULL, 5, 'Lifestyle', 'lifestyle', '2018-02-04 12:25:37', '2018-08-17 08:48:30', 'lifestyle.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_commentable_id_commentable_type_index` (`commentable_id`,`commentable_type`),
  ADD KEY `comments_commented_id_commented_type_index` (`commented_id`,`commented_type`),
  ADD KEY `comments_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `love_likes`
--
ALTER TABLE `love_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `like_user_unique` (`likeable_id`,`likeable_type`,`user_id`),
  ADD KEY `love_likes_likeable_id_likeable_type_index` (`likeable_id`,`likeable_type`),
  ADD KEY `love_likes_user_id_index` (`user_id`);

--
-- Indexes for table `love_like_counters`
--
ALTER TABLE `love_like_counters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `like_counter_unique` (`likeable_id`,`likeable_type`,`type_id`),
  ADD KEY `love_like_counters_likeable_id_likeable_type_index` (`likeable_id`,`likeable_type`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_settings`
--
ALTER TABLE `payment_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plugins`
--
ALTER TABLE `plugins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plugin_data`
--
ALTER TABLE `plugin_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seo_metas`
--
ALTER TABLE `seo_metas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seo_metas_seoable_id_seoable_type_index` (`seoable_id`,`seoable_type`);

--
-- Indexes for table `seo_redirects`
--
ALTER TABLE `seo_redirects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seo_redirects_old_url_unique` (`old_url`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_name_unique` (`name`);

--
-- Indexes for table `tag_video`
--
ALTER TABLE `tag_video`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag_video_video_id_tag_id_unique` (`video_id`,`tag_id`),
  ADD KEY `tag_video_video_id_index` (`video_id`),
  ADD KEY `tag_video_tag_id_index` (`tag_id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theme_settings`
--
ALTER TABLE `theme_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique` (`username`),
  ADD KEY `uniuqe_email` (`email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_categories`
--
ALTER TABLE `video_categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `love_likes`
--
ALTER TABLE `love_likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `love_like_counters`
--
ALTER TABLE `love_like_counters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `payment_settings`
--
ALTER TABLE `payment_settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `plugins`
--
ALTER TABLE `plugins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `plugin_data`
--
ALTER TABLE `plugin_data`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `post_categories`
--
ALTER TABLE `post_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `seo_metas`
--
ALTER TABLE `seo_metas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `seo_redirects`
--
ALTER TABLE `seo_redirects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;
--
-- AUTO_INCREMENT for table `tag_video`
--
ALTER TABLE `tag_video`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;
--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `theme_settings`
--
ALTER TABLE `theme_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT for table `video_categories`
--
ALTER TABLE `video_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`);

--
-- Constraints for table `tag_video`
--
ALTER TABLE `tag_video`
  ADD CONSTRAINT `tag_video_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tag_video_video_id_foreign` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE;


  --
-- Table structure for table `allowed_mimes`
--

CREATE TABLE `allowed_mimes` (
  `id` int(10) UNSIGNED NOT NULL,
  `mime` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `extension` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `allowed_mimes`
--

INSERT INTO `allowed_mimes` (`id`, `mime`, `extension`, `type`, `active`) VALUES
(1, 'application/vnd.apple.mpegurl', 'm3u', 'video', 1),
(2, 'application/x-mpegurl', 'm3u', 'video', 1),
(3, 'video/3gpp', '3gp', 'video', 1),
(4, 'video/mp4', 'mp4', 'video', 1),
(5, 'video/mpeg', 'm1v', 'video', 1),
(6, 'video/ogg', 'ogg', 'video', 1),
(7, 'video/quicktime', 'mov', 'video', 1),
(8, 'video/webm', 'm4v', 'video', 1),
(9, 'video/x-m4v', 'm3u', 'video', 1),
(10, 'video/ms-asf', 'asf', 'video', 1),
(11, 'video/x-ms-wmv', 'wmv', 'video', 1),
(12, 'video/x-msvideo', 'avi', 'video', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allowed_mimes`
--
ALTER TABLE `allowed_mimes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allowed_mimes`
--
ALTER TABLE `allowed_mimes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
