<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<article class="sheet home">
	<section class="home-intro">
		<h1>Free Online Image Utilities &amp; Photo Tools | Imgnexo</h1>
		<p class="dek">Easy-to-use, browser-based image tools. Processing stays private on your device.</p>
	</section>

	<section class="home-categories">
		<h2>Explore Photo Tool Categories</h2>
		<p class="section-intro">Pick a category, then open the main tool or jump straight to a common job. New categories will appear here as the suite grows.</p>
		<div class="category-grid">
			<article class="category-card">
				<figure class="category-art" aria-label="A sharp person in front of a blurred background figure">
					<svg viewBox="0 0 640 420" role="img" aria-hidden="true">
						<rect width="640" height="420" rx="22" fill="#f8fafc"/>
						<rect x="28" y="28" width="168" height="364" rx="16" fill="#ffffff" stroke="#e2e8f0"/>
						<rect x="46" y="52" width="132" height="74" rx="10" fill="#dbeafe"/>
						<rect x="46" y="138" width="132" height="74" rx="10" fill="#bfdbfe"/>
						<rect x="46" y="224" width="132" height="74" rx="10" fill="#93c5fd"/>
						<rect x="46" y="310" width="132" height="58" rx="10" fill="#e0e7ff"/>
						<rect x="214" y="28" width="398" height="364" rx="18" fill="#ffffff" stroke="#e2e8f0"/>
						<defs>
							<linearGradient id="blur-sky" x1="0" y1="0" x2="0" y2="1">
								<stop offset="0" stop-color="#dbeafe"/>
								<stop offset="1" stop-color="#eff6ff"/>
							</linearGradient>
							<filter id="blur-soft"><feGaussianBlur stdDeviation="8"/></filter>
						</defs>
						<rect x="236" y="52" width="354" height="250" rx="14" fill="url(#blur-sky)"/>
						<g filter="url(#blur-soft)">
							<circle cx="470" cy="150" r="54" fill="#93c5fd"/>
							<rect x="410" y="190" width="120" height="70" rx="12" fill="#2563eb" opacity=".45"/>
						</g>
						<circle cx="330" cy="168" r="36" fill="#fecdd3"/>
						<rect x="300" y="204" width="60" height="62" rx="10" fill="#1d4ed8"/>
						<rect x="236" y="318" width="78" height="52" rx="8" fill="#e2e8f0"/>
						<rect x="324" y="318" width="78" height="52" rx="8" fill="#cbd5e1"/>
						<rect x="412" y="318" width="78" height="52" rx="8" fill="#94a3b8"/>
						<rect x="500" y="318" width="78" height="52" rx="8" fill="#64748b"/>
					</svg>
				</figure>
				<span class="kicker">Add blur</span>
				<h3>Image Blurring &amp; Effects</h3>
				<p>Add background blur, anonymize faces, mask sensitive text, or apply creative camera blur effects.</p>
				<a class="feature-go" href="<?= html_escape(page_url('blur-image')) ?>">Go to Blur Image Tools</a>
				<nav class="category-links" aria-label="Blur tools">
					<a href="<?= html_escape(page_url('blur-image/background')) ?>">Blur Background</a>
					<a href="<?= html_escape(page_url('blur-image/face')) ?>">Blur Face</a>
					<a href="<?= html_escape(page_url('blur-image/text')) ?>">Blur Text</a>
					<a href="<?= html_escape(page_url('blur-image/effect')) ?>">Gaussian Blur</a>
				</nav>
			</article>
			<article class="category-card">
				<figure class="category-art" aria-label="A soft portrait beside the same portrait with clearer edges">
					<svg viewBox="0 0 640 420" role="img" aria-hidden="true">
						<rect width="640" height="420" rx="22" fill="#f8fafc"/>
						<rect x="28" y="28" width="168" height="364" rx="16" fill="#ffffff" stroke="#e2e8f0"/>
						<rect x="46" y="52" width="132" height="74" rx="10" fill="#e2e8f0"/>
						<rect x="46" y="138" width="132" height="74" rx="10" fill="#cbd5e1"/>
						<rect x="46" y="224" width="132" height="74" rx="10" fill="#94a3b8"/>
						<rect x="46" y="310" width="132" height="58" rx="10" fill="#e2e8f0"/>
						<rect x="214" y="28" width="398" height="364" rx="18" fill="#ffffff" stroke="#e2e8f0"/>
						<defs>
							<linearGradient id="clear-sky" x1="0" y1="0" x2="0" y2="1">
								<stop offset="0" stop-color="#e0f2fe"/>
								<stop offset="1" stop-color="#f8fafc"/>
							</linearGradient>
							<filter id="clear-soft"><feGaussianBlur stdDeviation="6"/></filter>
						</defs>
						<rect x="236" y="52" width="168" height="250" rx="14" fill="url(#clear-sky)"/>
						<g filter="url(#clear-soft)">
							<circle cx="320" cy="150" r="34" fill="#fecdd3"/>
							<rect x="292" y="186" width="56" height="58" rx="10" fill="#93c5fd"/>
						</g>
						<rect x="412" y="52" width="178" height="250" rx="14" fill="#ffffff" stroke="#e2e8f0"/>
						<circle cx="501" cy="146" r="34" fill="#fecdd3"/>
						<circle cx="489" cy="142" r="4" fill="#1e293b"/>
						<circle cx="513" cy="142" r="4" fill="#1e293b"/>
						<rect x="473" y="184" width="56" height="62" rx="10" fill="#1d4ed8"/>
						<rect x="236" y="318" width="78" height="52" rx="8" fill="#e2e8f0"/>
						<rect x="324" y="318" width="78" height="52" rx="8" fill="#cbd5e1"/>
						<rect x="412" y="318" width="78" height="52" rx="8" fill="#94a3b8"/>
						<rect x="500" y="318" width="78" height="52" rx="8" fill="#64748b"/>
					</svg>
				</figure>
				<span class="kicker">Clear soft photos</span>
				<h3>Image Enhancement &amp; Unblurring</h3>
				<p>Clear blurry photos, fix motion blur from camera shake, and restore soft snapshot details online.</p>
				<a class="feature-go" href="<?= html_escape(page_url('unblur-image')) ?>">Go to Unblur Image Tools</a>
				<nav class="category-links" aria-label="Unblur tools">
					<a href="<?= html_escape(page_url('unblur-image/motion-blur')) ?>">Fix Motion Blur</a>
				</nav>
			</article>
		</div>
	</section>

	<section>
		<h2>Popular Quick Tools</h2>
		<p class="section-intro">High-traffic shortcuts across categories. Open the exact editor you need in one click.</p>
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
		<div class="prose">
			<p>Imgnexo provides a fast, free, and privacy-focused suite of online image tools. Whether you need to blur sensitive information, recover motion-blurred pictures, or prepare images for everyday sharing and product work, all processing happens directly inside your web browser. No software installation required.</p>
		</div>
	</section>

	<?php $this->load->view('partials/faq', array('faqs' => $faqs, 'faq_heading' => 'Frequently Asked Questions')); ?>
</article>
