<?php defined('BASEPATH') OR exit('No direct script access allowed');
$category_labels = array(
	'blur-privacy' => 'Blur & Privacy',
	'restoration' => 'Photo Restoration',
);
?>
<article class="sheet blog-index">
	<?php $this->load->view('partials/breadcrumbs', array('crumbs' => $crumbs)); ?>
	<h1>Image Editing &amp; Photo Utility Guides</h1>
	<p class="dek">Easy-to-follow tutorials, photography tips, and web image processing guides. Learn how to blur, restore, and work with photos in the browser.</p>

	<nav class="blog-cats" aria-label="Guide categories">
		<button type="button" class="blog-cat is-active" data-cat="all" aria-pressed="true">All Articles</button>
		<button type="button" class="blog-cat" data-cat="blur-privacy" aria-pressed="false">Blur &amp; Privacy</button>
		<button type="button" class="blog-cat" data-cat="restoration" aria-pressed="false">Photo Restoration</button>
	</nav>

	<ul class="post-list" id="blog-post-list">
		<?php foreach ($posts as $post):
			$cat = ! empty($post['category']) ? $post['category'] : '';
			$label = isset($category_labels[$cat]) ? $category_labels[$cat] : '';
		?>
		<li data-cat="<?= html_escape($cat) ?>">
			<?php if ($label !== ''): ?>
			<p class="post-cat"><span class="kicker"><?= html_escape($label) ?></span></p>
			<?php endif; ?>
			<p class="post-date"><time datetime="<?= html_escape($post['date']) ?>"><?= html_escape(format_date($post['date'])) ?></time></p>
			<h2><a href="<?= html_escape(page_url($post['path'])) ?>"><?= html_escape($post['h1']) ?></a></h2>
			<p><?= html_escape($post['excerpt']) ?></p>
		</li>
		<?php endforeach; ?>
	</ul>
	<p class="blog-empty" id="blog-empty" hidden>No guides in this category yet.</p>
</article>
<script>
(function () {
	var nav = document.querySelector('.blog-cats');
	var list = document.getElementById('blog-post-list');
	var empty = document.getElementById('blog-empty');
	if (!nav || !list) return;
	var buttons = nav.querySelectorAll('.blog-cat');
	var items = list.querySelectorAll('li');
	function apply(cat) {
		var visible = 0;
		Array.prototype.forEach.call(items, function (li) {
			var show = cat === 'all' || li.getAttribute('data-cat') === cat;
			li.hidden = !show;
			if (show) visible++;
		});
		if (empty) empty.hidden = visible > 0;
		Array.prototype.forEach.call(buttons, function (btn) {
			var on = btn.getAttribute('data-cat') === cat;
			btn.classList.toggle('is-active', on);
			btn.setAttribute('aria-pressed', on ? 'true' : 'false');
		});
	}
	nav.addEventListener('click', function (e) {
		var btn = e.target.closest('.blog-cat');
		if (!btn || !nav.contains(btn)) return;
		apply(btn.getAttribute('data-cat') || 'all');
	});
})();
</script>
