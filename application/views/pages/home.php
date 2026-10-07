<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<article class="sheet home">
	<section class="home-intro">
		<h1>Blur &amp; Unblur Image Online – Add or Remove Blur From Photos</h1>
		<p class="dek">One editor adds Gaussian or Pixel blur. The other tries to sharpen a photo that is already soft. Pick the job first. The picture stays in this browser either way.</p>
	</section>

	<section>
		<h2>Two Powerful Photo Tools</h2>
		<div class="feature-grid pair">
				<a class="feature with-art" href="<?= html_escape(page_url('blur-image')) ?>">
					<figure class="tool-art">
						<svg viewBox="0 0 640 420" role="img" aria-label="A sharp person in front of a blurred background figure">
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
					<span>
						<span class="kicker">Add blur</span>
						<h3>Add Blur To Images</h3>
						<p>Blur one picture with Gaussian or Pixel, including a brush stroke. Or blur several whole photos the same way and download them together.</p>
						<span class="feature-go">Go to Blur Image Tool</span>
					</span>
				</a>
				<a class="feature with-art" href="<?= html_escape(page_url('unblur-image')) ?>">
					<figure class="tool-art">
						<svg viewBox="0 0 640 420" role="img" aria-label="A soft portrait beside the same portrait with clearer edges">
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
					<span>
						<span class="kicker">Remove blur</span>
						<h3>Fix &amp; Unblur Blurry Photos</h3>
						<p>Un blur an image, unblurring an image, or clear a blurry photo when the detail is still almost there. This does not invent a sharper face.</p>
						<span class="feature-go">Go to Unblur Image Tool</span>
					</span>
				</a>
			</div>
	</section>

	<section>
		<h2>Popular Quick Tools</h2>
		<div class="feature-grid">
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
			<a class="feature" href="<?= html_escape(page_url('blur-image/effect')) ?>">
				<span class="kicker">Effect</span>
				<h3>Gaussian Blur Effect</h3>
				<p>Compare a smooth Gaussian soften with blocky Pixel. The editor uses one of them at a time.</p>
				<span class="feature-go">Open tool</span>
			</a>
			<a class="feature" href="<?= html_escape(page_url('unblur-image/motion-blur')) ?>">
				<span class="kicker">Motion</span>
				<h3>Fix Motion Blur Photo</h3>
				<p>A short camera shake may tighten a little. A subject that moved through the frame usually cannot be rebuilt.</p>
				<span class="feature-go">Open tool</span>
			</a>
		</div>
	</section>

	<?php $this->load->view('partials/faq', array('faqs' => $faqs)); ?>
</article>
