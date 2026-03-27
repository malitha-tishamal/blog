<?php
/**
 * SEO Helper Utility
 * Centrally manages meta tags and schema markup for the portfolio.
 */

function get_seo_meta($page = 'home', $custom_data = []) {
    $default_title = "Malitha Tishamal | Software Developer Portfolio";
    $default_desc = "Professional portfolio of Malitha Tishamal, a Software Developer specializing in Web and Mobile applications (Flutter, PHP, Java). Explore my journey, projects, and certifications.";
    $author = "Malitha Tishamal";
    $site_url = "https://malithatishamal.42web.io";

    $seo = [
        'title' => $default_title,
        'description' => $default_desc,
        'keywords' => "Malitha Tishamal, Software Developer, Portfolio, Web Development, Flutter, Mobile Apps, Java Developer, Sri Lanka",
        'og_image' => "$site_url/assets/img/profile-img.jpg",
        'url' => $site_url
    ];

    if ($page !== 'home' && !empty($custom_data)) {
        if (isset($custom_data['title'])) $seo['title'] = $custom_data['title'] . " | " . $author;
        if (isset($custom_data['description'])) $seo['description'] = $custom_data['description'];
        if (isset($custom_data['keywords'])) $seo['keywords'] = $custom_data['keywords'];
        if (isset($custom_data['url'])) $seo['url'] = $custom_data['url'];
    }

    return $seo;
}

function render_schema_json($type = 'person') {
    $site_url = "https://malithatishamal.42web.io";
    
    if ($type === 'person') {
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "Person",
            "name" => "Malitha Tishamal",
            "url" => $site_url,
            "jobTitle" => "Software Developer",
            "sameAs" => [
                "https://github.com/malitha-tishamal",
                "https://linkedin.com/in/malitha-tishamal" // replace with actual if known
            ],
            "description" => "Aspiring Software Developer with experience in Flutter, PHP, and Java application development."
        ];
    } else {
        return "";
    }

    return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
}
?>
