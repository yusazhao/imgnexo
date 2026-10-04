<?php defined('BASEPATH') OR exit('No direct script access allowed'); echo '<?xml version="1.0" encoding="UTF-8" ?'.'>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $url): ?>
	<url><loc><?= htmlspecialchars(canonical_url($url['path'], $url['trailing']), ENT_XML1, 'UTF-8') ?></loc></url>
<?php endforeach; ?>
</urlset>
