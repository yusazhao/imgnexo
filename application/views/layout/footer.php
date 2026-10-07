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
	<div class="wrap footer-legal-links">
		<p class="legal">
			Copyright <?= date('Y') ?> Imgnexo.
			<a href="<?= html_escape(page_url('about-us')) ?>">About Us</a>
			· <a href="<?= html_escape(page_url('privacy-policy')) ?>">Privacy Policy</a>
			· <a href="<?= html_escape(page_url('terms-of-service')) ?>">Terms of Service</a>
			· <a href="<?= html_escape(page_url('contact')) ?>">Contact</a>
		</p>
	</div>
</footer>
<?php if ( ! empty($load_tool)): ?>
<script src="<?= html_escape(asset_url('js/tool.js')) ?>"></script>
<?php endif; ?>
</body>
</html>
