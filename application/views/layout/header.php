<?php defined('BASEPATH') OR exit('No direct script access allowed');
$graph = array();
$info = NULL;

if (file_exists(APPPATH.'config/site_info.php'))
{
	$info = include APPPATH.'config/site_info.php';
}

$brand = (is_array($info) && ! empty($info['brand'])) ? $info['brand'] : 'Imgnexo';
$org_id = canonical_url('').'#organization';
$website_id = canonical_url('').'#website';

if ( ! empty($crumbs))
{
	$items = array();
	$position = 1;

	foreach ($crumbs as $crumb)
	{
		$items[] = array(
			'@type' => 'ListItem',
			'position' => $position++,
			'name' => $crumb['name'],
			'item' => canonical_url($crumb['path']),
		);
	}

	$graph[] = array(
		'@type' => 'BreadcrumbList',
		'itemListElement' => $items,
	);
}

if ( ! empty($faqs))
{
	$entities = array();

	foreach ($faqs as $faq)
	{
		$entities[] = array(
			'@type' => 'Question',
			'name' => $faq['q'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text' => trim(html_entity_decode(strip_tags($faq['a']), ENT_QUOTES, 'UTF-8')),
			),
		);
	}

	$graph[] = array(
		'@type' => 'FAQPage',
		'mainEntity' => $entities,
	);
}

if ( ! empty($schema_home))
{
	$org = array(
		'@type' => 'Organization',
		'@id' => $org_id,
		'name' => $brand,
		'url' => canonical_url(''),
		'description' => 'Free browser tools to blur or unblur photos. Image edits run on your device. More utilities may be added over time.',
	);

	if (is_array($info) && ! empty($info['operator_name']))
	{
		$org['legalName'] = $info['operator_name'];
	}

	if (is_array($info) && ! empty($info['contact_email']))
	{
		$org['email'] = $info['contact_email'];
	}

	$graph[] = $org;

	$graph[] = array(
		'@type' => 'WebSite',
		'@id' => $website_id,
		'name' => $brand,
		'url' => canonical_url(''),
		'description' => isset($meta['description']) ? $meta['description'] : '',
		'publisher' => array('@id' => $org_id),
		'inLanguage' => 'en',
	);

	$list_items = array();
	$position = 1;

	if ( ! empty($collection_items) && is_array($collection_items))
	{
		foreach ($collection_items as $item)
		{
			$list_items[] = array(
				'@type' => 'ListItem',
				'position' => $position++,
				'name' => $item['name'],
				'url' => canonical_url($item['path']),
				'description' => isset($item['description']) ? $item['description'] : '',
				'item' => array(
					'@type' => 'WebApplication',
					'name' => $item['name'],
					'url' => canonical_url($item['path']),
					'description' => isset($item['description']) ? $item['description'] : '',
					'applicationCategory' => 'MultimediaApplication',
					'operatingSystem' => 'Any',
					'offers' => array(
						'@type' => 'Offer',
						'price' => '0',
						'priceCurrency' => 'USD',
					),
				),
			);
		}
	}

	$graph[] = array(
		'@type' => 'CollectionPage',
		'@id' => canonical_url('').'#collection',
		'name' => isset($meta['title']) ? $meta['title'] : $brand,
		'description' => isset($meta['description']) ? $meta['description'] : '',
		'url' => canonical_url(''),
		'isPartOf' => array('@id' => $website_id),
		'about' => array('@id' => $org_id),
		'mainEntity' => array(
			'@type' => 'ItemList',
			'name' => 'Imgnexo browser tools',
			'numberOfItems' => count($list_items),
			'itemListElement' => $list_items,
		),
	);
}

if ( ! empty($schema_blog))
{
	$list_items = array();
	$position = 1;

	if ( ! empty($collection_items) && is_array($collection_items))
	{
		foreach ($collection_items as $item)
		{
			$entry = array(
				'@type' => 'ListItem',
				'position' => $position++,
				'name' => $item['name'],
				'url' => canonical_url($item['path']),
				'item' => array(
					'@type' => 'BlogPosting',
					'headline' => $item['name'],
					'url' => canonical_url($item['path']),
					'description' => isset($item['description']) ? $item['description'] : '',
				),
			);

			if ( ! empty($item['date']))
			{
				$entry['item']['datePublished'] = $item['date'];
			}

			$list_items[] = $entry;
		}
	}

	$graph[] = array(
		'@type' => 'CollectionPage',
		'@id' => canonical_url('blog').'#collection',
		'name' => 'Photo Blur Guides',
		'description' => isset($meta['description']) ? $meta['description'] : '',
		'url' => canonical_url('blog'),
		'mainEntity' => array(
			'@type' => 'ItemList',
			'name' => 'Photo blur and unblur guides',
			'numberOfItems' => count($list_items),
			'itemListElement' => $list_items,
		),
	);
}

if ( ! empty($schema_webapp) && ! empty($page) && is_array($page))
{
	$app = array(
		'@type' => 'WebApplication',
		'@id' => canonical_url($page['path']).'#app',
		'name' => $page['h1'],
		'url' => canonical_url($page['path']),
		'description' => $page['description'],
		'applicationCategory' => 'MultimediaApplication',
		'operatingSystem' => 'Any',
		'browserRequirements' => 'Requires JavaScript. Runs in a modern browser.',
		'offers' => array(
			'@type' => 'Offer',
			'price' => '0',
			'priceCurrency' => 'USD',
		),
		'isAccessibleForFree' => TRUE,
		'inLanguage' => 'en',
	);

	if (count($page['crumbs']) > 2)
	{
		$parent = $page['crumbs'][count($page['crumbs']) - 2];
		$app['isPartOf'] = array(
			'@type' => 'WebApplication',
			'name' => $parent['name'],
			'url' => canonical_url($parent['path']),
		);
	}

	$graph[] = $app;
}

