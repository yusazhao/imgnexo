<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<article class="sheet missing">
	<h1>Page not found</h1>
	<p class="dek">That address is not part of this site. Start with a core editor, or open one of the tools below.</p>
	<p class="button-row missing-core">
		<a class="button" href="<?= html_escape(page_url('blur-image')) ?>">Blur image</a>
		<a class="button button-quiet" href="<?= html_escape(page_url('unblur-image')) ?>">Unblur image</a>
		<a class="button button-quiet" href="<?= html_escape(page_url()) ?>">Home</a>
	</p>

	<h2>Popular tools</h2>
	<p class="section-intro">Shortcuts for the most common blur and unblur jobs.</p>
	<div class="feature-grid missing-grid">
		<a class="feature" href="<?= html_escape(page_url('blur-image/background')) ?>">
			<span class="kicker">Background</span>
			<h3>Blur Photo Background</h3>
			<p>Soften the room or street behind a subject and leave the subject sharp.</p>
			<span class="feature-go">Open tool</span>
		</a>
		<a class="feature" href="<?= html_escape(page_url('blur-image/face')) ?>">
			<span class="kicker">Face</span>
			<h3>Blur Face In Photo</h3>
			<p>Cover people in a portrait or a group shot before you publish it.</p>
			<span class="feature-go">Open tool</span>
		</a>
		<a class="feature" href="<?= html_escape(page_url('blur-image/text')) ?>">
			<span class="kicker">Text</span>
			<h3>Blur Text Image</h3>
			<p>Cover writing, account numbers, or a chat screenshot in the photo.</p>
			<span class="feature-go">Open tool</span>
		</a>
		<a class="feature" href="<?= html_escape(page_url('blur-image/effect')) ?>">
			<span class="kicker">Effect</span>
			<h3>Blur Effects</h3>
			<p>Try Gaussian, Pixel, Motion, Radial, Noise, or Color blur one at a time.</p>
			<span class="feature-go">Open tool</span>
		</a>
		<a class="feature" href="<?= html_escape(page_url('unblur-image/motion-blur')) ?>">
			<span class="kicker">Motion</span>
			<h3>Fix Motion Blur Photo</h3>
			<p>Reduce directional streaks when the camera or subject moved a little.</p>
			<span class="feature-go">Open tool</span>
		</a>
		<a class="feature" href="<?= html_escape(page_url('blog')) ?>">
			<span class="kicker">Guides</span>
			<h3>Browse the Blog</h3>
			<p>Short how-tos for blurring, unblurring, and fixing soft phone photos.</p>
			<span class="feature-go">Read guides</span>
		</a>
	</div>
</article>
