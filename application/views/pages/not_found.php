<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<article class="sheet">
	<h1>Page not found</h1>
	<p>That address is not part of this site. Try the blur editor or the unblur editor.</p>
	<p>
		<a class="button" href="<?= html_escape(page_url('blur-image')) ?>">Blur image</a>
		<a class="button button-quiet" href="<?= html_escape(page_url('unblur-image')) ?>">Unblur image</a>
	</p>
</article>
