<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<article class="sheet home">
	<section class="hero">
		<div>
			<p class="eyebrow">Browser based</p>
			<h1>Blur Images Online for Free</h1>
			<p class="dek">Blur faces, text, backgrounds, and sensitive details directly in your browser. Upload an image, preview the blur, and download a clean result without signing up.</p>
			<ul class="checks">
				<li>Privacy focused</li>
				<li>Free to use</li>
				<li>Multiple blur effects</li>
			</ul>
		</div>
		<figure class="hero-card">
			<svg viewBox="0 0 640 420" role="img" aria-label="Preview of a browser blur editor with a softened portrait and several blur styles">
				<rect width="640" height="420" rx="22" fill="#f8fafc"/>
				<rect x="28" y="28" width="168" height="364" rx="16" fill="#ffffff" stroke="#e2e8f0"/>
				<rect x="46" y="52" width="132" height="74" rx="10" fill="#dbeafe"/>
				<rect x="46" y="138" width="132" height="74" rx="10" fill="#bfdbfe"/>
				<rect x="46" y="224" width="132" height="74" rx="10" fill="#93c5fd"/>
				<rect x="46" y="310" width="132" height="58" rx="10" fill="#e0e7ff"/>
				<rect x="214" y="28" width="398" height="364" rx="18" fill="#ffffff" stroke="#e2e8f0"/>
				<defs>
					<linearGradient id="sky" x1="0" y1="0" x2="0" y2="1">
						<stop offset="0" stop-color="#dbeafe"/>
						<stop offset="1" stop-color="#eff6ff"/>
					</linearGradient>
					<filter id="soft"><feGaussianBlur stdDeviation="8"/></filter>
				</defs>
				<rect x="236" y="52" width="354" height="250" rx="14" fill="url(#sky)"/>
				<g filter="url(#soft)">
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
			<figcaption>Multiple blur effects</figcaption>
		</figure>
	</section>

	<section class="tool-shell">
		<h2>Image Blur Tool</h2>
		<p class="dek">Upload a picture, adjust blur strength, preview it in real time, and download the blurred image.</p>
		<?php $this->load->view('partials/tool', array('tool' => array(
			'mode' => 'blur',
			'preset' => 'soft',
			'note' => 'Soften the whole picture, or paint only the face, text, or background you want to hide.',
		))); ?>
	</section>

	<section>
		<h2>How to Blur a Photo Online</h2>
		<p class="section-intro">Blur your image in three simple steps. The file never leaves this browser.</p>
		<ol class="step-cards">
			<li>
				<h3>Upload Your Image</h3>
				<p>Click the upload area or drag in a JPG, PNG, or WEBP. You can also load the sample and try the controls first.</p>
			</li>
			<li>
				<h3>Adjust the Blur</h3>
				<p>Use the slider for a smooth blur, switch on pixelate to hide readable detail, or paint one area so the rest stays sharp.</p>
			</li>
			<li>
				<h3>Download Your Image</h3>
				<p>Hold the original to compare, then download a PNG. Your camera file stays where it was.</p>
			</li>
		</ol>
	</section>

	<section>
		<h2>Blur the parts of an image that should stay private</h2>
		<p class="section-intro">Use a focused tool before you share a photo, screenshot, or document.</p>
		<div class="feature-grid">
			<a class="feature" href="<?= html_escape(page_url('blur-image/face')) ?>">
				<span class="kicker">Face</span>
				<h3>Blur Face in Photo</h3>
				<p>Hide people in portraits, group shots, and social posts before publishing.</p>
				<span class="feature-go">Open tool</span>
			</a>
			<a class="feature" href="<?= html_escape(page_url('blur-image/text')) ?>">
				<span class="kicker">Text</span>
				<h3>Blur Text in Image</h3>
				<p>Cover names, emails, addresses, and other writing that should not stay readable.</p>
				<span class="feature-go">Open tool</span>
			</a>
			<a class="feature" href="<?= html_escape(page_url('blur-image/background')) ?>">
				<span class="kicker">Background</span>
				<h3>Blur Background Online</h3>
				<p>Soften a busy room, street, or screen while the subject stays clear.</p>
				<span class="feature-go">Open tool</span>
			</a>
			<a class="feature" href="<?= html_escape(page_url('blur-image/effect')) ?>">
				<span class="kicker">Effects</span>
				<h3>Gaussian, Pixelate, Fade</h3>
				<p>Pick a smooth blur, blocky pixelate, or a light fade for teasers and covers.</p>
				<span class="feature-go">Open tool</span>
			</a>
		</div>
	</section>

	<section>
		<h2>Need the opposite result?</h2>
		<p class="section-intro">Adding blur and removing blur are different jobs. If the photo is already soft, un blur an image instead of covering it.</p>
		<div class="feature-grid">
			<a class="feature" href="<?= html_escape(page_url('unblur-image')) ?>">
				<span class="kicker">Unblur</span>
				<h3>Unblur Image Online</h3>
				<p>Unblurring an image sharpens a blurry photo when the detail is still almost there.</p>
				<span class="feature-go">Open tool</span>
			</a>
			<a class="feature" href="<?= html_escape(page_url('unblur-image/photos')) ?>">
				<span class="kicker">Photos</span>
				<h3>Fix Blurry Photos</h3>
				<p>A careful clarity pass for slightly soft snapshots, not a rebuild of a missed shot.</p>
				<span class="feature-go">Open tool</span>
			</a>
			<a class="feature" href="<?= html_escape(page_url('blog')) ?>">
				<span class="kicker">Guides</span>
				<h3>Photo Blur Guides</h3>
				<p>Short tutorials for hiding a face, covering writing, and repairing a fuzzy photo.</p>
				<span class="feature-go">Read guides</span>
			</a>
			<a class="feature" href="<?= html_escape(page_url('blur-image')) ?>">
				<span class="kicker">Editor</span>
				<h3>Full Blur Image Page</h3>
				<p>Background, face, text, and effect notes for the main blur picture editor.</p>
				<span class="feature-go">Open page</span>
			</a>
		</div>
	</section>

	<?php $this->load->view('partials/faq', array('faqs' => $faqs)); ?>
</article>
