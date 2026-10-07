<?php
defined('BASEPATH') OR exit('No direct script access allowed');

return array(
	array(
		'slug' => 'privacy-policy',
		'path' => 'privacy-policy',
		'title' => 'Privacy Policy – Imgnexo',
		'description' => 'How Imgnexo handles photos and server logs. Image edits run in your browser—no photo upload to a cloud AI.',
		'h1' => 'Privacy Policy',
		'crumbs' => array(
			array('name' => 'Home', 'path' => ''),
			array('name' => 'Privacy Policy', 'path' => 'privacy-policy'),
		),
		'html' => <<<'HTML'
<p class="lead">Effective date: {{effective_date}}. This policy explains what Imgnexo does—and does not—do with information when you use our free browser tools to blur or unblur photos.</p>

<h2>Who we are</h2>
<p>{{operator_line}} For privacy questions, use the details on our <a href="{{path:contact}}">Contact</a> page.</p>

<h2>The short version</h2>
<ul>
<li>Your photos are edited in your browser. We do not operate an upload API that receives your image files for blur or unblur processing.</li>
<li>You do not need an account. We do not maintain a library of your past edits on our servers.</li>
<li>We do not send your photos to a third-party CDN or a cloud large-language / generative model for editing.</li>
<li>Like most websites, our host may keep ordinary request logs (for example IP address, URL, and user agent).</li>
</ul>

<h2>Photos and on-device processing</h2>
<p>When you open a JPG, PNG, or WEBP in a blur or unblur tool, the file is read in your tab (for example via the browser canvas). Clarity, Gaussian, Pixel, motion deblur, brush masks, and downloads of a new PNG are produced on your device.</p>
<p>Optional face, text, and background helpers also run in the tab with browser-side scripts. Imgnexo does not ship its own local AI models with the site, and these helpers are not a remote API that receives your image pixels for cloud inference.</p>
<p>Practical limits that affect what leaves your camera roll:</p>
<ul>
<li>Files larger than about 15&nbsp;MB are rejected in the editor.</li>
<li>For performance, a working copy may be scaled so the long edge is at most 1600 pixels before heavy edits. The download is that working result, not a rewrite of the original camera file on disk.</li>
</ul>
<p>Closing the tab ends the in-memory edit. We do not keep a cloud copy of the picture you opened.</p>

<h2>Site assets</h2>
<p>HTML, CSS, JavaScript, and any helper assets for the editors are served from our own origin with the page. Loading those files is not a photo upload.</p>

<h2>Accounts, cookies, and payments</h2>
<p>Imgnexo’s blur and unblur tools do not require sign-in, and we do not sell subscriptions inside these editors. We do not set a login cookie for the tools. Your browser may still store ordinary technical data such as cached scripts or local preferences if the product uses them later; that stays on your device.</p>

<h2>Server logs and hosting</h2>
<p>When you load a page (home, tool, blog, or this policy), our web host may record request data such as IP address, approximate time, requested URL, referrer, and user agent. We use that only to keep the site running (security, abuse prevention, reliability)—not to rebuild the contents of photos you edit in the browser.</p>
<p>If you email us, we receive whatever you include in the message (name, address, attachments). We use that to reply and then retain it only as long as needed for support or legal reasons.</p>

<h2>Children</h2>
<p>The tools are general-purpose photo utilities. They are not directed at children under 13 (or the equivalent age in your region). Do not send us personal information about a child through Contact.</p>

<h2>Your choices</h2>
<ul>
<li>Use the tools without creating an account.</li>
<li>Skip face, text, or background features if you only need a simple whole-image or brush edit.</li>
<li>Contact us to ask what we hold about an email you sent.</li>
</ul>

<h2>International visitors</h2>
<p>Processing of photos happens on your device. Server logs and email are handled where our host and mailbox are located. If you need a region-specific privacy request, write to us via <a href="{{path:contact}}">Contact</a> and describe the request.</p>

<h2>Changes</h2>
<p>We may update this policy when the product or hosting changes. The effective date at the top will change when we do. Continued use of the site after an update means you have read the revised policy.</p>

<h2>Contact for privacy</h2>
{{contact_block}}
HTML
	),

	array(
		'slug' => 'terms-of-service',
		'path' => 'terms-of-service',
		'title' => 'Terms of Service – Imgnexo',
		'description' => 'Terms for using Imgnexo’s free browser blur and unblur tools: licenses, limits, and acceptable use.',
		'h1' => 'Terms of Service',
		'crumbs' => array(
			array('name' => 'Home', 'path' => ''),
			array('name' => 'Terms of Service', 'path' => 'terms-of-service'),
		),
		'html' => <<<'HTML'
<p class="lead">Effective date: {{effective_date}}. By using Imgnexo, you agree to these terms. If you do not agree, do not use the site.</p>

<h2>The service</h2>
<p>{{operator_line}} Imgnexo provides free, browser-based tools to add blur (including whole-image, region, face, text, background, and effect presets) or to attempt to reduce soft focus / motion smear with on-device clarity and directional controls. Guides on the blog are informational.</p>
<p>There is no paid plan inside these editors today. Features, limits, and availability may change without notice.</p>

<h2>What the tools actually do</h2>
<ul>
<li><strong>Client-side edits.</strong> Image math runs in your browser. We do not promise server-side AI restoration of your files.</li>
<li><strong>Unblur limits.</strong> Clarity and motion passes can emphasize detail that is still in the file. They cannot invent a sharp pose or readable plate from a smooth blob or a long trail. Results vary by photo.</li>
<li><strong>Privacy covers.</strong> Pixel, redact, and black-bar options help hide faces or text for publishing. Soft Gaussian is a weak anonymization choice. No cover is a cryptographic guarantee against every future attack.</li>
<li><strong>Detectors.</strong> Face, text, and background finders can miss people, handwriting, or hair edges. You must review and correct boxes or brush strokes before you share.</li>
<li><strong>File limits.</strong> Roughly 15&nbsp;MB per file; working copies may be scaled to a 1600-pixel long edge.</li>
</ul>

<h2>Acceptable use</h2>
<p>You may use Imgnexo only for lawful purposes. You agree not to:</p>
<ul>
<li>Upload or edit images you have no right to use;</li>
<li>Use the tools to harass, stalk, defraud, or invade someone’s privacy unlawfully;</li>
<li>Attempt to reverse-engineer or overload the site in a way that harms other users or our host;</li>
<li>Misrepresent the tools as a forensic lab, a government-certified anonymizer, or a cloud AI that invents missing pixels.</li>
</ul>
<p>You are responsible for how you publish edited images and for complying with local privacy and publicity laws.</p>

<h2>Intellectual property</h2>
<p>The Imgnexo name, site design, and original copy belong to us or our licensors. You keep ownership of photos you open in the editor. Open-source components bundled with the site (if any) remain under their own licenses.</p>

<h2>No warranty</h2>
<p>The site and tools are provided <strong>“as is”</strong> and <strong>“as available.”</strong> We disclaim warranties of merchantability, fitness for a particular purpose, and non-infringement to the fullest extent allowed by law. We do not warrant that unblur will satisfy a print, court, or insurance requirement, or that a blurred export will be irreversible.</p>

<h2>Limitation of liability</h2>
<p>To the fullest extent permitted by law, Imgnexo and {{operator_short}} are not liable for indirect, incidental, special, consequential, or punitive damages, or for lost profits, data, or goodwill, arising from your use of the tools—including a disappointing unblur result or a privacy cover that a third party later challenges. Our total liability for any claim relating to the service is limited to zero dollars if the service is free, or the amount you paid us for the service in the three months before the claim (if any).</p>
<p>Some jurisdictions do not allow certain limitations; in those places, our liability is limited to the maximum permitted by law.</p>

<h2>Indemnity</h2>
<p>You agree to defend and hold harmless Imgnexo and {{operator_short}} from claims arising out of your misuse of the tools, your content, or your violation of these terms or applicable law.</p>

<h2>Third-party services</h2>
<p>When you blur or unblur a photo, the edit runs in your browser. Imgnexo does not call a third-party AI service with your file, and our own servers do not host an AI model or expose an AI API that receives your image for processing. Optional face, text, and background helpers follow the same rule: they do not upload your photo to an AI endpoint on this site or elsewhere. Serving the site’s ordinary HTML, CSS, and JavaScript is described in the <a href="{{path:privacy-policy}}">Privacy Policy</a>.</p>

<h2>Changes and termination</h2>
<p>We may change these terms, the tools, or take the site offline. Continued use after a change means you accept the new terms. We may block access that appears abusive.</p>

<h2>Governing law</h2>
<p>{{jurisdiction_block}}</p>

<h2>Contact</h2>
<p>Questions about these terms: see <a href="{{path:contact}}">Contact</a>. Related reading: <a href="{{path:privacy-policy}}">Privacy Policy</a> and <a href="{{path:about-us}}">About Us</a>.</p>
HTML
	),

	array(
		'slug' => 'about-us',
		'path' => 'about-us',
		'title' => 'About Us – Imgnexo',
		'description' => 'What Imgnexo is: free browser tools to blur faces, text, and backgrounds, or try to clear soft photos—without uploading your images to our servers.',
		'h1' => 'About Us',
		'crumbs' => array(
			array('name' => 'Home', 'path' => ''),
			array('name' => 'About Us', 'path' => 'about-us'),
		),
		'html' => <<<'HTML'
<p class="lead">Imgnexo is a small set of free photo tools that run in your browser. We help you add blur for privacy or style, or try to tighten a mildly soft shot—without creating an account or uploading the picture to our servers for processing.</p>

<h2>What we build</h2>
<p>{{operator_line}} Our focus is practical, on-device editing:</p>
<ul>
<li><a href="{{path:blur-image}}">Blur image</a> — Gaussian or Pixel on the whole frame or a painted region; batch whole-image blur when you need several files the same way.</li>
<li><a href="{{path:blur-image/face}}">Blur face</a>, <a href="{{path:blur-image/text}}">blur text</a>, and <a href="{{path:blur-image/background}}">blur background</a> — optional on-device finders plus covers you can correct by hand.</li>
<li><a href="{{path:blur-image/effect}}">Blur effects</a> — Gaussian, Pixel, Motion, Radial, and related looks, one effect at a time.</li>
<li><a href="{{path:unblur-image}}">Unblur image</a> and <a href="{{path:unblur-image/motion-blur}}">motion blur repair</a> — clarity / directional passes that emphasize what is still in the file.</li>
</ul>
<p>The <a href="{{path:blog}}">blog</a> explains limits in plain language (for example when motion trails cannot be restored), so expectations match the physics of a single frame.</p>

<h2>How we work (honest limits)</h2>
<ul>
<li><strong>Privacy by design for edits:</strong> photo pixels for blur/unblur stay in your tab. We do not upload them to a CDN or a cloud large model for processing.</li>
<li><strong>Not magic AI:</strong> unblur is an unsharp-style / directional pass in the browser, not a cloud LLM that invents a new face.</li>
<li><strong>Not a guarantee of anonymity:</strong> soft blur can leak identity; prefer Pixel, redact, or a solid bar when publishing strangers or sensitive text.</li>
<li><strong>Detectors need a human check:</strong> missed faces, handwriting, or reflections are your responsibility before you post.</li>
</ul>

<h2>Why that matters for trust</h2>
<p>Search and privacy guidance rewards sites that say what they actually do. We would rather under-promise (mild soft focus may improve; heavy smear usually will not) than claim a forensic lab in the browser. If a claim on a landing page ever disagrees with this About page or the <a href="{{path:privacy-policy}}">Privacy Policy</a>, treat the policy and this page as the accurate product description and tell us via <a href="{{path:contact}}">Contact</a>.</p>

<h2>Who is behind Imgnexo</h2>
{{about_operator}}

<h2>Get in touch</h2>
<p>Product questions, privacy requests, or corrections to our guides: <a href="{{path:contact}}">Contact</a>. Legal terms: <a href="{{path:terms-of-service}}">Terms of Service</a>.</p>
HTML
	),

	array(
		'slug' => 'contact',
		'path' => 'contact',
		'title' => 'Contact – Imgnexo',
		'description' => 'Contact Imgnexo about the blur and unblur browser tools, privacy questions, or guide corrections.',
		'h1' => 'Contact',
		'crumbs' => array(
			array('name' => 'Home', 'path' => ''),
			array('name' => 'Contact', 'path' => 'contact'),
		),
		'html' => <<<'HTML'
<p class="lead">We read messages about the tools, privacy, and guide corrections. There is no account system and no in-app chat—email is the channel.</p>

<h2>Email</h2>
{{contact_block}}
<p>We aim to reply {{response_window}}. Complex privacy or legal requests may take longer.</p>

<h2>What to include</h2>
<ul>
<li>Which page or tool you used (for example blur face, unblur, or a blog URL).</li>
<li>Your browser and device (Safari on iPhone, Chrome on Windows, and so on).</li>
<li>For bugs: what you expected vs. what happened. Do <strong>not</strong> attach photos that contain sensitive faces, IDs, or account numbers unless we ask and you redacted them first.</li>
</ul>

<h2>What we can and cannot help with</h2>
<ul>
<li><strong>We can</strong> clarify how client-side editing works, point you to the right tool, and fix documentation mistakes.</li>
<li><strong>We cannot</strong> recover a photo you already closed without downloading, unlock a “perfect” unblur from a smooth blob, or guarantee that a privacy cover will defeat every future enhancer.</li>
</ul>

<h2>Other pages</h2>
<p><a href="{{path:about-us}}">About Us</a> · <a href="{{path:privacy-policy}}">Privacy Policy</a> · <a href="{{path:terms-of-service}}">Terms of Service</a></p>
HTML
	),
);
