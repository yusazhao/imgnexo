<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<article class="sheet tool-page">
	<?php $this->load->view('partials/breadcrumbs', array('crumbs' => $crumbs)); ?>
	<h1><?= html_escape($page['h1']) ?></h1>
	<ul class="value-points">
		<li><svg viewBox="0 0 16 16" aria-hidden="true"><rect x="4.25" y="1.75" width="7.5" height="12.5" rx="1.6" fill="none" stroke="currentColor" stroke-width="1.4"/><path d="M7 12.15h2" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>No upload</li>
		<li><svg viewBox="0 0 16 16" aria-hidden="true"><rect x="1.75" y="2.75" width="12.5" height="10.5" rx="1.5" fill="none" stroke="currentColor" stroke-width="1.4"/><path d="M3.1 12.3 12.9 3.7" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>No watermarks</li>
		<li><svg viewBox="0 0 16 16" aria-hidden="true"><rect x="1.75" y="2.5" width="6.1" height="11" rx="1.1" fill="none" stroke="currentColor" stroke-width="1.4"/><rect x="6.7" y="5.15" width="7.55" height="5.7" rx="1.1" fill="none" stroke="currentColor" stroke-width="1.4"/></svg>Social sizes</li>
	</ul>

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
		<?php $this->load->view('partials/tool', array('tool' => $page['tool'])); ?>
	</section>
	<?php if ( ! empty($page['tool']['shortcuts'])): ?>
	<nav class="tool-links" aria-label="Common jobs">
		<p class="tool-links-title">Common jobs</p>
		<div class="tool-links-row">
			<?php foreach ($page['tool']['shortcuts'] as $link): ?>
			<a href="<?= html_escape(page_url($link['path'])) ?>"><?= html_escape($link['label']) ?></a>
			<?php endforeach; ?>
		</div>
	</nav>
	<?php endif; ?>
	<?php if ( ! empty($page['tool']['heading']) || ! empty($page['tool']['intro']) || ! empty($page['tool']['steps'])): ?>
	<section class="how-to">
		<?php if ( ! empty($page['tool']['heading'])): ?>
		<h2><?= html_escape($page['tool']['heading']) ?></h2>
		<?php endif; ?>
		<?php if ( ! empty($page['tool']['intro'])): ?>
		<div class="prose"><?= $page['tool']['intro'] ?></div>
		<?php endif; ?>
		<?php if ( ! empty($page['tool']['steps'])): ?>
		<ol class="steps">
			<?php foreach ($page['tool']['steps'] as $step): ?>
			<li><?= html_escape($step) ?></li>
			<?php endforeach; ?>
		</ol>
		<?php endif; ?>
	</section>
	<?php endif; ?>
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
