<?php

return [
    'name' => 'PakFlex Packaging',
    'tagline' => 'Flexible Packaging. Reliable Protection.',
    'contact' => 'Faheem Bilal',
    'role' => 'Sales & Business Development',
    'location' => 'Faisalabad, Pakistan',
    'email' => env('PAKFLEX_EMAIL'),
    'enquiry_email' => env('PAKFLEX_ENQUIRY_EMAIL'),
    'whatsapp' => env('PAKFLEX_WHATSAPP') ?: '+92 304 0891842',
    'phone_display' => '0304 0891842',
    'hero_image' => '/images/bedding-packaging.png',
    'profile' => env('PAKFLEX_PROFILE'),
    'products' => [
        'polybags' => ['name' => 'Polybags', 'type' => 'bags', 'label' => 'Everyday protection', 'description' => 'Customized polybags for individual products, bulk packing and protective liners, specified around your application.', 'items' => ['Plain Polybags', 'Printed Polybags', 'Hosiery & Socks Bags', 'T-Shirt & Shirt Bags', 'Trouser Bags', 'Hanger Bags', 'Self-Adhesive Bags', 'Zipper Bags', 'Master Bags', 'Liner Bags', 'Custom Polybags']],
        'garment-packaging' => ['name' => 'Garment & Textile Packaging', 'type' => 'garment', 'label' => 'Made for textiles', 'description' => 'Presentation and protection for garments, knitwear, hosiery, socks, towels and home textiles, from individual packs to master bags.', 'items' => ['Garment Bags', 'Shirt & Trouser Bags', 'T-Shirt Bags', 'Socks Packaging', 'Hosiery Packaging', 'Knitwear Packaging', 'Home Textile Packaging', 'Towel Packaging', 'Export Packaging', 'Individual Product Bags', 'Master Packaging Bags']],
        'pvc-packaging' => ['name' => 'PVC Packaging', 'type' => 'roll', 'label' => 'Clarity & versatility', 'description' => 'PVC film and packaging options to discuss according to your application, dimensions, thickness and product requirements.', 'items' => ['PVC Flexible Film', 'PVC Rigid Film', 'PVC Shrink Film', 'PVC Sleeves', 'Transparent PVC Packaging', 'PVC Blister Packaging', 'PVC Clamshell Packaging', 'PVC Protective Film', 'PVC Thermoformed Packaging']],
        'pe-films' => ['name' => 'PE Films & Packaging', 'type' => 'roll', 'label' => 'Flexible by design', 'description' => 'PE-based films, bags and liners for flexible, protective and industrial packaging applications.', 'items' => ['LDPE Film', 'LLDPE Film', 'HDPE Film', 'PE Packaging Film', 'PE Bags', 'Industrial Liners', 'Protective Film']],
        'shrink-film' => ['name' => 'Shrink Film', 'type' => 'roll', 'label' => 'A closer fit', 'description' => 'Packaging options for product bundling, presentation and protection, matched to your application and packing process.', 'items' => ['PVC Shrink Film', 'PE Shrink Film', 'Shrink Sleeves', 'Printed Shrink Film', 'Transparent Shrink Film', 'Product Bundling Film']],
        'stretch-film' => ['name' => 'Stretch Film', 'type' => 'roll', 'label' => 'Ready for handling', 'description' => 'Film for pallet wrapping, load stabilization, warehouse handling and transportation protection.', 'items' => ['Hand Stretch Film', 'Machine Stretch Film', 'Pallet Stretch Film', 'Industrial Stretch Film']],
        'bopp-packaging' => ['name' => 'BOPP Packaging', 'type' => 'bags', 'label' => 'Present your product', 'description' => 'BOPP packaging options for textile and retail presentation, with printing and finishing agreed to your requirements.', 'items' => ['BOPP Bags', 'Printed BOPP Packaging', 'Laminated BOPP Packaging', 'Textile Packaging', 'Retail Packaging']],
        'custom-printed-packaging' => ['name' => 'Custom Printed Packaging', 'type' => 'printed', 'label' => 'Your brand, clearly', 'description' => 'Turn your artwork into customized packaging designed around your brand and product requirements.', 'items' => ['Logo Printed Bags', 'Custom Artwork', 'Product Information Printing', 'Barcode Printing', 'Multi-Color Printing', 'Branded Packaging']],
    ],
    'industries' => [
        'textile-garments' => ['name' => 'Textile & Apparel', 'description' => 'Packaging for garment manufacturers, knitwear, hosiery, socks, textile exporters and apparel brands.', 'products' => ['garment-packaging', 'polybags', 'custom-printed-packaging']],
        'home-textile' => ['name' => 'Home Textiles', 'description' => 'Packaging requirements for towels, bed linen, made-ups and other home textile products.', 'products' => ['garment-packaging', 'pvc-packaging', 'polybags']],
        'industrial' => ['name' => 'Industrial & Logistics', 'description' => 'Protection for components, manufactured products, warehouse handling and bulk distribution.', 'products' => ['pe-films', 'stretch-film', 'shrink-film']],
        'retail' => ['name' => 'Retail & Consumer Products', 'description' => 'Packaging for branded products, retail presentation and consumer goods, specified to suit the product.', 'products' => ['bopp-packaging', 'custom-printed-packaging', 'shrink-film']],
    ],
    'faqs' => [
        'What packaging products do you supply?' => 'We supply customized polybags, garment packaging, PVC and PE films, shrink film, stretch film, BOPP packaging and printed flexible packaging according to customer requirements.',
        'Can packaging be customized?' => 'Yes. Share your size, material, thickness, printing, closure, quantity and application. We will discuss the appropriate specification with you.',
        'Do you provide printed polybags?' => 'Yes. Custom printed packaging can be supplied according to agreed artwork and specifications.',
        'Can you supply garment packaging?' => 'Yes. Garment, hosiery, socks, knitwear and home textile packaging can be developed according to product requirements.',
        'How can I request a quotation?' => 'Use the quotation form to send your product, size, material, thickness, printing requirement and quantity. You can also attach artwork or a specification.',
        'Do you supply internationally?' => 'Contact our sales team to discuss your location, product requirements and delivery arrangements. Availability, documentation and commercial terms are confirmed for each enquiry.',
    ],
];
