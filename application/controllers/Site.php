<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

	private $pages = NULL;
	private $posts = NULL;
	private $info_pages = NULL;
	private $site_info = NULL;

	public function index()
	{
		$this->render('pages/home', array(
			'meta' => array(
				'title' => 'Free Online Image Utilities & Photo Tools | Imgnexo',
				'description' => 'Easy-to-use, browser-based image tools from Imgnexo. Blur faces, text, and backgrounds, or fix blurry and motion-blurred photos—processing stays on your device.',
				'path' => '',
			),
			'nav' => 'home',
			'load_tool' => FALSE,
			'crumbs' => array(),
			'faqs' => array(
				array(
					'q' => 'What image tools are available on Imgnexo?',
					'a' => '<p>We offer image blurring, photo unblurring, and motion blur restoration—all accessible online for free. The suite is built so more utilities can be added over time.</p>',
				),
				array(
					'q' => 'Is my uploaded photo kept private?',
					'a' => '<p>Yes. Your images stay in your browser and are not uploaded or saved to external servers for processing.</p>',
				),
				array(
					'q' => 'Are all photo tools completely free to use?',
					'a' => '<p>Yes. All tools are free, with no account or registration required.</p>',
				),
			),
			'schema_home' => TRUE,
			'collection_items' => array(
				array('name' => 'Blur Image Online', 'path' => 'blur-image', 'description' => 'Add Gaussian or Pixel blur to a picture in the browser.'),
				array('name' => 'Unblur Image Online', 'path' => 'unblur-image', 'description' => 'Fix mild soft-focus photos with a clarity pass in the browser.'),
				array('name' => 'Blur Photo Background', 'path' => 'blur-image/background', 'description' => 'Soften the background while keeping the subject clearer.'),
				array('name' => 'Blur Face in Photo', 'path' => 'blur-image/face', 'description' => 'Cover faces with Pixel, Gaussian, or a black bar.'),
				array('name' => 'Blur Text in Photo', 'path' => 'blur-image/text', 'description' => 'Find and redact writing in screenshots and documents.'),
				array('name' => 'Blur Effects', 'path' => 'blur-image/effect', 'description' => 'Apply Gaussian, Pixel, Motion, Radial, and related looks.'),
				array('name' => 'Fix Motion Blur Photo', 'path' => 'unblur-image/motion-blur', 'description' => 'Directional deblur for streaked camera shake.'),
			),
		));
	}

	public function blur($slug = '')
	{
		$this->show_page('blur', $slug, 'blur');
	}

	public function unblur($slug = '')
	{
		if (trim($slug, '/') === 'photos')
		{
			header('Location: '.canonical_url('unblur-image'), TRUE, 301);
			exit;
		}

		$this->show_page('unblur', $slug, 'unblur');
	}

	public function blog()
	{
		$posts = $this->posts();
		$items = array();

		foreach ($posts as $post)
		{
			$items[] = array(
				'name' => $post['h1'],
				'path' => $post['path'],
				'description' => $post['excerpt'],
				'date' => $post['date'],
			);
		}

		$this->render('pages/blog_index', array(
			'meta' => array(
				'title' => 'Photo Blur Guides – Make Pictures Blurry or Fix Blurry Photos',
				'description' => 'Tutorials for blur image edits and blurry photo repair: gaussian blur, blur face in photo, remove blur from photo, and motion blur limits.',
				'path' => 'blog',
			),
			'nav' => 'blog',
			'crumbs' => array(
				array('name' => 'Home', 'path' => ''),
				array('name' => 'Blog', 'path' => 'blog'),
			),
			'faqs' => array(),
			'posts' => $posts,
			'schema_blog' => TRUE,
			'collection_items' => $items,
		));
	}

	public function article($slug = '')
	{
		$post = $this->find_post($slug);

		if ( ! $post)
		{
			return $this->not_found();
		}

		$post = $this->expand_tree($post);

		$this->render('pages/article', array(
			'meta' => array(
				'title' => $post['title'],
				'description' => $post['description'],
				'path' => $post['path'],
			),
			'nav' => 'blog',
			'crumbs' => $post['crumbs'],
			'faqs' => ! empty($post['faqs']) ? $post['faqs'] : array(),
			'post' => $post,
		));
	}

	public function info($slug = '')
	{
		$page = $this->find_info_page($slug);

		if ( ! $page)
		{
			return $this->not_found();
		}

		$page = $this->expand_info_page($page);

		$this->render('pages/info', array(
			'meta' => array(
				'title' => $page['title'],
				'description' => $page['description'],
				'path' => $page['path'],
			),
			'nav' => 'home',
			'crumbs' => $page['crumbs'],
			'faqs' => array(),
			'page' => $page,
			'organization' => ($page['slug'] === 'about-us') ? $this->organization_schema() : NULL,
		));
	}

	public function sitemap()
	{
		$urls = array(array('path' => '', 'trailing' => TRUE));
		$urls[] = array('path' => 'blog', 'trailing' => TRUE);

		foreach ($this->pages() as $page)
		{
			$urls[] = array('path' => $page['path'], 'trailing' => TRUE);
		}

		foreach ($this->posts() as $post)
		{
			$urls[] = array('path' => $post['path'], 'trailing' => TRUE);
		}

		foreach ($this->info_pages() as $page)
		{
			$urls[] = array('path' => $page['path'], 'trailing' => TRUE);
		}

		$this->output->set_content_type('application/xml');
		$this->load->view('pages/sitemap', array('urls' => $urls));
	}

	public function not_found()
	{
		$this->output->set_status_header(404);
		$this->render('pages/not_found', array(
			'meta' => array(
				'title' => 'Page not found',
				'description' => 'That page is not on this site.',
				'path' => '',
				'robots' => 'noindex, follow',
			),
			'nav' => 'home',
			'crumbs' => array(),
			'faqs' => array(),
		));
	}

	private function show_page($group, $slug, $nav)
	{
		$page = $this->find_page($group, $slug === '' ? 'index' : $slug);

		if ( ! $page)
		{
			return $this->not_found();
		}

		$page = $this->expand_tree($page);

		$this->render('pages/landing', array(
			'meta' => array(
				'title' => $page['title'],
				'description' => $page['description'],
				'path' => $page['path'],
			),
			'nav' => $nav,
			'crumbs' => $page['crumbs'],
			'faqs' => $page['faqs'],
			'page' => $page,
			'load_tool' => ! empty($page['tool']),
			'schema_webapp' => ! empty($page['tool']),
		));
	}

	private function render($view, $data)
	{
		if ( ! isset($data['load_tool']))
		{
			$data['load_tool'] = FALSE;
		}

		$this->load->view('layout/header', $data);
		$this->load->view($view, $data);
		$this->load->view('layout/footer', $data);
	}

	private function find_page($group, $slug)
	{
		foreach ($this->pages() as $page)
		{
			if ($page['group'] === $group && $page['slug'] === $slug)
			{
				return $page;
			}
		}

		return NULL;
	}

	private function find_post($slug)
	{
		foreach ($this->posts() as $post)
		{
			if ($post['slug'] === $slug)
			{
				return $post;
			}
		}

		return NULL;
	}

	private function pages()
	{
		if ($this->pages === NULL)
		{
			$this->pages = array_merge(
				include APPPATH.'content/blur_pages.php',
				include APPPATH.'content/unblur_pages.php'
			);
		}

		return $this->pages;
	}

	private function posts()
	{
		if ($this->posts === NULL)
		{
			$this->posts = include APPPATH.'content/posts.php';
			usort($this->posts, function ($a, $b) {
				return strcmp($b['date'], $a['date']);
			});
		}

		return $this->posts;
	}

	private function info_pages()
	{
		if ($this->info_pages === NULL)
		{
			$this->info_pages = include APPPATH.'content/info_pages.php';
		}

		return $this->info_pages;
	}

	private function find_info_page($slug)
	{
		$slug = trim($slug, '/');

		foreach ($this->info_pages() as $page)
		{
			if ($page['slug'] === $slug)
			{
				return $page;
			}
		}

		return NULL;
	}

	private function site_info()
	{
		if ($this->site_info === NULL)
		{
			$this->site_info = include APPPATH.'config/site_info.php';
		}

		return $this->site_info;
	}

	private function expand_info_page($page)
	{
		$info = $this->site_info();
		$email = trim(isset($info['contact_email']) ? $info['contact_email'] : '');
		$operator = trim(isset($info['operator_name']) ? $info['operator_name'] : '');
		$jurisdiction = trim(isset($info['jurisdiction']) ? $info['jurisdiction'] : '');
		$effective = isset($info['effective_date']) ? $info['effective_date'] : '';
		$response = isset($info['response_window']) ? $info['response_window'] : 'within a few business days';
		$brand = isset($info['brand']) ? $info['brand'] : 'Imgnexo';

		if ($operator !== '')
		{
			$operator_line = html_escape($operator).' operates this website and publishes free browser photo tools under the brand <strong>'.html_escape($brand).'</strong>.';
			$operator_short = html_escape($operator);
			$about_operator = '<p>'.html_escape($operator).' publishes Imgnexo. We focus on clear product limits rather than marketing claims that the tools cannot keep.</p>';
		}
		else
		{
			$operator_line = 'This website is published under the brand <strong>'.html_escape($brand).'</strong>. Free browser tools to blur or unblur photos are offered without an account.';
			$operator_short = html_escape($brand);
			$about_operator = '<p>Imgnexo is published as an independent browser-tools project. The legal operator name will be listed here once confirmed. Until then, treat the brand name Imgnexo as the public face of the service, and use <a href="'.html_escape(page_url('contact')).'">Contact</a> for accountability requests.</p>';
		}

		if ($email !== '')
		{
			$safe = html_escape($email);
			$contact_block = '<p>Email: <a href="mailto:'.$safe.'">'.$safe.'</a></p>';
		}
		else
		{
			$contact_block = '<p>A public support email is not listed yet. Add <code>contact_email</code> in the site identity config before launch, or reach us through the channel your host provides while that field is empty.</p>';
		}

		if ($jurisdiction !== '')
		{
			$jurisdiction_block = 'These terms are governed by the laws of '.html_escape($jurisdiction).', without regard to conflict-of-law rules. Courts in that jurisdiction may hear disputes, except where consumer law gives you mandatory rights elsewhere.';
		}
		else
		{
			$jurisdiction_block = 'Governing law and venue will follow the place where the operator is established once that is published on this site. Until a jurisdiction is listed in the site identity config, mandatory consumer protections in your country still apply where they cannot be waived.';
		}

		$tokens = array(
			'{{effective_date}}' => html_escape(format_date($effective)),
			'{{operator_line}}' => $operator_line,
			'{{operator_short}}' => $operator_short,
			'{{about_operator}}' => $about_operator,
			'{{contact_block}}' => $contact_block,
			'{{jurisdiction_block}}' => $jurisdiction_block,
			'{{response_window}}' => html_escape($response),
		);

		$page = $this->expand_tree($page);

		foreach ($page as $key => $value)
		{
			if (is_string($value))
			{
				$page[$key] = strtr($value, $tokens);
			}
		}

		return $page;
	}

	private function organization_schema()
	{
		$info = $this->site_info();
		$org = array(
			'@type' => 'Organization',
			'name' => isset($info['brand']) ? $info['brand'] : 'Imgnexo',
			'url' => canonical_url(''),
			'description' => 'Free browser tools to blur or unblur photos. Image edits run on your device.',
		);

		if ( ! empty($info['operator_name']))
		{
			$org['legalName'] = $info['operator_name'];
		}

		if ( ! empty($info['contact_email']))
		{
			$org['email'] = $info['contact_email'];
		}

		return $org;
	}

	private function expand_tree($value)
	{
		if (is_string($value))
		{
			return preg_replace_callback('/\{\{path:([^}]+)\}\}/', function ($matches) {
				return page_url($matches[1]);
			}, $value);
		}

		if (is_array($value))
		{
			foreach ($value as $key => $item)
			{
				$value[$key] = $this->expand_tree($item);
			}
		}

		return $value;
	}
}
