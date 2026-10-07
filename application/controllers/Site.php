<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

	private $pages = NULL;
	private $posts = NULL;

	public function index()
	{
		$this->render('pages/home', array(
			'meta' => array(
				'title' => 'Blur & Unblur Image Online – Add or Remove Blur From Photos',
				'description' => 'Free online tool to blur image or unblur image. Add blur effect, blur face and background, or fix blurry photos.',
				'path' => '',
			),
			'nav' => 'home',
			'load_tool' => FALSE,
			'crumbs' => array(
				array('name' => 'Home', 'path' => ''),
			),
			'faqs' => array(
				array(
					'q' => 'Can I blur and unblur an image in the same tool?',
					'a' => '<p>These are opposite jobs, so they live on separate pages. Blur image applies Gaussian or Pixel. Unblur sharpens a blurry photo. Open the page that matches the result you want.</p>',
				),
				array(
					'q' => 'Is this blur image tool free to use?',
					'a' => '<p>Yes. You can blur image files or try to clear a blurry photo in the browser without an account. Processing stays on your device, and the original file is not uploaded.</p>',
				),
				array(
					'q' => 'Do I need to install photo blur app on my device?',
					'a' => '<p>No install is required. Open the blur or unblur page, choose a picture, and adjust the effect. A separate photo blur app is unnecessary for a quick edit.</p>',
				),
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
			'posts' => $this->posts(),
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
			'faqs' => array(),
			'post' => $post,
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

		$this->output->set_content_type('application/xml');
		$this->load->view('pages/sitemap', array('urls' => $urls));
	}

	public function robots()
	{
		$body = "User-agent: *\nAllow: /\n\nSitemap: ".canonical_url('sitemap.xml', FALSE)."\n";
		$this->output->set_content_type('text/plain', 'UTF-8')->set_output($body);
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
