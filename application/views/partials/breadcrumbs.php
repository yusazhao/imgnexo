<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (count($crumbs) > 1): ?>
<nav class="crumbs" aria-label="Breadcrumb">
	<ol>
		<?php foreach ($crumbs as $index => $crumb): ?>
		<li>
			<?php if ($index < count($crumbs) - 1): ?>
			<a href="<?= html_escape(page_url($crumb['path'])) ?>"><?= html_escape($crumb['name']) ?></a>
			<?php else: ?>
			<span aria-current="page"><?= html_escape($crumb['name']) ?></span>
			<?php endif; ?>
		</li>
		<?php endforeach; ?>
	</ol>
</nav>
<?php endif; ?>
