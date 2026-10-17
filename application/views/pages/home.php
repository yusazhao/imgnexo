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
				<figure class="category-art" aria-label="Mini editor window painting blur on a canvas with a brush control">
					<svg viewBox="0 0 640 200" role="img" aria-hidden="true">
						<defs>
							<linearGradient id="blur-canvas" x1="0" y1="0" x2="1" y2="1">
								<stop offset="0" stop-color="#1e293b"/>
								<stop offset="1" stop-color="#0f172a"/>
							</linearGradient>
							<filter id="blur-soft-patch" x="-20%" y="-20%" width="140%" height="140%">
								<feGaussianBlur stdDeviation="4"/>
							</filter>
						</defs>
						<rect width="640" height="200" rx="14" fill="#0f172a"/>
						<rect x="1" y="1" width="638" height="198" rx="13" fill="none" stroke="#334155"/>
						<circle cx="28" cy="28" r="6" fill="#f87171"/>
						<circle cx="48" cy="28" r="6" fill="#fbbf24"/>
						<circle cx="68" cy="28" r="6" fill="#34d399"/>
						<text x="92" y="33" fill="#6ee7b7" font-size="15" font-weight="600" font-family="ui-sans-serif, system-ui, sans-serif">Client-side active</text>
						<text x="612" y="33" text-anchor="end" fill="#cbd5e1" font-size="15" font-family="ui-monospace, SFMono-Regular, Menlo, monospace">/blur-image</text>
						<line x1="16" y1="50" x2="624" y2="50" stroke="#334155"/>
						<rect x="16" y="62" width="408" height="122" rx="8" fill="url(#blur-canvas)" stroke="#475569"/>
						<rect x="44" y="82" width="140" height="82" rx="8" fill="#475569"/>
						<circle cx="198" cy="112" r="30" fill="#64748b"/>
						<rect x="248" y="96" width="120" height="16" rx="4" fill="#64748b"/>
						<rect x="248" y="122" width="88" height="12" rx="3" fill="#475569"/>
						<g filter="url(#blur-soft-patch)" opacity=".95">
							<ellipse cx="170" cy="122" rx="56" ry="38" fill="#818cf8"/>
						</g>
						<rect x="132" y="106" width="110" height="34" rx="8" fill="rgba(15,23,42,.72)" stroke="#a5b4fc" stroke-width="1.5"/>
						<text x="187" y="128" text-anchor="middle" fill="#eef2ff" font-size="15" font-weight="600" font-family="ui-sans-serif, system-ui, sans-serif">Brush · 16px</text>
						<rect x="436" y="62" width="188" height="122" rx="8" fill="#020617" stroke="#475569"/>
						<text x="456" y="94" fill="#f1f5f9" font-size="16" font-weight="600" font-family="ui-sans-serif, system-ui, sans-serif">Tool: Brush</text>
						<text x="456" y="122" fill="#e2e8f0" font-size="14" font-family="ui-sans-serif, system-ui, sans-serif">Strength</text>
						<rect x="456" y="132" width="148" height="8" rx="4" fill="#334155"/>
						<rect x="456" y="132" width="112" height="8" rx="4" fill="#818cf8"/>
						<text x="456" y="166" fill="#6ee7b7" font-size="15" font-weight="600" font-family="ui-sans-serif, system-ui, sans-serif">✓ On this device</text>
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
				<figure class="category-art" aria-label="Mini editor window comparing a soft photo pass with a clearer result">
					<svg viewBox="0 0 640 200" role="img" aria-hidden="true">
						<defs>
							<filter id="unblur-soft-label" x="-15%" y="-15%" width="130%" height="130%">
								<feGaussianBlur stdDeviation="1.1"/>
							</filter>
						</defs>
						<rect width="640" height="200" rx="14" fill="#0f172a"/>
						<rect x="1" y="1" width="638" height="198" rx="13" fill="none" stroke="#334155"/>
						<circle cx="28" cy="28" r="6" fill="#f87171"/>
						<circle cx="48" cy="28" r="6" fill="#fbbf24"/>
						<circle cx="68" cy="28" r="6" fill="#34d399"/>
						<text x="92" y="33" fill="#93c5fd" font-size="15" font-weight="600" font-family="ui-sans-serif, system-ui, sans-serif">Before / after pass</text>
						<text x="612" y="33" text-anchor="end" fill="#cbd5e1" font-size="15" font-family="ui-monospace, SFMono-Regular, Menlo, monospace">/unblur-image</text>
						<line x1="16" y1="50" x2="624" y2="50" stroke="#334155"/>
						<rect x="16" y="62" width="296" height="122" rx="8" fill="#020617" stroke="#475569"/>
						<rect x="112" y="80" width="104" height="28" rx="6" fill="#334155"/>
						<text x="164" y="99" text-anchor="middle" fill="#f1f5f9" font-size="14" font-weight="700" font-family="ui-sans-serif, system-ui, sans-serif">BEFORE</text>
						<g filter="url(#unblur-soft-label)">
							<text x="164" y="140" text-anchor="middle" fill="#e2e8f0" font-size="22" font-family="ui-sans-serif, system-ui, sans-serif" font-weight="700">Soft focus</text>
						</g>
						<rect x="48" y="160" width="80" height="10" rx="4" fill="#475569"/>
						<rect x="140" y="160" width="120" height="10" rx="4" fill="#475569"/>
						<rect x="328" y="62" width="296" height="122" rx="8" fill="#020617" stroke="#818cf8" stroke-width="1.5"/>
						<rect x="418" y="80" width="96" height="28" rx="6" fill="#4f46e5"/>
						<text x="466" y="99" text-anchor="middle" fill="#ffffff" font-size="14" font-weight="700" font-family="ui-sans-serif, system-ui, sans-serif">AFTER</text>
						<text x="476" y="140" text-anchor="middle" fill="#e0e7ff" font-size="22" font-family="ui-sans-serif, system-ui, sans-serif" font-weight="700">Clearer</text>
						<rect x="360" y="160" width="80" height="10" rx="4" fill="#6366f1"/>
						<rect x="452" y="160" width="120" height="10" rx="4" fill="#818cf8"/>
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
