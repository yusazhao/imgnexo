<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
</main>
<footer class="site-footer">
	<div class="wrap footer-grid">
		<div>
			<strong>Imgnexo</strong>
			<p>Blur faces, text, and backgrounds in your browser, or sharpen a soft photo. Images stay on your device.</p>
		</div>
		<div>
			<strong>Add blur</strong>
			<ul>
				<li><a href="<?= html_escape(page_url('blur-image')) ?>">Blur image</a></li>
				<li><a href="<?= html_escape(page_url('blur-image/background')) ?>">Blur background of photo</a></li>
				<li><a href="<?= html_escape(page_url('blur-image/face')) ?>">Blur face in photo</a></li>
				<li><a href="<?= html_escape(page_url('blur-image/text')) ?>">Blur text image</a></li>
				<li><a href="<?= html_escape(page_url('blur-image/effect')) ?>">Gaussian blur</a></li>
			</ul>
		</div>
		<div>
			<strong>Remove blur</strong>
			<ul>
				<li><a href="<?= html_escape(page_url('unblur-image')) ?>">Unblur image</a></li>
				<li><a href="<?= html_escape(page_url('unblur-image/motion-blur')) ?>">Motion blur photo</a></li>
			</ul>
		</div>
		<div>
			<strong>Guides</strong>
			<ul>
				<li><a href="<?= html_escape(page_url('blog')) ?>">All guides</a></li>
				<li><a href="<?= html_escape(page_url('blog/how-to-make-picture-blurry')) ?>">Make a picture blurry</a></li>
				<li><a href="<?= html_escape(page_url('blog/how-to-remove-blur-from-photo')) ?>">Remove blur from photo</a></li>
				<li><a href="<?= html_escape(page_url('blog/how-to-fix-fuzzy-photos')) ?>">Fix fuzzy photos</a></li>
				<li><a href="<?= html_escape(page_url('blog/how-to-unblur-photos-on-iphone')) ?>">Unblur photos on iPhone</a></li>
			</ul>
		</div>
	</div>
	<?php
	$footer_email = 'support@imgnexo.com';
	if (file_exists(APPPATH.'config/site_info.php'))
	{
		$_footer_info = include APPPATH.'config/site_info.php';
		if (is_array($_footer_info) && ! empty($_footer_info['contact_email']))
		{
			$footer_email = $_footer_info['contact_email'];
		}
		unset($_footer_info);
	}
	?>
	<div class="wrap footer-legal-links">
		<p class="legal">
			Copyright <?= date('Y') ?> Imgnexo.
			<span class="legal-sep" aria-hidden="true">·</span>
			<a href="mailto:<?= html_escape($footer_email) ?>"><?= html_escape($footer_email) ?></a>
			<span class="legal-sep" aria-hidden="true">·</span>
			<a href="<?= html_escape(page_url('about-us')) ?>">About Us</a>
			<span class="legal-sep" aria-hidden="true">·</span>
			<a href="<?= html_escape(page_url('privacy-policy')) ?>">Privacy Policy</a>
			<span class="legal-sep" aria-hidden="true">·</span>
			<a href="<?= html_escape(page_url('terms-of-service')) ?>">Terms of Service</a>
			<span class="legal-sep" aria-hidden="true">·</span>
			<a href="<?= html_escape(page_url('contact')) ?>">Contact</a>
		</p>
	</div>
</footer>
<?php if ( ! empty($load_tool)): ?>
<script src="<?= html_escape(asset_url('js/tool.js')) ?>"></script>
<?php endif; ?>
</body>
</html>
