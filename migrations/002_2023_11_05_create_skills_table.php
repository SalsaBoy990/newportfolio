<?php

/* Create posts table */
return new class extends Model {
    public function up(): void
    {
        $this->exec(
            "CREATE TABLE IF NOT EXISTS `skills` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `language` ENUM('en-gb','hu-hu') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en-gb',
                `title` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                `content` TEXT COLLATE utf8mb4_unicode_ci NOT NULL,
                `bg_color` VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT 'bg-main-800',
                `created_at` DATETIME NULL DEFAULT NOW(),
                `updated_at` DATETIME NULL DEFAULT NOW(),
                PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
        );

        /* Insert dummy data */
        $this->exec(
<<<SQL
INSERT INTO `skills` (`id`, `language`, `title`, `content`, `bg_color`, `created_at`, `updated_at`) VALUES
        (1, 'en-gb', 'JavaScript development', '<ul class=\"list-disc text-white87pc\">\r\n                    <li>React</li>\r\n                    <li>TypeScript</li>\r\n                    <li>Gatsby.js</li>\r\n                    <li>Vue.js</li>\r\n                    <li>jQuery library</li>\r\n                    <li>Strapi CMS</li>\r\n                    <li>Node.js <small>(basics)</small></li>\r\n                </ul>', 'bg-main-800', '2022-09-06 14:43:02', '2022-09-06 14:43:02'),
        (2, 'hu-hu', 'JavaScript fejlesztés', '<ul class=\"list-disc text-white87pc\">\r\n                    <li>React</li>\r\n                    <li>TypeScript</li>\r\n                    <li>Gatsby.js</li>\r\n                    <li>Vue.js</li>\r\n                    <li>jQuery könyvtár</li>\r\n                    <li>Strapi CMS</li>\r\n                    <li>Node.js <small>(alapok)</small></li>\r\n                </ul>', 'bg-main-800', '2022-09-06 14:43:02', '2022-09-06 14:43:02'),
        (3, 'en-gb', 'PHP, CMS, database', '<ul class=\"list-disc text-white87pc\">\r\n                    <li>PHP 7-8</li>\r\n                    <li>MySQL</li>\r\n                    <li>WordPress</li>\r\n                    <li>Magento 2</li>\r\n                    <li>Laravel <small>(under learning)</small></li>\r\n                    <li>Drupal CMS <small>(basics)</small></li>\r\n                </ul>', 'bg-grass-green', '2022-09-06 14:43:02', '2022-09-06 14:43:02'),
        (4, 'hu-hu', 'PHP, CMS, adatbázis', '<ul class=\"list-disc text-white87pc\">\r\n                    <li>PHP 7-8</li>\r\n                    <li>MySQL</li>\r\n                    <li>WordPress</li>\r\n                    <li>Magento 2</li>\r\n                    <li>Laravel <small>(tanulás alatt)</small></li>\r\n                    <li>Drupal CMS <small>(alapok)</small></li>\r\n                </ul>', 'bg-grass-green', '2022-09-06 14:43:02', '2022-09-06 14:43:02'),
        (5, 'en-gb', 'HTML, CSS, sitebuild', '<ul class=\"list-disc text-white87pc\">\r\n                    <li>Bootstrap 3-5</li>\r\n                    <li>TailwindCSS</li>\r\n                    <li>Bulma</li>\r\n                    <li>LESS, SCSS preprocessors</li>\r\n                    <li>HTML</li>\r\n                    <li>CSS</li>\r\n                </ul>', 'bg-turquoise', '2022-09-06 14:43:02', '2022-09-06 14:43:02'),
        (6, 'hu-hu', 'HTML, CSS, sitebuild', '<ul class=\"list-disc text-white87pc\">\r\n                    <li>Bootstrap 3-5</li>\r\n                    <li>TailwindCSS</li>\r\n                    <li>Bulma</li>\r\n                    <li>LESS, SCSS preprocesszorok</li>\r\n                    <li>HTML</li>\r\n                    <li>CSS</li>\r\n                </ul>', 'bg-turquoise', '2022-09-06 14:43:02', '2022-09-06 14:43:02'),
        (7, 'en-gb', 'Git, Docker, Linux etc.', '<ul class=\"list-disc text-white87pc\">\r\n                    <li>Git flow methodology</li>\r\n                    <li>Docker dev environments</li>\r\n                    <li>Ubuntu linux distro</li>\r\n                    <li>Bundling tool: Webpack</li>\r\n                </ul>', 'bg-brown', '2022-09-06 14:43:02', '2022-09-06 14:43:02'),
        (8, 'hu-hu', 'Git, Docker, Linux stb.', '<ul class=\"list-disc text-white87pc\">\r\n                    <li>Git flow módszertan</li>\r\n                    <li>Docker fejlesztői környezetek</li>\r\n                    <li>Ubuntu linux disztribúció</li>\r\n                    <li>Bundling eszköz: Webpack</li>\r\n                </ul>', 'bg-brown', '2022-09-06 14:43:02', '2022-09-06 14:43:02'),
        (9, 'en-gb', 'Other skills', '<ul class=\"list-disc text-white87pc\">\r\n                    <li>English <small>intermediate</small></li>\r\n                    <li>Github, Gitlab</li>\r\n                    <li>Jira, Redmine</li>\r\n                </ul>', 'bg-main-400', '2022-09-06 14:43:02', '2022-09-06 14:43:02'),
        (10, 'hu-hu', 'Egyéb képességek', '<ul class=\"list-disc text-white87pc\">\r\n                    <li>Angol <small>(közepes)</small></li>\r\n                    <li>Github, Gitlab</li>\r\n                    <li>Jira, Redmine</li>\r\n                </ul>', 'bg-main-400', '2022-09-06 14:43:02', '2022-09-06 14:43:02'),
        (11, 'en-gb', 'UI/UX design knowledge', '<p>Completed the Digital Product Design course of UXStudio, in Budapest</p>\n                <p>Design Software: Figma</p>\n                <p>Images, graphics: GIMP 2</p>\n                <p>Video editing: KdenLive</p>', 'bg-darkpurple', '2022-09-06 14:43:02', '2022-09-06 14:43:02'),
        (12, 'hu-hu', 'UI/UX design ismeret', '<p>Az UXStudio Digital Product Design kurzusának elvégzése Budapesten</p>\n                <p>Design szoftver: Figma</p>\n                <p>Képek és grafikák: GIMP 2</p>\n                <p>Videószerkesztés: KdenLive</p>', 'bg-darkpurple', '2022-09-06 14:43:02', '2022-09-06 14:43:02');
SQL
       );


    }

    public function down(): void
    {
        $this->exec("DROP TABLE `skills`;");
    }
};
