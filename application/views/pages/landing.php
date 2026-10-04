<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<article class="sheet">
	<?php $this->load->view('partials/breadcrumbs', array('crumbs' => $crumbs)); ?>
	<h1><?= html_escape($page['h1']) ?></h1>
	<div class="lead prose"><?= $page['lead'] ?></div>

	<?php if ( ! empty($page['figure'])): ?>
	<figure class="demo">
		<img src="<?= html_escape(asset_url($page['figure']['src'])) ?>" alt="<?= html_escape($page['figure']['alt']) ?>" width="960" height="540">
		<?php if ( ! empty($page['figure']['caption'])): ?>
		<figcaption><?= html_escape($page['figure']['caption']) ?></figcaption>
		<?php endif; ?>
	</figure>
	<?php endif; ?>

	<?php if ( ! empty($page['tool'])): ?>
	<section class="tool-block">
		<?php if ( ! empty($page['tool']['heading'])): ?>
		<h2><?= html_escape($page['tool']['heading']) ?></h2>
		<?php endif; ?>
		<?php if ( ! empty($page['tool']['intro'])): ?>
		<div class="prose"><?= $page['tool']['intro'] ?></div>
		<?php endif; ?>
		<?php $this->load->view('partials/tool', array('tool' => $page['tool'])); ?>
	</section>
	<?php endif; ?>

	<?php foreach ($page['sections'] as $section): ?>
	<section>
		<h2><?= html_escape($section['h2']) ?></h2>
		<div class="prose"><?= $section['html'] ?></div>
		<?php if ( ! empty($section['children'])): ?>
			<?php foreach ($section['children'] as $child): ?>
			<h3><?= html_escape($child['h3']) ?></h3>
			<div class="prose"><?= $child['html'] ?></div>
			<?php endforeach; ?>
		<?php endif; ?>
	</section>
	<?php endforeach; ?>

	<?php if ( ! empty($page['opposite'])): ?>
	<aside class="opposite">
		<p><?= html_escape($page['opposite']['text']) ?> <a href="<?= html_escape(page_url($page['opposite']['path'])) ?>"><?= html_escape($page['opposite']['label']) ?></a></p>
	</aside>
	<?php endif; ?>

	<?php if ( ! empty($page['related'])): ?>
	<section>
		<h2>Related guides</h2>
		<ul class="related">
			<?php foreach ($page['related'] as $link): ?>
			<li><a href="<?= html_escape(page_url($link['path'])) ?>"><?= html_escape($link['label']) ?></a></li>
			<?php endforeach; ?>
		</ul>
	</section>
	<?php endif; ?>

	<?php $this->load->view('partials/faq', array('faqs' => $faqs, 'faq_heading' => isset($page['faq_heading']) ? $page['faq_heading'] : 'Frequently Asked Questions')); ?>
</article>