if ( ! empty($post) && is_array($post))
{
	$graph[] = array(
		'@type' => 'Article',
		'headline' => $post['h1'],
		'description' => $post['description'],
		'datePublished' => $post['date'],
		'dateModified' => $post['date'],
		'mainEntityOfPage' => array(
			'@type' => 'WebPage',
			'@id' => canonical_url($post['path']),
		),
		'author' => array(
			'@type' => 'Organization',
			'name' => $brand,
		),
		'publisher' => array(
			'@type' => 'Organization',
			'name' => $brand,
			'url' => canonical_url(''),
		),
	);
}

if ( ! empty($organization) && is_array($organization))
{
	if (empty($organization['@id']))
	{
		$organization['@id'] = $org_id;
	}

	$graph[] = $organization;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= html_escape($meta['title']) ?></title>
	<meta name="description" content="<?= html_escape($meta['description']) ?>">
	<?php if ( ! empty($meta['robots'])): ?>
	<meta name="robots" content="<?= html_escape($meta['robots']) ?>">
	<?php endif; ?>
	<?php if (empty($meta['robots'])): ?>
	<link rel="canonical" href="<?= html_escape(canonical_url($meta['path'])) ?>">
	<?php endif; ?>
	<meta property="og:title" content="<?= html_escape($meta['title']) ?>">
	<meta property="og:description" content="<?= html_escape($meta['description']) ?>">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?= html_escape(canonical_url($meta['path'])) ?>">
	<link rel="icon" href="<?= html_escape(asset_url('favicon.svg')) ?>" type="image/svg+xml">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=optional">
	<link rel="stylesheet" href="<?= html_escape(asset_url('css/site.css')) ?>">
	<?php if ($graph): ?>
	<script type="application/ld+json"><?= json_encode(array('@context' => 'https://schema.org', '@graph' => $graph), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
	<?php endif; ?>
</head>
<body class="theme-<?= html_escape($nav) ?>">
<a class="skip" href="#content">Skip to content</a>
<header class="site-header">
	<div class="wrap header-bar">
		<a class="logo" href="<?= html_escape(page_url('')) ?>">
			<span class="logo-mark" aria-hidden="true"><svg viewBox="0 0 36 36"><circle cx="14" cy="24" r="6.2" fill="#fff" opacity=".42"/><circle cx="20" cy="17.5" r="4.5" fill="#fff" opacity=".72"/><circle cx="25.5" cy="12" r="2.9" fill="#fff"/></svg></span>
			<span class="logo-text"><strong>Imgnexo</strong><small>Online</small></span>
		</a>
		<nav class="site-nav" aria-label="Primary">
			<a href="<?= html_escape(page_url('blur-image')) ?>"<?= nav_is_current('blur-image') ? ' aria-current="page"' : '' ?>>Blur Image</a>
			<a class="nav-wide" href="<?= html_escape(page_url('blur-image/background')) ?>"<?= nav_is_current('blur-image/background') ? ' aria-current="page"' : '' ?>>Blur Background</a>
			<a class="nav-wide" href="<?= html_escape(page_url('blur-image/face')) ?>"<?= nav_is_current('blur-image/face') ? ' aria-current="page"' : '' ?>>Blur Face</a>
			<a class="nav-wide" href="<?= html_escape(page_url('blur-image/text')) ?>"<?= nav_is_current('blur-image/text') ? ' aria-current="page"' : '' ?>>Blur Text</a>
			<a class="nav-wide" href="<?= html_escape(page_url('blur-image/effect')) ?>"<?= nav_is_current('blur-image/effect') ? ' aria-current="page"' : '' ?>>Blur Effects</a>
			<a href="<?= html_escape(page_url('unblur-image')) ?>"<?= nav_is_current('unblur-image') ? ' aria-current="page"' : '' ?>>Unblur</a>
			<a class="nav-wide" href="<?= html_escape(page_url('unblur-image/motion-blur')) ?>"<?= nav_is_current('unblur-image/motion-blur') ? ' aria-current="page"' : '' ?>>Motion Blur</a>
			<details class="menu">
				<summary>Tools</summary>
				<div class="menu-panel">
					<a href="<?= html_escape(page_url('blur-image/background')) ?>"<?= nav_is_current('blur-image/background') ? ' aria-current="page"' : '' ?>>Blur Background</a>
					<a href="<?= html_escape(page_url('blur-image/face')) ?>"<?= nav_is_current('blur-image/face') ? ' aria-current="page"' : '' ?>>Blur Face</a>
					<a href="<?= html_escape(page_url('blur-image/text')) ?>"<?= nav_is_current('blur-image/text') ? ' aria-current="page"' : '' ?>>Blur Text</a>
					<a href="<?= html_escape(page_url('blur-image/effect')) ?>"<?= nav_is_current('blur-image/effect') ? ' aria-current="page"' : '' ?>>Blur Effects</a>
					<a href="<?= html_escape(page_url('unblur-image/motion-blur')) ?>"<?= nav_is_current('unblur-image/motion-blur') ? ' aria-current="page"' : '' ?>>Motion Blur</a>
				</div>
			</details>
			<a href="<?= html_escape(page_url('blog')) ?>"<?= nav_is_current('blog') ? ' aria-current="page"' : '' ?>>Blog</a>
		</nav>
	</div>
</header>
<main id="content">
