# PakFlex Packaging website

This site uses the existing Laravel 12 application. Styling and browser scripts are served directly from `public/site.css`, `public/light.css` and `public/site.js`; no frontend build is required for these pages.

## Local preview

Run `php artisan serve --host=127.0.0.1 --port=8126` and visit http://127.0.0.1:8126.

## Business information

Edit `config/pakflex.php` for products, industries, FAQs and company information. Add the following to your environment configuration when confirmed:

```dotenv
PAKFLEX_EMAIL=
PAKFLEX_WHATSAPP=
PAKFLEX_PROFILE=
```

Use an international phone number for WhatsApp. PAKFLEX_PROFILE is an optional URL/path to an approved company profile PDF. Without contact details, the site directs buyers to the working enquiry form.

## Enquiries

Validated requests are saved as JSON files under `storage/app/private/enquiries/PF-REFERENCE/enquiry.json`. Optional artwork is stored alongside each record, with a generated filename. These files are private and are not linked from the public website. Only PDF, JPG, PNG and WebP files up to 10 MB are accepted. Ensure PHP `upload_max_filesize` is at least 10M and `post_max_size` is at least 12M in hosting configuration.

No email notifications are sent yet. Enquiries must be reviewed from private storage by the site operator; connect a confirmed business mailbox and delivery service before public launch if automatic notifications are required. No public admin panel is provided.

## Hosting

Use PHP 8.2+ hosting with Laravel support. Point the web root to `public`, not the project root. Set APP_ENV=production, APP_DEBUG=false and APP_URL to the final HTTPS domain. Preserve the application key and configure the database/session/cache as appropriate to your host. Allow the application to write to `storage` and `bootstrap/cache`. Back up private enquiries and define an operational retention/deletion policy.

Run `php artisan test`, then `php artisan optimize`. Set up HTTPS, domain DNS and server backups. Submit `/sitemap.xml` to Google Search Console after launch. The domain has not been registered or connected by this task.

## Assets

The original logo is preserved at `public/images/pakflex-logo.png`. The header uses `public/images/pakflex-logo-white.png`, prepared with the built-in image editor. The edit prompt requested the same PAKFLEX wordmark, green PAK, blue FLEX, gray PACKAGING and swooshes on pure white, removing the dark background and glow without redesigning the logo.

The homepage displays a PVC film roll photograph by Luccadomina, sourced from Wikimedia Commons under CC BY-SA 4.0. Attribution and license links are on /image-credits. The original downloaded photo is unchanged. The hero image path is configured as hero_image in config/pakflex.php. Replace resources/views/partials/hero-media.blade.php with the company unit video when it becomes available. There are no external video players.

Polybag photos are stored at `public/images/polybags.jpg` and `public/images/clear-polybag.jpg` and are reused on the homepage, relevant catalogue cards and product pages. Stock photography source and license links are available on `/image-credits`. Remaining CSS product illustrations are labeled and do not claim to be actual supplied products. Replace reference visuals with approved company product photography when available.

The confirmed contact number is 0304 0891842; phone links and WhatsApp use +92 304 0891842.

