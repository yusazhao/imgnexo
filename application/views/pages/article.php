<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<article class="sheet">
	<?php $this->load->view('partials/breadcrumbs', array('crumbs' => $crumbs)); ?>
	<h1><?= html_escape($post['h1']) ?></h1>
	<p class="post-date"><time datetime="<?= html_escape($post['date']) ?>"><?= html_escape(format_date($post['date'])) ?></time></p>
	<div class="prose"><?= $post['html'] ?></div>
</article>
