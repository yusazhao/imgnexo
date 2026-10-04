<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<article class="sheet">
	<?php $this->load->view('partials/breadcrumbs', array('crumbs' => $crumbs)); ?>
	<h1>Photo Blur Guides</h1>
	<p class="dek">Short tutorials for adding blur, hiding a face or some writing, and repairing a blurry photo. Each guide links back to the matching editor.</p>
	<ul class="post-list">
		<?php foreach ($posts as $post): ?>
		<li>
			<p class="post-date"><time datetime="<?= html_escape($post['date']) ?>"><?= html_escape(format_date($post['date'])) ?></time></p>
			<h2><a href="<?= html_escape(page_url($post['path'])) ?>"><?= html_escape($post['h1']) ?></a></h2>
			<p><?= html_escape($post['excerpt']) ?></p>
		</li>
		<?php endforeach; ?>
	</ul>
</article>
