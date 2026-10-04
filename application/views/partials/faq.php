<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if ( ! empty($faqs)): ?>
<section class="faq">
	<h2><?= html_escape(isset($faq_heading) ? $faq_heading : 'Frequently Asked Questions') ?></h2>
	<?php foreach ($faqs as $faq): ?>
	<details class="faq-item">
		<summary><h3><?= html_escape($faq['q']) ?></h3></summary>
		<div class="prose"><?= $faq['a'] ?></div>
	</details>
	<?php endforeach; ?>
</section>
<?php endif; ?>
