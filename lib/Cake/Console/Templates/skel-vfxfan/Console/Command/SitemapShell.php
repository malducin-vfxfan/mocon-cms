<?php
/**
 * Sitemap shell.
 *
 * Application shell to generate a sitemap.xml file to the tmp
 * folder. Useful to submit to search engines.
 *
 * Reuse the $result and $latest_result variables to conserve
 * resources.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       console.command
 * @subpackage    sitemap
 */
class SitemapShell extends AppShell {
/**
 * Uses
 *
 * @var array
 */
	public $uses = array('Page', 'Post', 'Event', 'Album');
/**
 * main method
 *
 * @return void
 */
	public function main() {
		$this->Post->recursive = -1;
		$this->Page->recursive = -1;
		$this->Album->recursive = -1;


		$sitemap = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$sitemap .= "<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\" xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

		$latest_result = $this->Post->find('first', array('order' => 'Post.modified DESC'));
		$sitemap .= "\t<url>\n";
		$sitemap .= "\t\t<loc>".FULL_BASE_URL."</loc>\n";
		$sitemap .= "\t\t<lastmod>".date('Y-m-d', strtotime($latest_result['Post']['modified']))."</lastmod>\n";
		$sitemap .= "\t\t<changefreq>daily</changefreq>\n";
		$sitemap .= "\t\t<priority>1.0</priority>\n";
		$sitemap .= "\t</url>\n";

		$sitemap .= "\t<url>\n";
		$sitemap .= "\t\t<loc>".FULL_BASE_URL.'/posts'."</loc>\n";
		$sitemap .= "\t\t<lastmod>".date('Y-m-d', strtotime($latest_result['Post']['modified']))."</lastmod>\n";
		$sitemap .= "\t\t<changefreq>daily</changefreq>\n";
		$sitemap .= "\t\t<priority>0.9</priority>\n";
		$sitemap .= "\t</url>\n";

		$results = $this->Post->find('all');
		foreach ($results as $post) {
			$sitemap .= "\t<url>\n";
			$sitemap .= "\t\t<loc>".FULL_BASE_URL.'/posts/view/'.$post['Post']['slug']."</loc>\n";
			$sitemap .= "\t\t<lastmod>".date('Y-m-d', strtotime($post['Post']['modified']))."</lastmod>\n";
			$sitemap .= "\t\t<changefreq>yearly</changefreq>\n";
			$sitemap .= "\t\t<priority>0.8</priority>\n";
			$sitemap .= "\t</url>\n";
		}

		$sitemap .= "\t<url>\n";
		$sitemap .= "\t\t<loc>".FULL_BASE_URL.'/events'."</loc>\n";
		$sitemap .= "\t\t<changefreq>weekly</changefreq>\n";
		$sitemap .= "\t\t<priority>0.7</priority>\n";
		$sitemap .= "\t</url>\n";

		$sitemap .= "\t<url>\n";
		$sitemap .= "\t\t<loc>".FULL_BASE_URL.'/events/archive'."</loc>\n";
		$sitemap .= "\t\t<changefreq>weekly</changefreq>\n";
		$sitemap .= "\t\t<priority>0.7</priority>\n";
		$sitemap .= "\t</url>\n";

		$results = $this->Page->find('all', array('order' => 'Page.slug ASC'));
		foreach ($results as $page) {
			$sitemap .= "\t<url>\n";
			$sitemap .= "\t\t<loc>".FULL_BASE_URL.'/pages/view/'.$page['Page']['slug']."</loc>\n";
			$sitemap .= "\t\t<lastmod>".date('Y-m-d', strtotime($page['Page']['modified']))."</lastmod>\n";
			$sitemap .= "\t\t<changefreq>yearly</changefreq>\n";
			$sitemap .= "\t\t<priority>0.7</priority>\n";
			$sitemap .= "\t</url>\n";
		}

		$latest_result = $this->Album->find('first', array('order' => 'Album.modified DESC'));
		$sitemap .= "\t<url>\n";
		$sitemap .= "\t\t<loc>".FULL_BASE_URL.'/albums'."</loc>\n";
		$sitemap .= "\t\t<lastmod>".date('Y-m-d', strtotime($latest_result['Album']['modified']))."</lastmod>\n";
		$sitemap .= "\t\t<changefreq>weekly</changefreq>\n";
		$sitemap .= "\t\t<priority>0.4</priority>\n";
		$sitemap .= "\t</url>\n";

		$results = $this->Album->find('all');
		foreach ($results as $album) {
			$sitemap .= "\t<url>\n";
			$sitemap .= "\t\t<loc>".FULL_BASE_URL.'/albums/view/'.$album['Album']['slug']."</loc>\n";
			$sitemap .= "\t\t<lastmod>".date('Y-m-d', strtotime($album['Album']['modified']))."</lastmod>\n";
			$sitemap .= "\t\t<changefreq>yearly</changefreq>\n";
			$sitemap .= "\t\t<priority>0.4</priority>\n";
			$sitemap .= "\t</url>\n";
		}

		$sitemap .= "</urlset>";

		$this->createFile(TMP.'sitemap.xml', $sitemap);
	}

}
