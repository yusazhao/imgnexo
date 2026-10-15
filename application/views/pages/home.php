<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<article class="sheet home">
	<section class="home-intro">
		<h1>Free Online Image Utilities &amp; Photo Tools | ImgNexo</h1>
		<p class="dek">Free browser tools to add blur or clear a mildly soft photo. No account, no install, and the image stays on this device.</p>
		<div class="home-actions">
			<a class="button" href="<?= html_escape(page_url('blur-image')) ?>">Blur an image</a>
			<a class="button button-quiet" href="<?= html_escape(page_url('unblur-image')) ?>">Fix a blurry photo</a>
		</div>
	</section>

	<section class="home-categories">
		<h2>Explore Photo Tool Categories</h2>
		<p class="section-intro">Start with a category when you are not sure which page to open. Each card links to the main tool for that job, plus shortcuts for common tasks. New categories can sit beside these as the suite grows—blur and unblur are only the first two.</p>
		<div class="category-grid">
			<article class="category-card">
				<figure class="category-art" aria-label="The same photo of two people, then with the background and one face blurred">
					<svg viewBox="0 0 640 220" role="img" aria-hidden="true">
						<rect width="640" height="220" rx="18" fill="#f8fafc"/>
						<defs>
							<filter id="add-blur-bg"><feGaussianBlur stdDeviation="5"/></filter>
							<clipPath id="add-blur-left"><rect x="16" y="12" width="296" height="168" rx="14"/></clipPath>
							<clipPath id="add-blur-right"><rect x="328" y="12" width="296" height="168" rx="14"/></clipPath>
							<clipPath id="add-blur-pix"><circle cx="520" cy="86" r="24"/></clipPath>
						</defs>
						<g clip-path="url(#add-blur-left)">
							<rect x="16" y="12" width="296" height="168" fill="#e0f2fe"/>
							<rect x="36" y="28" width="78" height="50" rx="6" fill="#93c5fd" stroke="#ffffff" stroke-width="4"/>
							<rect x="16" y="128" width="296" height="52" fill="#e8eef6"/>
							<circle cx="118" cy="86" r="22" fill="#fecdd3"/>
							<circle cx="110" cy="84" r="2.4" fill="#1e293b"/>
							<circle cx="126" cy="84" r="2.4" fill="#1e293b"/>
							<path d="M110 94c5 5 13 5 18 0" fill="none" stroke="#fb7185" stroke-width="2" stroke-linecap="round"/>
							<rect x="96" y="108" width="44" height="48" rx="12" fill="#1d4ed8"/>
							<circle cx="210" cy="86" r="22" fill="#fecdd3"/>
							<circle cx="202" cy="84" r="2.4" fill="#1e293b"/>
							<circle cx="218" cy="84" r="2.4" fill="#1e293b"/>
							<path d="M202 94c5 5 13 5 18 0" fill="none" stroke="#fb7185" stroke-width="2" stroke-linecap="round"/>
							<rect x="188" y="108" width="44" height="48" rx="12" fill="#0f766e"/>
						</g>
						<rect x="16" y="12" width="296" height="168" rx="14" fill="none" stroke="#e2e8f0"/>
						<g clip-path="url(#add-blur-right)">
							<g filter="url(#add-blur-bg)">
								<rect x="328" y="12" width="296" height="168" rx="14" fill="#e0f2fe"/>
								<rect x="348" y="28" width="78" height="50" rx="6" fill="#93c5fd" stroke="#ffffff" stroke-width="4"/>
								<rect x="328" y="128" width="296" height="52" fill="#e8eef6"/>
							</g>
							<rect x="328" y="12" width="296" height="168" rx="14" fill="none" stroke="#e2e8f0"/>
							<circle cx="430" cy="86" r="22" fill="#fecdd3"/>
							<circle cx="422" cy="84" r="2.4" fill="#1e293b"/>
							<circle cx="438" cy="84" r="2.4" fill="#1e293b"/>
							<path d="M422 94c5 5 13 5 18 0" fill="none" stroke="#fb7185" stroke-width="2" stroke-linecap="round"/>
							<rect x="408" y="108" width="44" height="48" rx="12" fill="#1d4ed8"/>
							<rect x="498" y="108" width="44" height="48" rx="12" fill="#0f766e"/>
							<g clip-path="url(#add-blur-pix)">
								<rect x="496" y="62" width="8" height="8" fill="#fdba74"/><rect x="504" y="62" width="8" height="8" fill="#fb923c"/><rect x="512" y="62" width="8" height="8" fill="#fdba74"/><rect x="520" y="62" width="8" height="8" fill="#f97316"/><rect x="528" y="62" width="8" height="8" fill="#fdba74"/><rect x="536" y="62" width="8" height="8" fill="#fb923c"/>
								<rect x="496" y="70" width="8" height="8" fill="#fecdd3"/><rect x="504" y="70" width="8" height="8" fill="#fda4af"/><rect x="512" y="70" width="8" height="8" fill="#fecdd3"/><rect x="520" y="70" width="8" height="8" fill="#fb7185"/><rect x="528" y="70" width="8" height="8" fill="#fecdd3"/><rect x="536" y="70" width="8" height="8" fill="#fda4af"/>
								<rect x="496" y="78" width="8" height="8" fill="#fda4af"/><rect x="504" y="78" width="8" height="8" fill="#fecdd3"/><rect x="512" y="78" width="8" height="8" fill="#fb7185"/><rect x="520" y="78" width="8" height="8" fill="#fecdd3"/><rect x="528" y="78" width="8" height="8" fill="#fda4af"/><rect x="536" y="78" width="8" height="8" fill="#fecdd3"/>
								<rect x="496" y="86" width="8" height="8" fill="#fecdd3"/><rect x="504" y="86" width="8" height="8" fill="#fb7185"/><rect x="512" y="86" width="8" height="8" fill="#fecdd3"/><rect x="520" y="86" width="8" height="8" fill="#fda4af"/><rect x="528" y="86" width="8" height="8" fill="#fecdd3"/><rect x="536" y="86" width="8" height="8" fill="#fb7185"/>
								<rect x="496" y="94" width="8" height="8" fill="#fda4af"/><rect x="504" y="94" width="8" height="8" fill="#fecdd3"/><rect x="512" y="94" width="8" height="8" fill="#fda4af"/><rect x="520" y="94" width="8" height="8" fill="#fecdd3"/><rect x="528" y="94" width="8" height="8" fill="#fb7185"/><rect x="536" y="94" width="8" height="8" fill="#fecdd3"/>
								<rect x="496" y="102" width="8" height="8" fill="#fecdd3"/><rect x="504" y="102" width="8" height="8" fill="#fda4af"/><rect x="512" y="102" width="8" height="8" fill="#fecdd3"/><rect x="520" y="102" width="8" height="8" fill="#fb7185"/><rect x="528" y="102" width="8" height="8" fill="#fecdd3"/><rect x="536" y="102" width="8" height="8" fill="#fda4af"/>
							</g>
						</g>
						<text x="164" y="206" text-anchor="middle" fill="#64748b" font-size="15" font-family="Segoe UI, sans-serif">Original</text>
						<text x="476" y="206" text-anchor="middle" fill="#64748b" font-size="15" font-family="Segoe UI, sans-serif">Blur added</text>
					</svg>
				</figure>
				<span class="kicker">Add blur</span>
				<h3>Image Blurring &amp; Effects</h3>
				<p>Add background blur, anonymize faces, mask sensitive text, or apply creative camera blur effects. Soften one picture with Gaussian or Pixel—including a brush stroke—or apply the same whole-image blur to several files and download them together.</p>
				<div class="category-foot">
					<a class="button" href="<?= html_escape(page_url('blur-image')) ?>">Go to Blur Image Tools</a>
					<nav class="category-links" aria-label="Blur tools">
						<a href="<?= html_escape(page_url('blur-image/background')) ?>">Blur Background</a>
						<a href="<?= html_escape(page_url('blur-image/face')) ?>">Blur Face</a>
						<a href="<?= html_escape(page_url('blur-image/text')) ?>">Blur Text</a>
						<a href="<?= html_escape(page_url('blur-image/effect')) ?>">Gaussian Blur</a>
					</nav>
				</div>
			</article>
			<article class="category-card">
				<figure class="category-art" aria-label="The same portrait, soft on the left and clearer on the right">
					<svg viewBox="0 0 640 220" role="img" aria-hidden="true">
						<rect width="640" height="220" rx="18" fill="#f8fafc"/>
						<defs>
							<linearGradient id="clear-wall" x1="0" y1="0" x2="0" y2="1">
								<stop offset="0" stop-color="#e0f2fe"/>
								<stop offset="1" stop-color="#f8fafc"/>
							</linearGradient>
							<filter id="clear-soft"><feGaussianBlur stdDeviation="2.4"/></filter>
						</defs>
						<rect x="16" y="12" width="296" height="168" rx="14" fill="url(#clear-wall)" stroke="#e2e8f0"/>
						<g filter="url(#clear-soft)">
							<circle cx="164" cy="78" r="32" fill="#fecdd3"/>
							<path d="M140 70c6-14 22-18 32-8" fill="none" stroke="#9a3412" stroke-width="4" stroke-linecap="round"/>
							<circle cx="152" cy="76" r="3.2" fill="#1e293b"/>
							<circle cx="176" cy="76" r="3.2" fill="#1e293b"/>
							<path d="M152 90c8 7 16 7 24 0" fill="none" stroke="#fb7185" stroke-width="2.4" stroke-linecap="round"/>
							<rect x="132" y="108" width="64" height="58" rx="16" fill="#1d4ed8"/>
						</g>
						<rect x="328" y="12" width="296" height="168" rx="14" fill="url(#clear-wall)" stroke="#e2e8f0"/>
						<circle cx="476" cy="78" r="32" fill="#fecdd3"/>
						<path d="M452 70c6-14 22-18 32-8" fill="none" stroke="#9a3412" stroke-width="4" stroke-linecap="round"/>
						<circle cx="464" cy="76" r="3.2" fill="#1e293b"/>
						<circle cx="488" cy="76" r="3.2" fill="#1e293b"/>
						<path d="M464 90c8 7 16 7 24 0" fill="none" stroke="#fb7185" stroke-width="2.4" stroke-linecap="round"/>
						<rect x="444" y="108" width="64" height="58" rx="16" fill="#1d4ed8"/>
						<text x="164" y="206" text-anchor="middle" fill="#64748b" font-size="15" font-family="Segoe UI, sans-serif">Soft</text>
						<text x="476" y="206" text-anchor="middle" fill="#64748b" font-size="15" font-family="Segoe UI, sans-serif">Clearer</text>
					</svg>
				</figure>
				<span class="kicker">Clear soft photos</span>
				<h3>Image Enhancement &amp; Unblurring</h3>
				<p>Clear blurry photos, fix motion blur from camera shake, and restore soft snapshot details online. A clarity pass can help when edges are still almost there. It does not invent a sharper face or a readable sign from a smooth blob.</p>
				<div class="category-foot">
					<a class="button" href="<?= html_escape(page_url('unblur-image')) ?>">Go to Unblur Image Tools</a>
					<nav class="category-links" aria-label="Unblur tools">
						<a href="<?= html_escape(page_url('unblur-image/motion-blur')) ?>">Fix Motion Blur</a>
					</nav>
				</div>
			</article>
		</div>
	</section>

	<section>
		<h2>Popular Quick Tools</h2>
		<p class="section-intro">Already know the job? These shortcuts open the exact editor—blur a face, hide writing, soften a background, or try a light unblur—without browsing the full category first.</p>
		<div class="feature-grid">
			<a class="feature" href="<?= html_escape(page_url('blur-image')) ?>">
				<span class="kicker">Blur</span>
				<h3>Blur Image</h3>
				<p>Add Gaussian or Pixel blur to the whole frame or a painted region.</p>
				<span class="feature-go">Open tool</span>
			</a>
			<a class="feature" href="<?= html_escape(page_url('unblur-image')) ?>">
				<span class="kicker">Unblur</span>
				<h3>Fix Blurry Image</h3>
				<p>Tighten mild soft focus with a clarity pass in the browser.</p>
				<span class="feature-go">Open tool</span>
			</a>
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
				<h3>Blur Text In Photo</h3>
				<p>Find writing in screenshots and documents, then redact or pixelate it.</p>
				<span class="feature-go">Open tool</span>
			</a>
			<a class="feature" href="<?= html_escape(page_url('blur-image/effect')) ?>">
				<span class="kicker">Effects</span>
				<h3>Gaussian Blur</h3>
				<p>Apply Gaussian, Pixel, Motion, or Radial looks—one effect at a time.</p>
				<span class="feature-go">Open tool</span>
			</a>
			<a class="feature" href="<?= html_escape(page_url('unblur-image/motion-blur')) ?>">
				<span class="kicker">Motion</span>
				<h3>Fix Motion Blur</h3>
				<p>Match Motion angle to a short camera shake. Heavy trails usually cannot be rebuilt.</p>
				<span class="feature-go">Open tool</span>
			</a>
		</div>
	</section>

	<section class="home-platform">
		<h2>All-in-One Online Photo Processing Platform</h2>
		<ul class="home-points">
			<li>
				<strong>Stays on this device</strong>
				<span>Blur and unblur run in your browser. The image is not uploaded for processing.</span>
			</li>
			<li>
				<strong>No install, no account</strong>
				<span>Open a tool and download a new PNG. There is nothing to sign in for.</span>
			</li>
			<li>
				<strong>Blur and unblur stay separate</strong>
				<span>Pick the job first. A long motion trail still cannot be rebuilt from one frame.</span>
			</li>
		</ul>
		<p class="home-note">Guides on the <a href="<?= html_escape(page_url('blog')) ?>">blog</a> explain what a single frame can still give back.</p>
	</section>

	<?php $this->load->view('partials/faq', array('faqs' => $faqs, 'faq_heading' => 'Frequently Asked Questions')); ?>
</article>
