<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<article class="sheet">
	<?php $this->load->view('partials/breadcrumbs', array('crumbs' => $crumbs)); ?>
	<h1><?= html_escape($page['h1']) ?></h1>
	<div class="prose"><?= $page['html'] ?></div>
</article>
