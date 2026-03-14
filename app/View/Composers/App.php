<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class App extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        '*',
    ];

    /**
     * Retrieve the site name.
     */
    public function siteName(): string
    {
        return get_bloginfo('name', 'display');
    }

    public function siteDescription(): string
    {
        return get_bloginfo('description', 'display');
    }

    /**
     * Build a simple header navigation with a fallback page from WordPress.
     *
     * @return array<int, array<string, mixed>>
     */
    public function headerMenuItems(): array
    {
        $items = [
            [
                'label' => 'Domov',
                'url' => home_url('/'),
                'active' => is_front_page(),
            ],
        ];

        if ($page = $this->findPageBySlugOrTitle('nesme-sa-navzajom', 'Nesme sa navzájom')) {
            $items[] = [
                'label' => 'Nesme sa navzájom',
                'url' => get_permalink($page),
                'active' => is_page($page->ID),
            ];
        }

        return $items;
    }

    protected function findPageBySlugOrTitle(string $slug, string $title): ?\WP_Post
    {
        $page = get_page_by_path($slug, OBJECT, 'page');

        if ($page instanceof \WP_Post) {
            return $page;
        }

        $pages = get_posts([
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'menu_order title',
            'order' => 'ASC',
        ]);

        $needle = $this->normalizeTitle($title);

        foreach ($pages as $candidate) {
            if (! $candidate instanceof \WP_Post) {
                continue;
            }

            $candidateTitle = $this->normalizeTitle(get_the_title($candidate));
            $candidateSlug = $this->normalizeTitle($candidate->post_name);

            if (
                $candidateTitle === $needle ||
                str_contains($candidateTitle, $needle) ||
                str_contains($candidateSlug, $this->normalizeTitle($slug))
            ) {
                return $candidate;
            }
        }

        return null;
    }

    protected function normalizeTitle(string $value): string
    {
        return sanitize_title(remove_accents($value));
    }
}
