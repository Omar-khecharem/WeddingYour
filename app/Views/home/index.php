<?php
$categories = $categories ?? [];
$featuredProducts = $featuredProducts ?? [];
$trendingProducts = $trendingProducts ?? [];
$recentProducts = $recentProducts ?? [];
$reviews = $reviews ?? [];
$whatsappNumber = \App\Models\Setting::get('whatsapp_number', WHATSAPP_NUMBER);
?>
<div class="min-h-screen bg-slate-50 font-sans text-slate-800 antialiased selection:bg-red-500 selection:text-white">

  <main class="max-w-7xl mx-auto px-4 py-6 space-y-8">

    <?php $catList = !empty($categories) ? $categories : [
      ['slug' => 'bebe-mukut', 'name' => 'BÉBÉ MUKUT', 'image' => 'https://images.unsplash.com/photo-1519689680058-324335c77ebe?w=200'],
      ['slug' => 'mukut-mariee', 'name' => 'MUKUT MARIÉE', 'image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=200'],
      ['slug' => 'topor-marie', 'name' => 'TOPOR MARIÉ', 'image' => 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=200'],
      ['slug' => 'articles-mariage', 'name' => 'ARTICLES MARIAGE', 'image' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=200'],
      ['slug' => 'gachhkouto-dorpon', 'name' => 'GACHHKOUTO & DORPON', 'image' => 'https://images.unsplash.com/photo-1607344645866-009c320c5ab8?w=200'],
    ]; ?>
    <?php $chunks = array_chunk($catList, 8); ?>
    <!-- CATEGORIES STEP CAROUSEL (8 per slide) -->
    <section class="overflow-hidden -mx-4 px-4 py-1">
      <div class="flex items-center justify-between mb-6 px-4">
        <h2 class="text-2xl font-black text-slate-800 tracking-tight">Catégories</h2>
      </div>
      <div class="relative overflow-hidden">
        <div id="catTrackHome" class="flex transition-transform duration-500 ease-in-out" style="width:<?= count($chunks) * 100 ?>%">
          <?php foreach ($chunks as $chunk): ?>
          <div class="flex gap-6 md:gap-8 px-4" style="width:<?= 100 / count($chunks) ?>%">
            <?php foreach ($chunk as $cat): ?>
            <?php $catSlug = is_array($cat) ? $cat['slug'] : $cat; ?>
            <?php $catName = is_array($cat) ? $cat['name'] : $cat; ?>
            <?php $catImg = is_array($cat) ? ($cat['image'] ?? 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=200') : 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=200'; ?>
            <a href="<?= url('category/' . e($catSlug)) ?>" class="flex flex-col items-center text-center space-y-3 w-[130px] md:w-[150px] lg:w-[170px] shrink-0 group">
              <div class="w-full aspect-square rounded-2xl overflow-hidden border-2 border-slate-100 group-hover:border-red-600 group-hover:translate-x-1 group-hover:scale-105 transition-all duration-300 shadow-md group-hover:shadow-xl">
                <img src="<?= e($catImg) ?>" alt="<?= e($catName) ?>" class="w-full h-full object-cover" loading="lazy">
              </div>
              <span class="text-xs md:text-sm font-bold uppercase tracking-wider text-slate-700 group-hover:text-red-600 transition-colors"><?= e($catName) ?></span>
            </a>
            <?php endforeach; ?>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- VIDEO + FLASH SALE -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Video Showcase -->
      <div class="relative group overflow-hidden rounded-2xl border-4 border-purple-600/10 hover:border-purple-600/30 transition-all duration-300 shadow-lg aspect-video bg-slate-900">
        <img src="<?= \App\Models\Setting::get('video_showcase_image', 'https://images.unsplash.com/photo-1607344645866-009c320c5ab8?w=800&auto=format&fit=crop&q=80') ?>" alt="Démonstration" class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-500">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent flex flex-col justify-end p-6">
          <div class="flex items-center gap-4">
            <button class="w-12 h-12 flex items-center justify-center bg-white hover:bg-red-600 hover:text-white text-red-600 rounded-full transition-all duration-300 shadow-xl transform scale-100 hover:scale-110">
              <svg class="w-6 h-6 fill-current ml-1" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            </button>
            <div>
              <p class="text-xs font-bold text-red-500 uppercase tracking-widest">Atelier de Création</p>
              <h3 class="text-white font-bold text-lg">Découvrez le savoir-faire de Shola Ghar</h3>
            </div>
          </div>
        </div>
        <a href="https://wa.me/<?= e($whatsappNumber) ?>" target="_blank" class="absolute top-4 right-4 bg-emerald-600 text-white font-bold text-xs px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-md hover:bg-emerald-700 transition-colors">
          <span class="w-2.5 h-2.5 bg-white rounded-full animate-ping"></span> Order On WhatsApp
        </a>
      </div>

      <!-- Flash Sale -->
      <div class="relative group overflow-hidden rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 p-8 flex flex-col justify-between shadow-lg text-white border-4 border-purple-600/10">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-16 -mt-16 blur-2xl pointer-events-none"></div>
        <div class="relative space-y-2">
          <span class="bg-black/20 text-white font-black text-xs px-3 py-1 uppercase tracking-widest rounded-full inline-block">Flash Sale</span>
          <h2 class="text-3xl md:text-4xl font-black tracking-tight leading-tight">FLAT 20% OFF</h2>
          <p class="text-amber-100 text-sm font-medium">Sur toute notre collection exclusive de Topor - Mukut de mariage.</p>
        </div>
        <div class="relative mt-8 flex items-end justify-between">
          <a href="<?= url('products?on_sale=1') ?>" class="bg-white hover:bg-black hover:text-white text-orange-600 font-extrabold text-xs px-6 py-3 rounded-full uppercase tracking-wider transition-all shadow-md">
            Acheter Maintenant
          </a>
          <div class="w-16 h-16 md:w-20 md:h-20 bg-white/10 backdrop-blur-md border border-white/20 rounded-full flex items-center justify-center font-bold text-xs text-center leading-tight">
            Offre<br/>Limitée
          </div>
        </div>
      </div>
    </section>

    <!-- POPULAR PRODUCTS - 7 cards -->
    <section class="space-y-6">
      <div class="flex items-center justify-between border-b border-slate-200 pb-4">
        <h2 class="text-2xl font-black text-slate-800 tracking-tight">Nos Créations Populaires</h2>
        <a href="<?= url('products') ?>" class="text-sm font-bold text-red-600 hover:text-red-700 flex items-center gap-1 transition-all">
          Voir tout <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-7 gap-4">
        <?php $displayProducts = array_slice(array_merge($featuredProducts, $trendingProducts, $recentProducts), 0, 7); ?>
        <?php foreach ($displayProducts as $product): ?>
        <?php $images = $product['images'] ?? [$product['image'] ?? 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=300&auto=format&fit=crop&q=80']; ?>
        <div class="group relative bg-white border border-red-100 hover:border-red-400 rounded-xl overflow-hidden transition-all duration-300 shadow-sm hover:shadow-lg flex flex-col">
          <?php if (!empty($product['discount_percent'])): ?>
          <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-black px-2 py-0.5 rounded-md z-20">-<?= (int)$product['discount_percent'] ?>%</span>
          <?php endif; ?>
          <a href="<?= url('product/' . e($product['slug'])) ?>" class="aspect-square w-full overflow-hidden bg-slate-50 block">
            <img class="product-img w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="<?= e($images[0]) ?>" alt="<?= e($product['name']) ?>" data-images='<?= e(json_encode($images)) ?>' loading="lazy">
          </a>
          <div class="absolute inset-0 bg-black/75 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-center items-center p-3 text-white text-center z-10">
            <h4 class="text-xs font-black uppercase tracking-wide"><?= e($product['name']) ?></h4>
            <p class="text-[10px] text-red-300 font-semibold mt-0.5"><?= e($product['category_name'] ?? 'BRIDE') ?>, <?= e($product['subcategory_name'] ?? 'Crown & 3 Pieces Set') ?></p>
            <span class="text-[10px] text-emerald-300 font-bold mt-0.5">In stock</span>
            <div class="mt-1">
              <span class="text-sm font-black text-white"><?= formatPrice($product['sale_price'] ?: $product['regular_price']) ?></span>
              <?php if (!empty($product['sale_price'])): ?>
              <span class="text-[10px] text-slate-400 line-through ml-1"><?= formatPrice($product['regular_price']) ?></span>
              <?php endif; ?>
            </div>
            <div class="flex items-center gap-1.5 mt-2">
              <button onclick="addToCart(<?= $product['id'] ?>, 1)" class="bg-red-600 hover:bg-red-700 text-white text-[10px] font-bold px-2 py-1.5 rounded transition-colors flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                Cart
              </button>
              <button onclick="toggleCompare(<?= $product['id'] ?>)" class="bg-slate-700 hover:bg-slate-600 text-white text-[10px] font-bold px-2 py-1.5 rounded transition-colors flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
              </button>
              <button onclick="quickView(<?= $product['id'] ?>)" class="bg-slate-700 hover:bg-slate-600 text-white text-[10px] font-bold px-2 py-1.5 rounded transition-colors flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              </button>
            </div>
            <button onclick="toggleWishlist(<?= $product['id'] ?>)" class="mt-1.5 bg-white/20 hover:bg-white/30 text-white text-[10px] font-bold px-2 py-0.5 rounded-full transition-colors flex items-center gap-1">
              <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
              Wishlist
            </button>
          </div>
        </div>
        <?php endforeach; ?>
        <?php if (empty($displayProducts)): ?>
          <?php $demoProducts = [
            ['id' => 1, 'slug' => '#', 'name' => 'Crown', 'category_name' => 'BRIDE', 'subcategory_name' => 'Crown & 3 Pieces Set', 'regular_price' => 3000.00, 'sale_price' => 1790.00, 'discount_percent' => 40, 'images' => ['https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=300', 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=300', 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=300']],
            ['id' => 2, 'slug' => '#', 'name' => 'Panpata', 'category_name' => 'BRIDE', 'subcategory_name' => 'Panpata', 'regular_price' => 2500.00, 'sale_price' => 1450.00, 'discount_percent' => 42, 'images' => ['https://images.unsplash.com/photo-1519741497674-611481863552?w=300', 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=300', 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=300']],
            ['id' => 3, 'slug' => '#', 'name' => 'Piri', 'category_name' => 'BRIDE', 'subcategory_name' => 'Piri', 'regular_price' => 2200.00, 'sale_price' => 1342.00, 'discount_percent' => 39, 'images' => ['https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=300', 'https://images.unsplash.com/photo-1519741497674-611481863552?w=300', 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=300']],
            ['id' => 4, 'slug' => '#', 'name' => 'Tattwasuchi', 'category_name' => 'BRIDE', 'subcategory_name' => 'Tattwa Suchi', 'regular_price' => 3500.00, 'sale_price' => 1400.00, 'discount_percent' => 60, 'images' => ['https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=300', 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=300', 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=300']],
            ['id' => 5, 'slug' => '#', 'name' => 'Topor Mukut', 'category_name' => 'GROOM', 'subcategory_name' => 'Topor Mukut', 'regular_price' => 1800.00, 'sale_price' => 1188.00, 'discount_percent' => 34, 'images' => ['https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=300', 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=300', 'https://images.unsplash.com/photo-1519741497674-611481863552?w=300']],
            ['id' => 6, 'slug' => '#', 'name' => 'Gachhkouto', 'category_name' => 'WEDDING', 'subcategory_name' => 'Gachhkouto', 'regular_price' => 2800.00, 'sale_price' => 1876.00, 'discount_percent' => 33, 'images' => ['https://images.unsplash.com/photo-1607344645866-009c320c5ab8?w=300', 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=300', 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=300']],
            ['id' => 7, 'slug' => '#', 'name' => 'Khoidan Kulo', 'category_name' => 'WEDDING', 'subcategory_name' => 'Khoidan Kulo', 'regular_price' => 3200.00, 'sale_price' => 1600.00, 'discount_percent' => 50, 'images' => ['https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=300', 'https://images.unsplash.com/photo-1607344645866-009c320c5ab8?w=300', 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=300']],
          ]; foreach ($demoProducts as $product): ?>
          <div class="group relative bg-white border border-red-100 hover:border-red-400 rounded-xl overflow-hidden transition-all duration-300 shadow-sm hover:shadow-lg flex flex-col">
            <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-black px-2 py-0.5 rounded-md z-20">-<?= $product['discount_percent'] ?>%</span>
            <a href="#" class="aspect-square w-full overflow-hidden bg-slate-50 block">
              <img class="product-img w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="<?= $product['images'][0] ?>" alt="<?= $product['name'] ?>" data-images='<?= json_encode($product['images']) ?>' loading="lazy">
            </a>
            <div class="absolute inset-0 bg-black/75 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-center items-center p-3 text-white text-center z-10">
              <h4 class="text-xs font-black uppercase tracking-wide"><?= $product['name'] ?></h4>
              <p class="text-[10px] text-red-300 font-semibold mt-0.5"><?= $product['category_name'] ?>, <?= $product['subcategory_name'] ?></p>
              <span class="text-[10px] text-emerald-300 font-bold mt-0.5">In stock</span>
              <div class="mt-1">
                <span class="text-sm font-black text-white">₹<?= number_format($product['sale_price'], 2) ?></span>
                <span class="text-[10px] text-slate-400 line-through ml-1">₹<?= number_format($product['regular_price'], 2) ?></span>
              </div>
              <div class="flex items-center gap-1.5 mt-2">
                <button class="bg-red-600 hover:bg-red-700 text-white text-[10px] font-bold px-2 py-1.5 rounded transition-colors flex items-center gap-1">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                  Cart
                </button>
                <button onclick="toggleCompare(<?= $product['id'] ?>)" class="bg-slate-700 hover:bg-slate-600 text-white text-[10px] font-bold px-2 py-1.5 rounded transition-colors flex items-center gap-1">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </button>
                <button onclick="quickView(<?= $product['id'] ?>)" class="bg-slate-700 hover:bg-slate-600 text-white text-[10px] font-bold px-2 py-1.5 rounded transition-colors flex items-center gap-1">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </button>
              </div>
              <button class="mt-1.5 bg-white/20 hover:bg-white/30 text-white text-[10px] font-bold px-2 py-0.5 rounded-full transition-colors flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                Wishlist
              </button>
            </div>
          </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>

    <!-- PROMOTIONAL BANNER -->
    <section class="relative overflow-hidden rounded-2xl shadow-lg group h-40 md:h-52 lg:h-64">
      <a href="<?= url('products?on_sale=1') ?>" class="block w-full h-full">
        <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=1400&auto=format&fit=crop&q=80" alt="Promotion" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
      </a>
    </section>

    <!-- BEST DEAL FOR YOU -->
    <section class="space-y-4">
      <h2 class="text-xl md:text-2xl font-black text-slate-800 tracking-tight text-center">Best Deal For You</h2>
      <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
        <a href="<?= url('products') ?>" class="relative overflow-hidden rounded-xl shadow-md group aspect-[4/3] block">
          <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=400&auto=format&fit=crop&q=80" alt="Deal 1" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        </a>
        <a href="<?= url('products') ?>" class="relative overflow-hidden rounded-xl shadow-md group aspect-[4/3] block">
          <img src="https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=400&auto=format&fit=crop&q=80" alt="Deal 2" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        </a>
        <a href="<?= url('products') ?>" class="relative overflow-hidden rounded-xl shadow-md group aspect-[4/3] block">
          <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=400&auto=format&fit=crop&q=80" alt="Deal 3" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        </a>
        <a href="<?= url('products') ?>" class="relative overflow-hidden rounded-xl shadow-md group aspect-[4/3] block">
          <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=400&auto=format&fit=crop&q=80" alt="Deal 4" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        </a>
        <a href="<?= url('products') ?>" class="relative overflow-hidden rounded-xl shadow-md group aspect-[4/3] block">
          <img src="https://images.unsplash.com/photo-1607344645866-009c320c5ab8?w=400&auto=format&fit=crop&q=80" alt="Deal 5" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        </a>
        <a href="<?= url('products') ?>" class="relative overflow-hidden rounded-xl shadow-md group aspect-[4/3] block">
          <img src="https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=400&auto=format&fit=crop&q=80" alt="Deal 6" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        </a>
      </div>
    </section>

    <!-- CATEGORY CARDS - 4 cards with 4 images each -->
    <section class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
      <!-- Card 1: Mukut & Topor -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden border border-slate-100 hover:shadow-lg transition-shadow">
        <div class="p-3">
          <h3 class="text-sm font-black text-slate-800 uppercase tracking-wide mb-2">Mukut & Topor</h3>
          <div class="grid grid-cols-2 gap-1.5">
            <img src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=200&auto=format&fit=crop&q=80" alt="" class="w-full aspect-square object-cover rounded-lg">
            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=200&auto=format&fit=crop&q=80" alt="" class="w-full aspect-square object-cover rounded-lg">
            <img src="https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=200&auto=format&fit=crop&q=80" alt="" class="w-full aspect-square object-cover rounded-lg">
            <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=200&auto=format&fit=crop&q=80" alt="" class="w-full aspect-square object-cover rounded-lg">
          </div>
          <a href="<?= url('products?category=mukut-mariee') ?>" class="mt-2 text-xs font-bold text-red-600 hover:text-red-700 flex items-center gap-1 justify-end">See more <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></a>
        </div>
      </div>

      <!-- Card 2: Wedding Items for All -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden border border-slate-100 hover:shadow-lg transition-shadow">
        <div class="p-3">
          <h3 class="text-sm font-black text-slate-800 uppercase tracking-wide mb-2">Wedding Items for All</h3>
          <div class="grid grid-cols-2 gap-1.5">
            <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=200&auto=format&fit=crop&q=80" alt="" class="w-full aspect-square object-cover rounded-lg">
            <img src="https://images.unsplash.com/photo-1607344645866-009c320c5ab8?w=200&auto=format&fit=crop&q=80" alt="" class="w-full aspect-square object-cover rounded-lg">
            <img src="https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=200&auto=format&fit=crop&q=80" alt="" class="w-full aspect-square object-cover rounded-lg">
            <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=200&auto=format&fit=crop&q=80" alt="" class="w-full aspect-square object-cover rounded-lg">
          </div>
          <a href="<?= url('products?category=articles-mariage') ?>" class="mt-2 text-xs font-bold text-red-600 hover:text-red-700 flex items-center gap-1 justify-end">See more <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></a>
        </div>
      </div>

      <!-- Card 3: Gachhkouto & Dorpon -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden border border-slate-100 hover:shadow-lg transition-shadow">
        <div class="p-3">
          <h3 class="text-sm font-black text-slate-800 uppercase tracking-wide mb-2">Gachhkouto & Dorpon</h3>
          <div class="grid grid-cols-2 gap-1.5">
            <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=200&auto=format&fit=crop&q=80" alt="" class="w-full aspect-square object-cover rounded-lg">
            <img src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=200&auto=format&fit=crop&q=80" alt="" class="w-full aspect-square object-cover rounded-lg">
            <img src="https://images.unsplash.com/photo-1607344645866-009c320c5ab8?w=200&auto=format&fit=crop&q=80" alt="" class="w-full aspect-square object-cover rounded-lg">
            <img src="https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=200&auto=format&fit=crop&q=80" alt="" class="w-full aspect-square object-cover rounded-lg">
          </div>
          <a href="<?= url('products?category=gachhkouto-dorpon') ?>" class="mt-2 text-xs font-bold text-red-600 hover:text-red-700 flex items-center gap-1 justify-end">See more <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></a>
        </div>
      </div>

      <!-- Card 4: Best Seller Items -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden border border-slate-100 hover:shadow-lg transition-shadow">
        <div class="p-3">
          <h3 class="text-sm font-black text-slate-800 uppercase tracking-wide mb-2">Best Seller Items</h3>
          <div class="grid grid-cols-2 gap-1.5">
            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=200&auto=format&fit=crop&q=80" alt="" class="w-full aspect-square object-cover rounded-lg">
            <img src="https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=200&auto=format&fit=crop&q=80" alt="" class="w-full aspect-square object-cover rounded-lg">
            <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=200&auto=format&fit=crop&q=80" alt="" class="w-full aspect-square object-cover rounded-lg">
            <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=200&auto=format&fit=crop&q=80" alt="" class="w-full aspect-square object-cover rounded-lg">
          </div>
          <a href="<?= url('products?sort=popular') ?>" class="mt-2 text-xs font-bold text-red-600 hover:text-red-700 flex items-center gap-1 justify-end">See more <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></a>
        </div>
      </div>
    </section>

    <!-- VIDEO SECTION -->
    <section class="relative overflow-hidden rounded-2xl shadow-lg bg-slate-900 aspect-video flex items-center justify-center">
      <div class="text-center text-white p-8">
        <svg class="w-16 h-16 mx-auto mb-4 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
        <p class="text-lg font-bold">Vidéo à insérer</p>
      </div>
    </section>

    <!-- TOP TRENDING CATEGORIES -->
    <section class="space-y-4">
      <h2 class="text-xl md:text-2xl font-black text-slate-800 tracking-tight text-center">Top Trending Categories</h2>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="<?= url('products?category=articles-mariage') ?>" class="flex flex-col items-center gap-2 group">
          <div class="w-full aspect-[4/3] rounded-xl overflow-hidden shadow-md">
            <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=400&auto=format&fit=crop&q=80" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
          </div>
          <span class="text-xs font-bold text-white bg-red-600 px-4 py-1.5 rounded-full">Wedding Items</span>
        </a>
        <a href="<?= url('products?category=mukut-mariee') ?>" class="flex flex-col items-center gap-2 group">
          <div class="w-full aspect-[4/3] rounded-xl overflow-hidden shadow-md">
            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=400&auto=format&fit=crop&q=80" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
          </div>
          <span class="text-xs font-bold text-white bg-red-600 px-4 py-1.5 rounded-full">Bride</span>
        </a>
        <a href="<?= url('products?category=topor-marie') ?>" class="flex flex-col items-center gap-2 group">
          <div class="w-full aspect-[4/3] rounded-xl overflow-hidden shadow-md">
            <img src="https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=400&auto=format&fit=crop&q=80" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
          </div>
          <span class="text-xs font-bold text-white bg-red-600 px-4 py-1.5 rounded-full">Groom</span>
        </a>
        <a href="<?= url('products?category=bebe-mukut') ?>" class="flex flex-col items-center gap-2 group">
          <div class="w-full aspect-[4/3] rounded-xl overflow-hidden shadow-md">
            <img src="https://images.unsplash.com/photo-1519689680058-324335c77ebe?w=400&auto=format&fit=crop&q=80" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
          </div>
          <span class="text-xs font-bold text-white bg-red-600 px-4 py-1.5 rounded-full">Baby</span>
        </a>
      </div>
      <div class="text-center">
        <a href="<?= url('products') ?>" class="inline-flex items-center gap-2 text-sm font-bold text-red-600 hover:text-red-700 transition-colors">View All Categories <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg></a>
      </div>
    </section>

    <!-- CHECKOUT OUR RECENT PRODUCTS - Carousel -->
    <section class="space-y-6 relative">
      <h2 class="text-xl md:text-2xl font-black text-slate-800 tracking-tight text-center">Checkout Our Recent Products</h2>
      <div class="relative">
        <button onclick="recentScroll(-1)" class="absolute left-0 top-1/2 -translate-y-1/2 z-20 w-10 h-10 bg-white/90 hover:bg-white rounded-full shadow-lg flex items-center justify-center text-slate-700 hover:text-red-600 transition-all -ml-5" aria-label="Previous">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button onclick="recentScroll(1)" class="absolute right-0 top-1/2 -translate-y-1/2 z-20 w-10 h-10 bg-white/90 hover:bg-white rounded-full shadow-lg flex items-center justify-center text-slate-700 hover:text-red-600 transition-all -mr-5" aria-label="Next">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </button>
        <div id="recent-viewport" class="overflow-hidden">
        <div id="recent-track" class="flex transition-transform duration-500 ease-in-out">
          <?php $recentDemo = [
            ['name' => 'Noyoni Mukut', 'category' => 'BRIDE', 'sub' => 'Bridal Patashi / Mukut', 'tags' => 'Exclusive Collection, Exclusive', 'regular' => 1499.00, 'sale' => 799.00, 'discount' => 47, 'img' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=300'],
            ['name' => 'Poddosree Mukut', 'category' => 'BRIDE', 'sub' => 'Bridal Patashi / Mukut', 'tags' => 'Exclusive Collection, Exclusive', 'regular' => 1499.00, 'sale' => 799.00, 'discount' => 47, 'img' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=300'],
            ['name' => 'Purna Mukut', 'category' => 'BRIDE', 'sub' => 'Bridal Patashi / Mukut', 'tags' => 'Exclusive Collection, Exclusive', 'regular' => 1299.00, 'sale' => 799.00, 'discount' => 38, 'img' => 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=300'],
            ['name' => 'Lili Mukut', 'category' => 'BRIDE', 'sub' => 'Bridal Patashi / Mukut', 'tags' => 'Exclusive Collection, Exclusive', 'regular' => 1399.00, 'sale' => 799.00, 'discount' => 43, 'img' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=300'],
            ['name' => 'Mayuri Mukut', 'category' => 'BRIDE', 'sub' => 'Bridal Patashi / Mukut', 'tags' => 'Exclusive Collection, Exclusive', 'regular' => 1499.00, 'sale' => 799.00, 'discount' => 47, 'img' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=300'],
            ['name' => 'Distikon Mukut', 'category' => 'BRIDE', 'sub' => 'Bridal Patashi / Mukut', 'tags' => 'Exclusive Collection, Exclusive', 'regular' => 1499.00, 'sale' => 799.00, 'discount' => 47, 'img' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=300'],
            ['name' => 'Noyoni Mukut', 'category' => 'BRIDE', 'sub' => 'Bridal Patashi / Mukut', 'tags' => 'Exclusive Collection, Exclusive', 'regular' => 1499.00, 'sale' => 799.00, 'discount' => 47, 'img' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=300'],
            ['name' => 'Poddosree Mukut', 'category' => 'BRIDE', 'sub' => 'Bridal Patashi / Mukut', 'tags' => 'Exclusive Collection, Exclusive', 'regular' => 1499.00, 'sale' => 799.00, 'discount' => 47, 'img' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=300'],
            ['name' => 'Purna Mukut', 'category' => 'BRIDE', 'sub' => 'Bridal Patashi / Mukut', 'tags' => 'Exclusive Collection, Exclusive', 'regular' => 1299.00, 'sale' => 799.00, 'discount' => 38, 'img' => 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=300'],
            ['name' => 'Lili Mukut', 'category' => 'BRIDE', 'sub' => 'Bridal Patashi / Mukut', 'tags' => 'Exclusive Collection, Exclusive', 'regular' => 1399.00, 'sale' => 799.00, 'discount' => 43, 'img' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=300'],
            ['name' => 'Mayuri Mukut', 'category' => 'BRIDE', 'sub' => 'Bridal Patashi / Mukut', 'tags' => 'Exclusive Collection, Exclusive', 'regular' => 1499.00, 'sale' => 799.00, 'discount' => 47, 'img' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=300'],
            ['name' => 'Distikon Mukut', 'category' => 'BRIDE', 'sub' => 'Bridal Patashi / Mukut', 'tags' => 'Exclusive Collection, Exclusive', 'regular' => 1499.00, 'sale' => 799.00, 'discount' => 47, 'img' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=300'],
          ]; foreach ($recentDemo as $p): ?>
          <div class="w-1/2 md:w-1/3 lg:w-1/6 flex-shrink-0 px-1.5 md:px-2">
          <div class="bg-slate-100 border border-red-100 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow flex flex-col h-full">
            <div class="relative group/img">
              <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-black px-2 py-0.5 rounded-md z-10">-<?= $p['discount'] ?>%</span>
              <div class="aspect-[4/3] w-full overflow-hidden bg-slate-50">
                <img src="<?= $p['img'] ?>" alt="<?= $p['name'] ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
              </div>
              <!-- Hover buttons on image bottom -->
              <div class="absolute bottom-0 left-0 right-0 flex items-center justify-center gap-1.5 p-2 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover/img:opacity-100 transition-opacity duration-300">
                <button class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-slate-700 hover:bg-red-600 hover:text-white transition-colors shadow-md" title="Cart">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                </button>
                <button class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-slate-700 hover:bg-red-600 hover:text-white transition-colors shadow-md hidden md:flex" title="Quick view">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </button>
                <button class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-slate-700 hover:bg-red-600 hover:text-white transition-colors shadow-md hidden md:flex" title="Compare">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </button>
                <button class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-slate-700 hover:bg-red-600 hover:text-white transition-colors shadow-md" title="Wishlist">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </button>
              </div>
            </div>
            <div class="p-3 flex flex-col gap-1.5 flex-1">
              <h4 class="text-xs font-black uppercase tracking-wide text-slate-800"><?= $p['name'] ?></h4>
              <p class="text-[10px] text-slate-500 font-medium leading-tight flex flex-wrap gap-x-1">
                <a href="<?= url('products?category=' . urlencode(strtolower($p['category']))) ?>" class="hover:text-red-600 transition-colors"><?= $p['category'] ?></a><span class="text-slate-300">,</span>
                <a href="<?= url('products?subcategory=' . urlencode($p['sub'])) ?>" class="hover:text-red-600 transition-colors"><?= $p['sub'] ?></a><span class="text-slate-300">,</span>
                <?php $tagList = explode(',', $p['tags']); $tagIdx = 0; foreach ($tagList as $tag): $tag = trim($tag); ?><a href="<?= url('products?tag=' . urlencode($tag)) ?>" class="hover:text-red-600 transition-colors"><?= $tag ?></a><?php if (++$tagIdx < count($tagList)): ?><span class="text-slate-300">,</span><?php endif; ?><?php endforeach; ?>
              </p>
              <span class="text-[10px] text-emerald-600 font-bold flex items-center gap-1">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> In stock
              </span>
              <!-- Star Rating -->
              <div class="flex items-center gap-0.5">
                <svg class="w-3 h-3 fill-amber-400 text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <svg class="w-3 h-3 fill-amber-400 text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <svg class="w-3 h-3 fill-amber-400 text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <svg class="w-3 h-3 fill-amber-400 text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <svg class="w-3 h-3 fill-amber-400 text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              </div>
              <div class="flex items-center gap-2">
                <span class="text-sm font-black text-red-600">₹<?= number_format($p['sale'], 2) ?></span>
                <span class="text-[10px] text-slate-400 line-through">₹<?= number_format($p['regular'], 2) ?></span>
              </div>
            </div>
          </div>
          </div>
          <?php endforeach; ?>
        </div>
        </div>
      </div>
      <div class="flex items-center justify-center gap-2 pt-1">
        <button onclick="recentPageNav(0)" class="w-2.5 h-2.5 rounded-full recent-page-btn bg-slate-400" data-page="0"></button>
        <button onclick="recentPageNav(1)" class="w-2.5 h-2.5 rounded-full recent-page-btn bg-slate-300" data-page="1"></button>
      </div>
    </section>

    <div class="flex justify-center pt-2">
      <a href="<?= url('products') ?>" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold text-sm px-6 py-3 rounded-full transition-colors shadow-md hover:shadow-lg">
        View All Products
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
      </a>
    </div>

    <!-- REVIEWS ON GOOGLE -->
    <section class="space-y-4">
      <h2 class="text-xl md:text-2xl font-black text-slate-800 tracking-tight text-center">Reviews on Google by Our Clients</h2>
      <div id="review-scroll" class="flex gap-4 overflow-x-auto scrollbar-hide -mx-4 px-4 pb-2 select-none" style="cursor:grab; scrollbar-width:none; -ms-overflow-style:none; user-select:none; -webkit-user-select:none;">
        <?php $reviewImgs = [
          'https://images.unsplash.com/photo-1590650151155-41cde0e4e1fb?w=400',
          'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=400',
          'https://images.unsplash.com/photo-1559136555-9303baea8ebd?w=400',
          'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400',
          'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=400',
          'https://images.unsplash.com/photo-1519741497674-611481863552?w=400',
          'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=400',
          'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=400',
        ]; foreach ($reviewImgs as $i => $img): ?>
        <div class="shrink-0 w-[80vw] sm:w-[45vw] md:w-[30vw] lg:w-[23vw] rounded-2xl overflow-hidden border border-slate-200 shadow-md bg-white">
          <img src="<?= $img ?>" alt="Review <?= $i+1 ?>" class="w-full h-auto object-cover pointer-events-none" loading="lazy" draggable="false">
        </div>
        <?php endforeach; ?>
      </div>
      <style>.scrollbar-hide::-webkit-scrollbar { display: none; }</style>
      <script>(function(){var el=document.getElementById('review-scroll');if(!el)return;var down=false,startX=0,scrollLeft=0;el.addEventListener('mousedown',function(e){down=true;startX=e.pageX;scrollLeft=el.scrollLeft;el.style.cursor='grabbing';});window.addEventListener('mousemove',function(e){if(!down)return;e.preventDefault();var walk=e.pageX-startX;el.scrollLeft=scrollLeft-walk;});window.addEventListener('mouseup',function(){down=false;if(el)el.style.cursor='grab';});})();</script>
    </section>

    <!-- HAVE SOME MEMORIES -->
    <section class="space-y-4 bg-[#EF5350] py-8 -mx-4 px-4">
      <h2 class="text-xl md:text-2xl font-black text-white tracking-tight text-center">Have some memories!</h2>
      <div id="memories-scroll" class="flex gap-4 overflow-x-auto scrollbar-hide -mx-4 px-4 pb-2 select-none" style="cursor:grab; scrollbar-width:none; -ms-overflow-style:none; user-select:none; -webkit-user-select:none;">
        <?php $memories = [
          'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=400&h=600&fit=crop',
          'https://images.unsplash.com/photo-1519741497674-611481863552?w=400&h=600&fit=crop',
          'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=400&h=600&fit=crop',
          'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=400&h=600&fit=crop',
          'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=400&h=600&fit=crop',
          'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=400&h=600&fit=crop',
        ]; foreach ($memories as $i => $img): ?>
        <div class="shrink-0 w-[60vw] sm:w-[35vw] md:w-[25vw] lg:w-[18vw] rounded-2xl overflow-hidden border-2 border-white/30 shadow-lg bg-white">
          <img src="<?= $img ?>" alt="Memory <?= $i+1 ?>" class="w-full h-auto object-cover pointer-events-none" loading="lazy" draggable="false" style="aspect-ratio:2/3">
        </div>
        <?php endforeach; ?>
      </div>
      <style>.scrollbar-hide::-webkit-scrollbar { display: none; }</style>
      <script>(function(){var el=document.getElementById('memories-scroll');if(!el)return;var down=false,startX=0,scrollLeft=0;el.addEventListener('mousedown',function(e){down=true;startX=e.pageX;scrollLeft=el.scrollLeft;el.style.cursor='grabbing';});window.addEventListener('mousemove',function(e){if(!down)return;e.preventDefault();var walk=e.pageX-startX;el.scrollLeft=scrollLeft-walk;});window.addEventListener('mouseup',function(){down=false;if(el)el.style.cursor='grab';});})();</script>
    </section>

    <!-- SHOLA GHAR'S OUTLETS -->
    <section class="space-y-6 text-center">
      <a href="<?= url('outlets') ?>" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold text-base px-8 py-3 rounded-full transition-colors shadow-md">Shola Ghar's Outlets</a>
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <?php $outlets = [
          ['name' => '@Shobhabazar', 'img' => 'https://images.unsplash.com/photo-1590650151155-41cde0e4e1fb?w=300&h=300&fit=crop'],
          ['name' => '@Bagbazar', 'img' => 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=300&h=300&fit=crop'],
          ['name' => '@College Street', 'img' => 'https://images.unsplash.com/photo-1559136555-9303baea8ebd?w=300&h=300&fit=crop'],
          ['name' => '@New Market', 'img' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=300&h=300&fit=crop'],
          ['name' => '@Salt Lake', 'img' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=300&h=300&fit=crop'],
        ]; foreach ($outlets as $o): ?>
        <div class="flex flex-col items-center gap-2">
          <div class="w-full aspect-square rounded-xl overflow-hidden border-4 border-red-600 shadow-md">
            <img src="<?= $o['img'] ?>" alt="<?= $o['name'] ?>" class="w-full h-full object-cover" loading="lazy">
          </div>
          <span class="text-sm font-bold text-slate-800"><?= $o['name'] ?></span>
          <a href="<?= url('contact') ?>" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-4 py-2 rounded transition-colors w-full max-w-[160px]">Get Direction →</a>
        </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- GOOGLE REVIEWS SECTION -->
    <section class="space-y-6">
      <h2 class="text-xl md:text-2xl font-black text-slate-800 tracking-tight text-center">Reviews on Google</h2>

      <?php $googleReviews = [
        'Shobhabazar' => ['slug' => 'shobhabazar', 'rating' => 4.6, 'count' => 2635, 'img' => 'https://images.unsplash.com/photo-1590650151155-41cde0e4e1fb?w=300&h=300&fit=crop', 'reviews' => [
          ['name' => 'Dipanwita Ghosh', 'time' => '2 mois', 'text' => 'Very beautiful collection. Staff behaviour and ambiance very good.'],
          ['name' => 'Ranjit Kumar Singh', 'time' => '2 mois', 'text' => 'Good service'],
          ['name' => 'Bhumika Bose', 'time' => '2 mois', 'text' => 'Very good quality and good behaviour ...'],
          ['name' => 'AVISEK GHOSH', 'time' => '2 mois', 'text' => 'The collection is fabulous in the store. Ethnic and premium'],
          ['name' => 'Rishika Debroy', 'time' => '5 mois', 'text' => 'Visited Sholaghar and honestly, the experience was amazing. The staff behaviour was extremely warm, helpful, and welcoming throughout.'],
        ]],
        'Barrackpore' => ['slug' => 'barrackpore', 'rating' => 4.8, 'count' => 347, 'img' => 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=300&h=300&fit=crop', 'reviews' => [
          ['name' => 'Papri Kar', 'time' => '2 mois', 'text' => 'Good experience. Nice collection'],
          ['name' => 'Titli Ghosh', 'time' => '2 mois', 'text' => 'Great collection'],
          ['name' => 'Sumana Dey', 'time' => '2 mois', 'text' => 'Best place ever, very unique collection, very polite hospitality, overall loved it'],
          ['name' => 'Risha Baisya', 'time' => '4 mois', 'text' => 'I visited the Barrackpore outlet. The collections were huge and mesmerizing.'],
          ['name' => 'Mandira Ghosh', 'time' => '5 mois', 'text' => 'Great place to shop for your wedding essentials.. great service..'],
        ]],
        'Chinar Park' => ['slug' => 'chinar-park', 'rating' => 4.9, 'count' => 144, 'img' => 'https://images.unsplash.com/photo-1559136555-9303baea8ebd?w=300&h=300&fit=crop', 'reviews' => [
          ['name' => 'Rajasree Majumdar', 'time' => '2 mois', 'text' => 'Service and product from sholaghar both are commendable.'],
          ['name' => 'Arkamitra Haldar', 'time' => '4 mois', 'text' => 'They have very beautiful and vast collection. The behaviour of the staff was so welcoming and helpful.'],
          ['name' => 'Subhashree Chakraborty', 'time' => '4 mois', 'text' => 'I have purchased my D day mukut from Shola Ghar. The detailing is very unique and beautiful.'],
          ['name' => 'Namrata Kundu', 'time' => '5 mois', 'text' => 'Their mukuts are very beautiful and has a very nice collection. Very satisfied with their products.'],
          ['name' => 'Priyaanka DAS', 'time' => '8 mois', 'text' => 'I got it for my wedding and the quality is good and also price is affordable.'],
        ]],
        'Siliguri' => ['slug' => 'siliguri', 'rating' => 4.9, 'count' => 108, 'img' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=300&h=300&fit=crop', 'reviews' => [
          ['name' => 'Nisha Mishty', 'time' => '2 mois', 'text' => 'My wedding date was decided last week. I had a very good experience at the store.'],
          ['name' => 'Suman Dasgupta', 'time' => '5 mois', 'text' => 'Excellent range of all wedding products at Shola Ghar, at their newly opened show room at Hill Cart Road.'],
          ['name' => 'Tamoha Sengupta', 'time' => '5 mois', 'text' => 'Just bought the most beautiful topor and mukut from sholaghar Siliguri!'],
          ['name' => 'Ozoswita Roy', 'time' => '6 mois', 'text' => 'Pretty good collection. Slightly expensive. Nonetheless worth it for the big day.'],
          ['name' => 'anushree Paul', 'time' => '8 mois', 'text' => 'I am too much happy so beautiful collection'],
        ]],
        'Kalighat' => ['slug' => 'kalighat', 'rating' => 4.9, 'count' => 37, 'img' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=300&h=300&fit=crop', 'reviews' => [
          ['name' => 'Anwesha Chakraborty', 'time' => '2 mois', 'text' => 'Very good collection'],
          ['name' => 'Suparna Banerjee', 'time' => '2 mois', 'text' => 'Nice collection'],
          ['name' => 'Sayantani Sarkar', 'time' => '2 mois', 'text' => 'Staff behavior was good. The collection was decent. Overall nice experience.'],
          ['name' => 'Sudha Mishra', 'time' => '2 mois', 'text' => 'Amazing collection, very polite staff, beautiful hand made artwork. Must come for wedding shopping.'],
          ['name' => 'Kausani Ganguli', 'time' => '2 mois', 'text' => 'Good'],
        ]],
      ]; ?>

      <div id="google-reviews-track" class="flex gap-4 overflow-x-auto scrollbar-hide pb-2 select-none" style="cursor:grab; scrollbar-width:none; -ms-overflow-style:none; user-select:none; -webkit-user-select:none;">
        <?php foreach ($googleReviews as $outletName => $data): $slug = $data['slug']; ?>
        <div class="shrink-0 w-[85vw] sm:w-[55vw] md:w-[40vw] lg:w-[28vw] bg-white rounded-2xl border border-slate-200 shadow-lg p-5 flex flex-col gap-3" id="outlet-<?= $slug ?>">
          <!-- Store header -->
          <div class="flex items-center gap-3">
            <img src="<?= $data['img'] ?>" alt="<?= $outletName ?>" class="w-14 h-14 rounded-xl object-cover border border-slate-100 shrink-0">
            <div>
              <h3 class="text-sm font-bold text-slate-800"><?= $outletName === 'Shobhabazar' ? 'Shola Ghar' : 'Shola Ghar - ' . $outletName ?></h3>
              <div class="flex items-center gap-1 mt-0.5">
                <div class="flex gap-0.5">
                  <?php for ($s = 1; $s <= 5; $s++): ?>
                  <svg class="w-3.5 h-3.5 <?= $s <= round($data['rating']) ? 'fill-amber-400 text-amber-400' : 'fill-slate-200 text-slate-200' ?>" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                  <?php endfor; ?>
                </div>
                <span class="text-xs font-semibold text-slate-600"><?= $data['rating'] ?></span>
              </div>
              <p class="text-[10px] text-slate-400">Based on <?= number_format($data['count']) ?> reviews</p>
              <p class="text-[10px] text-slate-400">powered by Google</p>
            </div>
          </div>

          <!-- Review us button -->
          <a href="https://search.google.com/local/writereview?placeid=" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-2 bg-[#1a73e8] hover:bg-[#1557b0] text-white text-xs font-bold py-2 px-4 rounded-full transition-colors w-full">
            <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/><path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
            Review us on Google
          </a>

          <!-- Review card with pagination -->
          <div class="relative" id="rv-<?= $slug ?>">
            <?php $profileImgs = [
              'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80',
              'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80',
              'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=80',
              'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=80',
              'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=80',
            ]; foreach ($data['reviews'] as $ri => $rv): $pfi = $profileImgs[$ri % count($profileImgs)]; ?>
            <div class="review-card-<?= $slug ?> <?= $ri === 0 ? '' : 'hidden' ?>">
              <div class="flex gap-3 mb-2">
                <img src="<?= $pfi ?>" alt="" class="w-9 h-9 rounded-full object-cover shrink-0 border border-slate-200" loading="lazy">
                <div class="flex-1 min-w-0">
                  <p class="text-xs font-bold text-slate-700 truncate"><?= $rv['name'] ?></p>
                  <div class="flex items-center gap-1 text-[10px] text-slate-500">
                    <div class="flex gap-0.5">
                      <svg class="w-3 h-3 fill-amber-400 text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                      <svg class="w-3 h-3 fill-amber-400 text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                      <svg class="w-3 h-3 fill-amber-400 text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                      <svg class="w-3 h-3 fill-amber-400 text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                      <svg class="w-3 h-3 fill-amber-400 text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <span>•</span>
                    <span><?= $rv['time'] ?></span>
                  </div>
                </div>
              </div>
              <p class="text-xs text-slate-600 leading-relaxed"><?= $rv['text'] ?></p>
            </div>
            <?php endforeach; ?>
            <!-- Navigation buttons -->
            <div class="flex items-center justify-center gap-3 mt-3 pt-2 border-t border-slate-100">
              <button onclick="rvNav('<?= $slug ?>', -1)" class="w-7 h-7 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
              </button>
              <span class="text-[10px] text-slate-400 font-medium" id="rv-counter-<?= $slug ?>">1/<?= count($data['reviews']) ?></span>
              <button onclick="rvNav('<?= $slug ?>', 1)" class="w-7 h-7 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
              </button>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <style>.scrollbar-hide::-webkit-scrollbar { display: none; }</style>
      <script>
      (function(){
        var el=document.getElementById('google-reviews-track');
        if(!el)return;
        var down=false,startX=0,scrollLeft=0;
        el.addEventListener('mousedown',function(e){down=true;startX=e.pageX;scrollLeft=el.scrollLeft;el.style.cursor='grabbing';});
        window.addEventListener('mousemove',function(e){if(!down)return;e.preventDefault();var walk=e.pageX-startX;el.scrollLeft=scrollLeft-walk;});
        window.addEventListener('mouseup',function(){down=false;if(el)el.style.cursor='grab';});
        var timers = {};
        window.rvNav = function(slug, dir) {
          var cards = document.querySelectorAll('.review-card-' + slug);
          var visible = -1;
          cards.forEach(function(c, i) { if (!c.classList.contains('hidden')) visible = i; });
          if (visible < 0) visible = 0;
          cards[visible].classList.add('hidden');
          var next = (visible + dir + cards.length) % cards.length;
          cards[next].classList.remove('hidden');
          var ctr = document.getElementById('rv-counter-' + slug);
          if (ctr) ctr.textContent = (next + 1) + '/' + cards.length;
          if (timers[slug]) { clearInterval(timers[slug]); }
          timers[slug] = setInterval(function(){ window.rvNav(slug, 1); }, 5000);
        };
        var slugs = <?= json_encode(array_map(function($v){return $v['slug'];}, $googleReviews)) ?>;
        slugs.forEach(function(s) { timers[s] = setInterval(function(){ window.rvNav(s, 1); }, 5000); });
      })();
      </script>
    </section>

  </main>

  <!-- WHATSAPP FLOATING BUTTON -->
  <a href="https://wa.me/<?= e($whatsappNumber) ?>" target="_blank" rel="noopener noreferrer" class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-all active:scale-95 duration-200 group" aria-label="Contact WhatsApp">
    <span class="absolute inset-0 w-full h-full bg-emerald-500 rounded-full animate-ping opacity-25 group-hover:opacity-0 transition-opacity"></span>
    <svg class="w-8 h-8 relative z-10 fill-current" viewBox="0 0 24 24">
      <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.457L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.965C16.528 2.01 14.069.987 11.487.987c-5.443 0-9.867 4.371-9.871 9.8a9.697 9.697 0 001.533 5.093l-.38 1.387 1.446-.375-.38 1.388c-.973-1.012-1.464-2.316-1.463-3.69l.39-1.432zM17.486 14.4c-.3-.149-1.774-.864-2.049-.963-.274-.099-.474-.149-.673.149-.2.297-.773.963-.948 1.161-.174.198-.349.223-.649.074-.3-.149-1.265-.461-2.41-1.472-.891-.786-1.493-1.756-1.668-2.053-.174-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.1-.198.05-.371-.025-.52-.075-.149-.672-1.62-.921-2.206-.243-.584-.488-.505-.672-.515-.173-.008-.372-.01-.57-.01-.2 0-.523.074-.797.371-.273.297-1.045 1.016-1.045 2.477 0 1.46 1.07 2.872 1.219 3.07.149.198 2.105 3.173 5.099 4.441.713.303 1.27.484 1.703.62.715.225 1.367.193 1.882.117.574-.085 1.774-.717 2.023-1.411.249-.693.249-1.287.174-1.411-.074-.124-.272-.198-.57-.347z"/>
    </svg>
  </a>

</div>

<script>
(function() {
  var track = document.getElementById('recent-track');
  var viewport = document.getElementById('recent-viewport');
  if (!track || !viewport) return;
  var page = 0, items = track.children;
  if (!items.length) return;
  function getVisible() { return window.innerWidth >= 1024 ? 6 : window.innerWidth >= 768 ? 3 : 2; }
  function updateBtns() {
    var btns = document.querySelectorAll('.recent-page-btn');
    btns.forEach(function(b) {
      var p = parseInt(b.getAttribute('data-page'));
      if (p === page) {
        b.className = 'w-2.5 h-2.5 rounded-full recent-page-btn bg-slate-500';
      } else {
        b.className = 'w-2.5 h-2.5 rounded-full recent-page-btn bg-slate-300';
      }
    });
  }
  function go(d) {
    var v = getVisible();
    var total = Math.ceil(items.length / v);
    page = Math.max(0, Math.min(page + d, total - 1));
    track.style.transform = 'translateX(-' + (page * v / items.length * 100) + '%)';
    track.style.transition = 'transform 0.5s ease-in-out';
    updateBtns();
  }
  window.recentScroll = go;
  window.recentPageNav = function(p) {
    var v = getVisible();
    var total = Math.ceil(items.length / v);
    page = Math.max(0, Math.min(p, total - 1));
    track.style.transform = 'translateX(-' + (page * v / items.length * 100) + '%)';
    track.style.transition = 'transform 0.5s ease-in-out';
    updateBtns();
  };
  updateBtns();

  /* Category step carousel (8 per slide) */
  (function() {
    var track = document.getElementById('catTrackHome');
    if (!track) return;
    var slides = track.children;
    if (slides.length < 2) return;
    var cur = 0;
    setInterval(function() {
      cur = (cur + 1) % slides.length;
      track.style.transform = 'translateX(-' + (cur * 100 / slides.length) + '%)';
      track.style.transition = 'transform 0.5s ease-in-out';
    }, 3000);
  })();

  var imgs = document.querySelectorAll('.product-img');
  imgs.forEach(function(img) {
    var src = img.getAttribute('data-images');
    if (!src) return;
    var list;
    try { list = JSON.parse(src); } catch(e) { return; }
    if (!list || list.length < 2) return;
    var idx = 0;
    setInterval(function() {
      idx = (idx + 1) % list.length;
      img.style.opacity = '0';
      img.style.transition = 'opacity 0.4s ease';
      setTimeout(function() {
        img.src = list[idx];
        img.style.opacity = '1';
      }, 400);
    }, 3000);
  });
})();
</script>
