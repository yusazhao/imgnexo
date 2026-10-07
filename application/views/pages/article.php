<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<article class="sheet">
	<?php $this->load->view('partials/breadcrumbs', array('crumbs' => $crumbs)); ?>
	<h1><?= html_escape($post['h1']) ?></h1>
	<p class="post-date"><time datetime="<?= html_escape($post['date']) ?>"><?= html_escape(format_date($post['date'])) ?></time></p>
	<div class="prose"><?= $post['html'] ?></div>
	<?php if ( ! empty($faqs)): ?>
	<section class="faq">
		<h2>FAQ</h2>
		<?php foreach ($faqs as $faq): ?>
		<details class="faq-item">
			<summary><h3><?= html_escape($faq['q']) ?></h3></summary>
			<div class="prose"><?= $faq['a'] ?></div>
		</details>
		<?php endforeach; ?>
	</section>
	<?php endif; ?>
</article>
