<?php

/* Create posts table */
return new class extends Model {
    public function up(): void
    {
        $this->exec(
            "CREATE TABLE IF NOT EXISTS `projects` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `language` enum('en-gb','hu-hu') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en-gb',
            `title` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `client` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
            `cover_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `links` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
            `order` INT DEFAULT NULL,
            `created_at` DATETIME NOT NULL DEFAULT NOW(),
            `updated_at` DATETIME NOT NULL DEFAULT NOW(),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        /* Insert dummy data */
        $this->exec(
<<<SQL
INSERT INTO `projects` (`id`, `language`, `title`, `client`, `content`, `cover_image`, `links`, `order`, `created_at`, `updated_at`) VALUES
(1, 'en-gb', 'Numizmatika app', 'Client: “Pénzmúzeum” (at DRB Services, 2022)', '<p>React / Gatsby (in JavaScript) app for digital interactive table (1920x1080px), with Strapi CMS backend. It is made for a museum called “Pénzmúzeum” (Money Museum), next to Széll Kálmán square, Budapest.</p>', 'public/uploads/1662596059-numizmatika.jpg', '<nav class=\"flex flex-wrap space-x-2 justify-evenly items-center\"><a class=\"link\" href=\"https://work.drb.services/V_numizmatika/\">Numizmatika WEBSITE</a></nav>', 7, '2022-09-06 17:20:51', '2022-09-07 22:14:50'),
(2, 'hu-hu', 'Numizmatika app', 'Kliens: “Pénzmúzeum” (DRB Services-nél, 2022)', '<p>Numizmatika: React/Gatsby (JavaScript) alkalmazás fullstack fejlesztése digitális interaktív táblára (1920*1080px), Strapi backend-del. Megtekinthető a Pénzmúzeumban (Postapalota, Széll Kálmán tér mellett).</p>', 'public/uploads/1662596695-numizmatika.jpg', '<nav class=\"flex flex-wrap space-x-2 justify-evenly items-center\"><a class=\"link\" href=\"https://work.drb.services/V_numizmatika/\">Numizmatika WEBOLDAL</a></nav>', 7, '2022-09-06 17:20:51', '2022-09-07 22:24:55'),
(3, 'en-gb', 'UDG landing page', 'Client: “Urben Design Group” (at DRB Services, 2022)', '<p>React/Gatsby (in TypeScript), backend: Strapi CMS with Postgres database. Handling projects, pages, taxonomies. Developing Strapi components fpr dynamic zone fields (basically it provides a drag and drop pagebuilder with existing components to add, reorder, or delete). Contact form with Nodemailer and MailGrid.</p>\n<p>The Github repo contains an updated starter project for an imagery brand, the StarCity Group. This starter is an improved version.</p>', 'public/uploads/1662596151-starcity.jpg', '<nav class=\"flex flex-wrap space-x-2 justify-evenly items-center\"><a class=\"link\" href=\"https://github.com/SalsaBoy990/gatsby4-frontend-for-strapi\">GITHUB (frontend)</a> <a class=\"link\" href=\"https://github.com/SalsaBoy990/strapi4-backend\">GITHUB (backend)</a> <a class=\"link\" href=\"https://starcitygroup.netlify.app/\">WEBSITE</a></nav>', 6, '2022-09-06 17:20:51', '2022-09-07 22:15:51'),
(4, 'hu-hu', 'UDG landing oldal', 'Kliens: “Urben Design Group” (DRB Services-nél, 2022)', '<p>UDG: React/Gatsby v4 TypeScript-tel, backend: Strapi v4, Postgres, GraphQL használatával. Projektek, oldalak kezelése, amelyek taxonómiai kategóriákba tartoznak. Strapi komponensek fejlesztése, amelyek dynamiczone mezőhöz hozzáadhatók (egy page builder-hez hasonlatosan adhatunk hozzá egyedi komponenseket egy ilyen mezőhöz, amelyek sorrendje változtatható). Kapcsolatfelvétel - Nodemailer, MailGrid integráció.</p>', 'public/uploads/1662596726-starcity.jpg', '<nav class=\"flex flex-wrap space-x-2 justify-evenly items-center\"><a class=\"link\" href=\"https://github.com/SalsaBoy990/gatsby4-frontend-for-strapi\">GITHUB (frontend)</a> <a class=\"link\" href=\"https://github.com/SalsaBoy990/strapi4-backend\">GITHUB (backend)</a> <a class=\"link\" href=\"https://starcitygroup.netlify.app/\">WEBOLDAL</a></nav>', 6, '2022-09-06 17:20:51', '2022-09-07 22:25:26'),
(5, 'en-gb', 'Home Assistant admin app', 'Client: BarbeQUBE (at DRB Services, 2022)', '<p>React (TypeScript) IoT app. The client provides containers equipped with fridge, oven, ventillators, lights etc. for rent near turistic areas. The equipments have sensors and can be controlled remotely. The smart devices can be switched on/off, their settings modified by calling REST API endpoints. The sensory data is continuously received through an MQTT server. The app is made for Samsung Galaxy Tab A7 Lite SM-T 220 tablet. The test backend is running on a Rasberry Pi. In addition, there is a React Native app (for customers) where I had to create screens showing the state of the test container.</p>', 'public/uploads/1662596445-home-assistant-app.jpg', '', 5, '2022-09-06 17:20:51', '2022-09-07 22:20:45'),
(6, 'hu-hu', 'Home Assistant admin app', 'Kliens: BarbeQUBE (DRB Services-nél, 2022)', '<p>React/TypeScript (teljes app), React Native technológiákkal (egy meglévő appba integráció). A BarbeQUBE konténereket biztosít bérlésre, turisztikai objektumok közelében. E kockák belseje fel van szerelve főzőlapokkal, grillsütővel, hűtővel, vízcsappal, ventillátorokkal, lámpákkal, ami az appon keresztül vezérelhetők, illetve a szenzorok által jelzett állapotuk távolról lekérdezhető (IoT).</p>\n<p>Az okoseszközök REST API végpontok meghívásával vezérelhetők. A szenzorok adatait MQTT szerveren keresztül kapom meg. A sima React app Samsung Galaxy Tab A7 Lite SM-T 220 tablethez készült. A teszt backend Rasberry Pi-on fut.</p>', 'public/uploads/1662596752-home-assistant-app.jpg', '', 5, '2022-09-06 17:20:51', '2022-09-07 22:25:52'),
(7, 'en-gb', 'Magento 2 stores - frontend development', 'So Fragrance, Cutler &amp; Gross, Musicarzenal (at DRB)', '<ul>\n<li>Create store for So Fragrance’s Auora and Bespoke perfume brands based on design plans (in collab with another dev).</li>\n<li>Bugfixes, management and smaller new feature implementations for Cutler and Gross, a British luxury eyewear brand.</li>\n<li>Theme development for Hangszerarzenál / Musicarsenal store (a musical instruments store)</li>\n</ul>', 'public/uploads/1662596484-magento2.jpg', '<nav class=\"flex flex-wrap space-x-2 justify-evenly items-center\"><a class=\"link\" href=\"https://www.bespokelondonfragrance.com/\">Bespoke</a> <a class=\"link\" href=\"https://www.cutlerandgross.com\">Cutler&amp;Gross</a> <a class=\"link\" href=\"https://hangszerarzenal.testit.zone/\">Hangszerarzenál</a></nav>', 4, '2022-09-06 17:20:51', '2022-09-07 22:21:24'),
(8, 'hu-hu', 'Magento 2 áruházak frontend fejlesztése', 'So Fragrance, Cutler &amp; Gross, Hangszerarzenál számára (DRB-nél)', '<ul>\n<li>So Fragrance: Auora és Bespoke brand számára store építése designterv alapján</li>\n<li>Cutler and Gross karbantartás és új feature-ök fejlesztése meglévő áruházhoz</li>\n<li>Hangszerarzenál áruház elkészítése design alapján</li>\n</ul>', 'public/uploads/1662596777-magento2.jpg', '<nav class=\"flex flex-wrap space-x-2 justify-evenly items-center\"><a class=\"link\" href=\"https://www.bespokelondonfragrance.com/\">Bespoke</a> <a class=\"link\" href=\"https://www.cutlerandgross.com\">Cutler&amp;Gross</a> <a class=\"link\" href=\"https://hangszerarzenal.testit.zone/\">Hangszerarzenál</a></nav>', 4, '2022-09-06 17:20:51', '2022-09-07 22:26:17'),
(9, 'en-gb', 'Shopify webshop - frontend', 'Client: JadedLondon (at DRB Services, 2022)', '<p>Managing, bugfixing the store, implementing small frontend features. JadedLondon is a streetwear, fashion brand based in UK.</p>', 'public/uploads/1662596534-shopify.jpg', '<nav class=\"flex flex-wrap space-x-2 justify-evenly items-center\"><a class=\"link\" href=\"https://jadedldn.com/\">JadedLondon</a></nav>', 8, '2022-09-06 17:20:51', '2022-09-07 22:22:14'),
(10, 'hu-hu', 'Shopify webshop - frontend', 'Kliens: JadedLondon (DRB Services-nél, 2022)', '<p>Az áruház karbantartása, bugfixes, kisebb összetevők fejlesztése. JadedLondon egy utcai ruházati márka Nagy-Britanniában.</p>', 'public/uploads/1662596793-shopify.jpg', '<nav class=\"flex flex-wrap space-x-2 justify-evenly items-center\"><a class=\"link\" href=\"https://jadedldn.com/\">JadedLondon</a></nav>', 8, '2022-09-06 17:20:51', '2022-09-07 22:26:33'),
(11, 'en-gb', 'static-site-express', 'My static site generator ( 2019-)', '<p>static-site-express is a simple Node.js based static-site generator that uses EJS and Markdown. Deploy your static site to Netlify or any platform to your liking. Suited for landing pages, portfolio, blogs, documentation, hobby projects.</p>', 'public/uploads/1662596569-static-site-express.jpg', '<nav class=\"flex flex-wrap space-x-2 justify-evenly items-center\"><a class=\"link\" href=\"https://github.com/SalsaBoy990/static-site-express\">GITHUB</a> <a class=\"link\" href=\"https://static-site-express.netlify.app/\">WEBSITE</a></nav>', 3, '2022-09-06 17:20:51', '2022-09-07 22:22:49'),
(12, 'hu-hu', 'static-site-express', 'A statikus oldalgenerátorom ( 2019-)', '<p>static-site-express egy egyszerű Node.js-alapú, EJS-t és Markdown-t használó statikus oldalgenerátor. Kiélesítheted a statikus weboldaladat Netlify-ra, vagy egyéb általad preferált platformra. Alkalmas landing oldalakhoz, portfólióhoz, bloghoz, dokumentációhoz és hobbiprojektekhez.</p>', 'public/uploads/1662596816-static-site-express.jpg', '<nav class=\"flex flex-wrap space-x-2 justify-evenly items-center\"><a class=\"link\" href=\"https://github.com/SalsaBoy990/static-site-express\">GITHUB</a> <a class=\"link\" href=\"https://static-site-express.netlify.app/\">WEBOLDAL</a></nav>', 3, '2022-09-06 17:20:51', '2022-09-07 22:26:56'),
(13, 'en-gb', 'WordPress development', 'Client: Simirity (at DRB Services, 2022-)', '<p>Improving a WordPress marketing website, implementing subpages based on UI design, creating custom WP Backery page builder components. I received a half-done website.</p>', 'public/uploads/1662596638-simirity.jpg', '<nav class=\"flex flex-wrap space-x-2 justify-evenly items-center\"><a class=\"link\" href=\"https://www.simirity.com/\">SIMIRITY WEBSITE</a></nav>', 2, '2022-09-06 17:20:51', '2022-09-07 22:23:58'),
(14, 'hu-hu', 'WordPress fejlesztés', 'Kliens: Simirity (DRB Services-nél, 2022-)', '<p>WordPress marketing oldal továbbfejlesztése, oldalak implementálása design alapján, egyedi WP Backery page builder komponensek készítése (meglevő, félkész projektet kaptam).</p>', 'public/uploads/1662596843-simirity.jpg', '<nav class=\"flex flex-wrap space-x-2 justify-evenly items-center\"><a class=\"link\" href=\"https://www.simirity.com/\">SIMIRITY WEBOLDAL</a></nav>', 2, '2022-09-06 17:20:51', '2022-09-07 22:27:23'),
(15, 'en-gb', 'WordPress / WooCommerce projects', 'My hobby projects, (2021-2022)', '<ul>\n<li><strong>Vuecommerce</strong> Vue.js WP plugin for posts and products (filtering by categories and attributes, search, pagination) making requests throught REST APIs.</li>\n<li><strong>Wulma</strong>: a WordPress theme using the Bulma CSS framework, with Vue.js admin for the theme (in progress)</li>\n<li><strong>Docker development environment</strong> for WP projects with the Bedrock boilerplate</li>\n<li>Docker setup for local WordPress development, custom domain, https, nginx reverse proxy</li>\n</ul>', 'public/uploads/1662596666-vuecommerce.jpg', '<nav class=\"flex flex-wrap space-x-2 justify-evenly items-center\"><a class=\"link\" href=\"https://github.com/SalsaBoy990/vuecommerce-plugin-wp-bedrock\">VUECOMMERCE</a> <a class=\"link\" href=\"https://github.com/SalsaBoy990/wulma\">WULMA</a> <a class=\"link\" href=\"https://github.com/SalsaBoy990/docker-wp-bedrock\">Docker-Bedrock</a> <a class=\"link\" href=\"https://github.com/SalsaBoy990/docker-wordpress\">Docker-WORDPRESS</a></nav>', 1, '2022-09-06 17:20:51', '2022-09-07 22:24:26'),
(16, 'hu-hu', 'WordPress / WooCommerce projektek', 'My hobby projects, (2021-2022)', '<ul>\n<li><strong>Vuecommerce</strong> Vue.js WP plugin for posts and products (filtering by categories and attributes, search, pagination) making requests throught REST APIs.</li>\n<li><strong>Wulma</strong>: a WordPress theme using the Bulma CSS framework, with Vue.js admin for the theme (in progress)</li>\n<li><strong>Docker development environment</strong> for WP projects with the Bedrock boilerplate</li>\n<li>Docker setup for local WordPress development, custom domain, https, nginx reverse proxy</li>\n</ul>', 'public/uploads/1662596890-vuecommerce.jpg', '<nav class=\"flex flex-wrap space-x-2 justify-evenly items-center\"><a class=\"link\" href=\"https://github.com/SalsaBoy990/vuecommerce-plugin-wp-bedrock\">VUECOMMERCE</a> <a class=\"link\" href=\"https://github.com/SalsaBoy990/wulma\">WULMA</a> <a class=\"link\" href=\"https://github.com/SalsaBoy990/docker-wp-bedrock\">Docker-Bedrock</a> <a class=\"link\" href=\"https://github.com/SalsaBoy990/docker-wordpress\">Docker-WORDPRESS</a></nav>', 1, '2022-09-06 17:20:51', '2022-09-07 22:28:10');
SQL
       );


    }

    public function down(): void
    {
        $this->exec("DROP TABLE `skills`;");
    }
};