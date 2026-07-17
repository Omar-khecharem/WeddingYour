<?php
$categories = $categories ?? [];
$featuredProducts = $featuredProducts ?? [];
$trendingProducts = $trendingProducts ?? [];
$recentProducts = $recentProducts ?? [];
$reviews = $reviews ?? [];
$banners = $banners ?? [];
$deals = $deals ?? [];
$categoryCards = $categoryCards ?? [];
$categoryCardProducts = $categoryCardProducts ?? [];
$defaultCardFallback = $defaultCardFallback ?? [];
$galleryItems = $galleryItems ?? [];
$outlets = $outlets ?? [];
$whatsappNumber = $whatsappNumber ?? '+919830136355';
$videoShowcaseBg = $videoShowcaseBg ?? '';
?>
<div class="min-h-screen bg-slate-50 font-sans text-slate-800 antialiased selection:bg-red-500 selection:text-white">

  <main class="max-w-7xl mx-auto px-4 py-6 space-y-8">

    <?php $subList = $subcategories; if (empty($subList)): $subList = [['slug'=>'bridal-patashi-mukut','name'=>'Bridal Patashi','cat_slug'=>'bride'],['slug'=>'sithi-small-mukut','name'=>'Sithi Mukut','cat_slug'=>'bride'],['slug'=>'topor-mukut-set','name'=>'Topor Set','cat_slug'=>'groom'],['slug'=>'baby-topor-boy','name'=>'Baby Topor','cat_slug'=>'baby'],['slug'=>'groom-dorpon','name'=>'Dorpon','cat_slug'=>'groom'],['slug'=>'matha-patti','name'=>'Matha Patti','cat_slug'=>'sholas-jewellery'],['slug'=>'wedding-panpata','name'=>'Panpata','cat_slug'=>'wedding-items'],['slug'=>'mini-crown','name'=>'Mini Crown','cat_slug'=>'sholas-jewellery']]; endif; ?>
    <section class="py-2 overflow-hidden select-none" id="subcatSectionHome">
      <div id="subcatScrollHome" class="flex gap-3 md:gap-4 overflow-x-auto px-4 pb-2 scrollbar-hide" style="cursor:grab; scrollbar-width:none; -ms-overflow-style:none; user-select:none; -webkit-user-select:none; -webkit-overflow-scrolling:touch;">
        <?php foreach ($subList as $sub): ?>
        <?php $subSlug = is_array($sub) ? ($sub['slug'] ?? '') : $sub; ?>
        <?php $subName = is_array($sub) ? ($sub['name'] ?? '') : $sub; ?>
        <?php $subImg = is_array($sub) ? ($sub['image'] ?? '') : ''; ?>
        <?php $subCatSlug = is_array($sub) ? ($sub['cat_slug'] ?? '') : ''; ?>
        <a href="<?= url('products?category=' . e($subCatSlug) . '&subcategory=' . e($subSlug)) ?>" draggable="false" ondragstart="return false" class="flex flex-col items-center text-center space-y-2 w-[90px] min-[400px]:w-[100px] sm:w-[110px] md:w-[120px] lg:w-[130px] shrink-0 group">
          <div class="w-full aspect-square rounded-3xl overflow-hidden border-2 border-slate-100 group-hover:border-red-600 group-hover:scale-105 transition-all duration-300 shadow-md group-hover:shadow-xl">
            <?php if ($subImg): ?>
            <img src="<?= uploadUrl($subImg, 'categories') ?>" alt="<?= e($subName) ?>" class="w-full h-full object-cover" loading="lazy" draggable="false">
            <?php else: ?>
            <div class="w-full h-full bg-gradient-to-br from-red-50 to-slate-100 flex items-center justify-center font-bold text-slate-400"><?= e(substr($subName, 0, 2)) ?></div>
            <?php endif; ?>
          </div>
          <span class="text-[10px] min-[400px]:text-[11px] sm:text-xs md:text-sm font-semibold leading-tight text-slate-700 group-hover:text-red-600 transition-colors"><?= e($subName) ?></span>
        </a>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- ============ HERO: VIDEO (LEFT) + IMAGE CAROUSEL (RIGHT) ============ -->
    <?php
      $heroLeftBanners = array_filter($banners, fn($b) => ($b['position'] ?? '') === 'hero_left');
      $heroRightBanners = array_filter($banners, fn($b) => ($b['position'] ?? '') === 'hero_right');
      $heroVideo = $heroLeftBanners ? current($heroLeftBanners) : null;
      $videoUrl = $heroVideo['video'] ?? $heroVideo['image'] ?? '';
    ?>
    <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- LEFT: Video -->
      <div class="relative overflow-hidden rounded-2xl shadow-lg aspect-video bg-black">
        <?php if ($videoUrl): ?>
        <video class="w-full h-full object-cover" autoplay muted loop playsinline>
          <?php $vext = strtolower(pathinfo($videoUrl, PATHINFO_EXTENSION)); $vmime = $vext === 'webm' ? 'webm' : ($vext === 'ogg' ? 'ogg' : ($vext === 'mov' ? 'quicktime' : 'mp4')); ?>
          <source src="<?= uploadUrl($videoUrl) ?>" type="video/<?= $vmime ?>">
        </video>
        <?php else: ?>
        <div class="w-full h-full flex items-center justify-center text-slate-400 text-sm font-medium bg-slate-800">Upload video in banner position "hero_left"</div>
        <?php endif; ?>
        <div class="absolute inset-0 bg-black/20 flex items-center justify-center pointer-events-none">
          <div class="w-16 h-16 bg-white/80 rounded-full flex items-center justify-center shadow-lg">
            <svg class="w-8 h-8 text-red-600 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
          </div>
        </div>
      </div>

      <!-- RIGHT: Image carousel -->
      <div class="relative overflow-hidden rounded-2xl shadow-lg aspect-video bg-slate-100">
        <?php if (!empty($heroRightBanners)): $hr = array_values($heroRightBanners); ?>
        <div id="heroRightTrack" class="flex transition-transform duration-500 ease-in-out h-full">
          <?php foreach ($hr as $bi => $b): ?>
          <div class="w-full h-full flex-shrink-0 relative">
            <?php if (!empty($b['image'])): ?>
            <img src="<?= uploadUrl($b['image']) ?>" alt="<?= e($b['title'] ?? '') ?>" class="w-full h-full object-cover">
            <?php else: ?>
            <div class="w-full h-full bg-gradient-to-br from-slate-200 to-slate-300 flex items-center justify-center text-slate-400 font-bold">Image</div>
            <?php endif; ?>
            <?php if (!empty($b['link'])): ?><a href="<?= e($b['link']) ?>" class="absolute inset-0"></a><?php endif; ?>
          </div>
          <?php endforeach; ?>
        </div>
        <?php if (count($hr) > 1): ?>
        <button onclick="heroRightSlide(-1)" class="absolute left-2 top-1/2 -translate-y-1/2 z-10 w-8 h-8 bg-white/70 hover:bg-white rounded-full flex items-center justify-center text-slate-600 shadow"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg></button>
        <button onclick="heroRightSlide(1)" class="absolute right-2 top-1/2 -translate-y-1/2 z-10 w-8 h-8 bg-white/70 hover:bg-white rounded-full flex items-center justify-center text-slate-600 shadow"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></button>
        <?php endif; ?>
        <?php else: ?>
        <div class="w-full h-full flex items-center justify-center text-slate-300 text-sm font-medium">Add banner with position "hero_right"</div>
        <?php endif; ?>
      </div>
    </section>

    <section class="space-y-6">
      <div class="flex items-center justify-between border-b border-slate-200 pb-4">
        <h2 class="text-2xl font-black text-slate-800 tracking-tight">Our Popular Creations</h2>
        <a href="<?= url('products') ?>" class="text-sm font-bold text-red-600 hover:text-red-700 flex items-center gap-1 transition-all">View All <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
      </div>
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-7 gap-4">
        <?php $displayProducts = array_slice(array_merge($featuredProducts, $trendingProducts, $recentProducts), 0, 7); ?>
        <?php foreach ($displayProducts as $product): ?>
        <?php $pImg = is_array($product) ? ($product['image'] ?? '') : ($product->image ?? ''); ?>
        <?php $pName = is_array($product) ? ($product['name'] ?? '') : ($product->name ?? ''); ?>
        <?php $pSlug = is_array($product) ? ($product['slug'] ?? '#') : ($product->slug ?? '#'); ?>
        <?php $pReg = is_array($product) ? ($product['regular_price'] ?? 0) : ($product->regular_price ?? 0); ?>
        <?php $pSale = is_array($product) ? ($product['sale_price'] ?? null) : ($product->sale_price ?? null); ?>
        <?php $pDisc = is_array($product) ? ($product['discount_percent'] ?? 0) : ($product->discount_percent ?? 0); ?>
        <?php $pCat = is_array($product) ? ($product['category_name'] ?? '') : ($product->category_name ?? ''); ?>
        <?php $pSub = is_array($product) ? ($product['subcategory_name'] ?? '') : ($product->subcategory_name ?? ''); ?>
        <?php $pId = is_array($product) ? ($product['id'] ?? 0) : ($product->id ?? 0); ?>
        <?php $rAvg = $homeRatings[$pId]['average'] ?? 0; $rTot = $homeRatings[$pId]['total'] ?? 0; ?>
        <div onclick="window.location='<?= url('product/' . e($pSlug)) ?>'" class="cursor-pointer group relative bg-white border border-red-100 hover:border-red-400 rounded-xl overflow-hidden shadow-sm hover:shadow-lg flex flex-col">
          <?php if ($pDisc): ?>
          <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-black px-2 py-0.5 rounded-md z-20">-<?= (int)$pDisc ?>%</span>
          <?php endif; ?>
          <div class="relative aspect-square w-full overflow-hidden bg-slate-50">
            <a href="<?= url('product/' . e($pSlug)) ?>" class="block w-full h-full">
              <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="<?= e($pImg ?: 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=300&auto=format&fit=crop&q=80') ?>" alt="<?= e($pName) ?>" loading="lazy">
            </a>
            <div class="absolute inset-0 bg-black/75 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-center items-center p-3 text-white text-center z-10">
            <h4 class="text-xs font-black uppercase tracking-wide"><?= e($pName) ?></h4>
            <p class="text-[10px] text-red-300 font-semibold mt-0.5"><?= e($pCat) ?>, <?= e($pSub) ?></p>
            <?= renderStars($rAvg) ?>
            <?php if ($rTot > 0): ?><span class="text-[10px] text-gray-400">(<?= $rTot ?>)</span><?php endif; ?>
            <span class="text-[10px] text-emerald-300 font-bold mt-0.5">In stock</span>
            <div class="mt-1">
              <span class="text-sm font-black text-white"><?= formatPrice($pSale ?: $pReg) ?></span>
              <?php if ($pSale): ?>
              <span class="text-[10px] text-slate-400 line-through ml-1"><?= formatPrice($pReg) ?></span>
              <?php endif; ?>
            </div>
            <div class="flex items-center gap-1.5 mt-2">
              <button onclick="event.stopPropagation();addToCart(<?= $pId ?>, 1)" class="bg-red-600 hover:bg-red-700 text-white text-[10px] font-bold px-2 py-1.5 rounded transition-colors flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg> Cart
              </button>
              <button onclick="event.stopPropagation();toggleCompare(<?= $pId ?>)" class="bg-slate-700 hover:bg-slate-600 text-white text-[10px] font-bold px-2 py-1.5 rounded transition-colors flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
              </button>
              <button onclick="event.stopPropagation();quickView(<?= $pId ?>)" class="bg-slate-700 hover:bg-slate-600 text-white text-[10px] font-bold px-2 py-1.5 rounded transition-colors flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              </button>
            </div>
            <button data-wishlist="<?= $pId ?>" onclick="event.stopPropagation();toggleWishlist(<?= $pId ?>)" class="mt-1.5 bg-white/20 hover:bg-white/30 text-white text-[10px] font-bold px-2 py-0.5 rounded-full transition-colors flex items-center gap-1">
              <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg> Wishlist
            </button>
          </div>
        </div>
        </div>
        <?php endforeach; ?>
        <?php if (empty($displayProducts)): ?>
        <?php $demoProducts = [['slug'=>'#','name'=>'Crown','category_name'=>'BRIDE','subcategory_name'=>'Crown & 3 Pieces Set','regular_price'=>3000,'sale_price'=>1790,'discount_percent'=>40],['slug'=>'#','name'=>'Panpata','category_name'=>'BRIDE','subcategory_name'=>'Panpata','regular_price'=>2500,'sale_price'=>1450,'discount_percent'=>42],['slug'=>'#','name'=>'Piri','category_name'=>'BRIDE','subcategory_name'=>'Piri','regular_price'=>2200,'sale_price'=>1342,'discount_percent'=>39],['slug'=>'#','name'=>'Tattwasuchi','category_name'=>'BRIDE','subcategory_name'=>'Tattwa Suchi','regular_price'=>3500,'sale_price'=>1400,'discount_percent'=>60],['slug'=>'#','name'=>'Topor Mukut','category_name'=>'GROOM','subcategory_name'=>'Topor Mukut','regular_price'=>1800,'sale_price'=>1188,'discount_percent'=>34],['slug'=>'#','name'=>'Gachhkouto','category_name'=>'WEDDING','subcategory_name'=>'Gachhkouto','regular_price'=>2800,'sale_price'=>1876,'discount_percent'=>33],['slug'=>'#','name'=>'Khoidan Kulo','category_name'=>'WEDDING','subcategory_name'=>'Khoidan Kulo','regular_price'=>3200,'sale_price'=>1600,'discount_percent'=>50]]; foreach ($demoProducts as $product): ?>
        <div class="group relative bg-white border border-red-100 hover:border-red-400 rounded-xl overflow-hidden transition-all duration-300 shadow-sm hover:shadow-lg flex flex-col">
          <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-black px-2 py-0.5 rounded-md z-20">-<?= $product['discount_percent'] ?>%</span>
          <a href="#" class="aspect-square w-full overflow-hidden bg-slate-50 block">
            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=300" alt="<?= $product['name'] ?>" loading="lazy">
          </a>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>

    <section class="relative overflow-hidden rounded-2xl shadow-lg group w-full">
      <?php $promoBanner = current(array_filter($banners, fn($b)=>($b['position']??'')==='promotional')) ?: null; ?>
      <a href="<?= e(($promoBanner['link'] ?? '#') ?: url('products?on_sale=1')) ?>" class="block w-full">
        <?php if ($promoBanner && !empty($promoBanner['image'])): ?>
        <img src="<?= uploadUrl($promoBanner['image']) ?>" alt="Promotion" class="w-full h-auto group-hover:scale-105 transition-transform duration-700 rounded-2xl">
        <?php else: ?>
        <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=1400&auto=format&fit=crop&q=80" alt="Promotion" class="w-full h-auto group-hover:scale-105 transition-transform duration-700 rounded-2xl">
        <?php endif; ?>
      </a>
    </section>

    <section class="space-y-4">
      <h2 class="text-xl md:text-2xl font-black text-slate-800 tracking-tight text-center">Best Deal For You</h2>
      <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
        <?php if (!empty($deals)): ?>
        <?php foreach ($deals as $deal): ?>
        <div class="relative overflow-hidden rounded-xl shadow-md group bg-gray-50" style="min-height:180px;display:flex;align-items:center;justify-content:center">
          <img src="<?= !empty($deal['image']) ? uploadUrl($deal['image'], 'deals') : 'https://images.unsplash.com/photo-1519741497674-611481863552?w=400' ?>" alt="Deal" class="w-full object-contain group-hover:scale-105 transition-transform duration-500" style="max-height:300px">
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <?php for($i=0;$i<6;$i++): ?>
        <div class="relative overflow-hidden rounded-xl shadow-md group bg-gray-50" style="min-height:180px;display:flex;align-items:center;justify-content:center">
          <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=400&auto=format&fit=crop&q=80" alt="Deal" class="w-full object-contain group-hover:scale-105 transition-transform duration-500" style="max-height:300px">
        </div>
        <?php endfor; ?>
        <?php endif; ?>
      </div>
    </section>

    <section class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
      <?php if (!empty($categoryCards)): ?>
      <?php foreach ($categoryCards as $i => $card): ?>
      <?php $cardProds = $categoryCardProducts[$i] ?? []; ?>
      <div class="bg-white rounded-xl shadow-md overflow-hidden border border-slate-100 hover:shadow-lg transition-shadow">
        <div class="p-3">
          <h3 class="text-sm font-black text-slate-800 uppercase tracking-wide mb-2"><?= e($card['title'] ?? '') ?></h3>
          <div class="grid grid-cols-2 gap-1.5">
            <?php foreach ([0,1,2,3] as $pi): $cp = $cardProds[$pi] ?? null; ?>
            <?php if ($cp && !empty($cp['slug'])): ?>
            <a href="<?= url('product/' . e($cp['slug'])) ?>" class="block aspect-square rounded-lg overflow-hidden bg-slate-50 animate-fadeInUp" style="animation-delay:<?= $pi * 0.08 ?>s">
              <img src="<?= e($cp['image'] ?: 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=150') ?>" alt="" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" loading="lazy">
            </a>
            <?php else: ?>
            <div class="w-full aspect-square rounded-lg bg-gradient-to-br from-red-50 to-slate-100"></div>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
          <a href="<?= e($card['link'] ?? url('products?category=' . ($card['category_id'] ?? ''))) ?>" class="mt-2 text-xs font-bold text-red-600 hover:text-red-700 flex items-center gap-1 justify-end">See more <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></a>
        </div>
      </div>
      <?php endforeach; ?>
      <?php else: ?>
      <?php $defaultCards = [['title'=>'Mukut & Topor','link'=>url('products?category=mukut-mariee')],['title'=>'Wedding Items for All','link'=>url('products?category=articles-mariage')],['title'=>'Gachhkouto & Dorpon','link'=>url('products?category=gachhkouto-dorpon')],['title'=>'Best Seller Items','link'=>url('products?sort=popular')]]; foreach ($defaultCards as $i => $card): ?>
      <?php $cardProds = $defaultCardFallback[$i] ?? []; ?>
      <div class="bg-white rounded-xl shadow-md overflow-hidden border border-slate-100 hover:shadow-lg transition-shadow">
        <div class="p-3">
          <h3 class="text-sm font-black text-slate-800 uppercase tracking-wide mb-2"><?= $card['title'] ?></h3>
          <div class="grid grid-cols-2 gap-1.5">
            <?php foreach ([0,1,2,3] as $pi): $cp = $cardProds[$pi] ?? null; ?>
            <?php if ($cp && !empty($cp['slug'])): ?>
            <a href="<?= url('product/' . e($cp['slug'])) ?>" class="block aspect-square rounded-lg overflow-hidden bg-slate-50 animate-fadeInUp" style="animation-delay:<?= $pi * 0.08 ?>s">
              <img src="<?= e($cp['image'] ?: 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=150') ?>" alt="" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" loading="lazy">
            </a>
            <?php else: ?>
            <div class="w-full aspect-square rounded-lg bg-gradient-to-br from-red-50 to-slate-100"></div>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
          <a href="<?= $card['link'] ?>" class="mt-2 text-xs font-bold text-red-600 hover:text-red-700 flex items-center gap-1 justify-end">See more <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></a>
        </div>
      </div>
      <?php endforeach; ?>
      <?php endif; ?>
    </section>

    <?php $brideVideo = current(array_filter($banners, fn($b)=>($b['position']??'')==='bride_video')) ?: null; $bvUrl = $brideVideo['video'] ?? $brideVideo['image'] ?? ''; ?>
    <section class="relative overflow-hidden rounded-2xl shadow-lg bg-slate-900 aspect-video flex items-center justify-center">
      <?php if ($bvUrl): ?>
      <video class="w-full h-full object-cover" autoplay muted loop playsinline>
        <?php $bvext = strtolower(pathinfo($bvUrl, PATHINFO_EXTENSION)); $bvmime = $bvext === 'webm' ? 'webm' : ($bvext === 'ogg' ? 'ogg' : ($bvext === 'mov' ? 'quicktime' : 'mp4')); ?>
        <source src="<?= uploadUrl($bvUrl) ?>" type="video/<?= $bvmime ?>">
      </video>
      <?php else: ?>
      <div class="text-center text-white p-8">
        <svg class="w-16 h-16 mx-auto mb-4 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
        <p class="text-lg font-bold">Bride Video</p>
        <p class="text-sm text-slate-400 mt-1">Upload bride video in banner position "bride_video"</p>
      </div>
      <?php endif; ?>
    </section>

    <section class="space-y-4">
      <h2 class="text-xl md:text-2xl font-black text-slate-800 tracking-tight text-center">Top Trending Categories</h2>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <?php $trendingCats = array_slice($categories, 0, 4); ?>
        <?php if (!empty($trendingCats)): ?>
        <?php foreach ($trendingCats as $cat): $cs = is_array($cat) ? ($cat['slug']??'') : $cat; $cn = is_array($cat) ? ($cat['name']??'') : $cat; $ci = is_array($cat) ? ($cat['image']??'') : ''; ?>
        <a href="<?= url('products?category=' . e($cs)) ?>" class="flex flex-col items-center gap-2 group">
          <div class="w-full aspect-[4/3] rounded-xl overflow-hidden shadow-md">
            <?php if ($ci): ?>
            <img src="<?= uploadUrl($ci, 'categories') ?>" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            <?php else: ?>
            <div class="w-full h-full bg-gradient-to-br from-red-50 to-slate-100 flex items-center justify-center font-bold text-slate-300"><?= e(substr($cn,0,2)) ?></div>
            <?php endif; ?>
          </div>
          <span class="text-xs font-bold text-white bg-red-600 px-4 py-1.5 rounded-full"><?= e($cn) ?></span>
        </a>
        <?php endforeach; ?>
        <?php else: ?>
        <a href="<?= url('products') ?>" class="flex flex-col items-center gap-2 group">
          <div class="w-full aspect-[4/3] rounded-xl overflow-hidden shadow-md bg-gradient-to-br from-red-50 to-slate-100"></div>
          <span class="text-xs font-bold text-white bg-red-600 px-4 py-1.5 rounded-full">Wedding Items</span>
        </a>
        <a href="<?= url('products') ?>" class="flex flex-col items-center gap-2 group">
          <div class="w-full aspect-[4/3] rounded-xl overflow-hidden shadow-md bg-gradient-to-br from-red-50 to-slate-100"></div>
          <span class="text-xs font-bold text-white bg-red-600 px-4 py-1.5 rounded-full">Bride</span>
        </a>
        <a href="<?= url('products') ?>" class="flex flex-col items-center gap-2 group">
          <div class="w-full aspect-[4/3] rounded-xl overflow-hidden shadow-md bg-gradient-to-br from-red-50 to-slate-100"></div>
          <span class="text-xs font-bold text-white bg-red-600 px-4 py-1.5 rounded-full">Groom</span>
        </a>
        <a href="<?= url('products') ?>" class="flex flex-col items-center gap-2 group">
          <div class="w-full aspect-[4/3] rounded-xl overflow-hidden shadow-md bg-gradient-to-br from-red-50 to-slate-100"></div>
          <span class="text-xs font-bold text-white bg-red-600 px-4 py-1.5 rounded-full">Baby</span>
        </a>
        <?php endif; ?>
      </div>
      <div class="text-center">
        <a href="<?= url('products') ?>" class="inline-flex items-center gap-2 text-sm font-bold text-red-600 hover:text-red-700 transition-colors">View All Categories <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg></a>
      </div>
    </section>

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
          <?php $rp = array_slice($recentProducts, 0, 12); if (empty($rp)): $rp = array_fill(0,8,['name'=>'Product','category_name'=>'BRIDE','subcategory_name'=>'Wedding Item','tags'=>'Exclusive','regular_price'=>1499,'sale_price'=>799,'discount_percent'=>47]); endif; ?>
          <?php foreach ($rp as $p): ?>
          <?php $pn = is_array($p) ? ($p['name']??'') : ($p->name??''); $pc = is_array($p) ? ($p['category_name']??'') : ($p->category_name??''); $ps = is_array($p) ? ($p['subcategory_name']??'') : ($p->subcategory_name??''); $pt = is_array($p) ? ($p['tags']??'') : ($p->tags??''); ?>
          <?php $pr = is_array($p) ? ($p['regular_price']??0) : ($p->regular_price??0); $psl = is_array($p) ? ($p['sale_price']??0) : ($p->sale_price??0); $pd = is_array($p) ? ($p['discount_percent']??0) : ($p->discount_percent??0); ?>
          <?php $pimg = is_array($p) ? ($p['image']??'') : ($p->image??''); $pSlug = is_array($p) ? ($p['slug']??'#') : ($p->slug??'#'); $pId = is_array($p) ? ($p['id']??0) : ($p->id??0); $rAvg = $homeRatings[$pId]['average'] ?? 0; $rTot = $homeRatings[$pId]['total'] ?? 0; ?>
          <div class="w-1/2 md:w-1/3 lg:w-1/6 flex-shrink-0 px-1.5 md:px-2">
          <div class="bg-slate-100 border border-red-100 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow flex flex-col h-full">
            <div class="relative group/img">
              <?php if ($pd): ?>
              <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-black px-2 py-0.5 rounded-md z-10">-<?= (int)$pd ?>%</span>
              <?php endif; ?>
              <div class="aspect-[4/3] w-full overflow-hidden bg-slate-50">
                <?php if ($pimg): ?>
                <img src="<?= e($pimg) ?>" alt="<?= e($pn) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                <?php else: ?>
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-red-50 to-slate-100 text-slate-300 font-bold"><?= e(substr($pn,0,2)) ?></div>
                <?php endif; ?>
              </div>
              <div class="absolute bottom-0 left-0 right-0 flex items-center justify-center gap-1.5 p-2 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover/img:opacity-100 transition-opacity duration-300">
                <button onclick="addToCart(<?= $pId ?>,1)" class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-slate-700 hover:bg-red-600 hover:text-white transition-colors shadow-md" title="Cart">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                </button>
                <button onclick="quickView(<?= $pId ?>)" class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-slate-700 hover:bg-red-600 hover:text-white transition-colors shadow-md hidden md:flex" title="Quick view">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </button>
                <button data-compare="<?= $pId ?>" onclick="addToCompare(<?= $pId ?>)" class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-slate-700 hover:bg-red-600 hover:text-white transition-colors shadow-md hidden md:flex" title="Compare">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </button>
                <button data-wishlist="<?= $pId ?>" onclick="toggleWishlist(<?= $pId ?>)" class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-slate-700 hover:bg-red-600 hover:text-white transition-colors shadow-md" title="Wishlist">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </button>
              </div>
            </div>
            <div class="p-3 flex flex-col gap-1.5 flex-1">
              <h4 class="text-xs font-black uppercase tracking-wide text-slate-800"><?= e($pn) ?></h4>
              <p class="text-[10px] text-slate-500 font-medium leading-tight flex flex-wrap gap-x-1">
                <a href="<?= url('products?category=' . urlencode($pc)) ?>" class="hover:text-red-600 transition-colors"><?= e($pc) ?></a><span class="text-slate-300">,</span>
                <span class="hover:text-red-600 transition-colors"><?= e($ps) ?></span>
              </p>
              <span class="text-[10px] text-emerald-600 font-bold flex items-center gap-1">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> In stock
              </span>
              <?= renderStars($rAvg) ?>
              <?php if ($rTot > 0): ?><span class="text-[10px] text-gray-400">(<?= $rTot ?>)</span><?php endif; ?>
              <div class="flex items-center gap-2">
                <span class="text-sm font-black text-red-600"><?= formatPrice($psl ?: $pr) ?></span>
                <?php if ($psl): ?>
                <span class="text-[10px] text-slate-400 line-through"><?= formatPrice($pr) ?></span>
                <?php endif; ?>
              </div>
            </div>
          </div>
          </div>
          <?php endforeach; ?>
        </div>
        </div>
      </div>
      <div class="flex items-center justify-center gap-2 pt-1" id="recent-dots"></div>
    </section>

    <div class="flex justify-center pt-2">
      <a href="<?= url('products') ?>" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold text-sm px-6 py-3 rounded-full transition-colors shadow-md hover:shadow-lg">
        View All Products
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
      </a>
    </div>

   
    <section class="space-y-4 bg-[#EF5350] py-8 -mx-4 px-4">
      <h2 class="text-xl md:text-2xl font-black text-white tracking-tight text-center">Have some memories!</h2>
      <div id="memories-scroll" class="flex gap-4 overflow-x-auto scrollbar-hide -mx-4 px-4 pb-2 select-none" style="cursor:grab; scrollbar-width:none; -ms-overflow-style:none; user-select:none; -webkit-user-select:none;">
        <?php $memItems = array_slice($galleryItems, 0, 6); if (empty($memItems)): $memItems = array_fill(0,4,['image'=>'']); endif; ?>
        <?php foreach ($memItems as $mi): $miImg = is_array($mi) ? ($mi['image']??'') : ($mi->image??''); ?>
        <div class="shrink-0 w-[60vw] sm:w-[35vw] md:w-[25vw] lg:w-[18vw] rounded-2xl overflow-hidden border-2 border-white/30 shadow-lg bg-white">
          <?php if ($miImg): ?>
          <img src="<?= uploadUrl($miImg, 'gallery') ?>" alt="Memory" class="w-full h-auto object-cover pointer-events-none" loading="lazy" draggable="false" style="aspect-ratio:2/3">
          <?php else: ?>
          <div class="w-full bg-gradient-to-br from-red-50 to-white flex items-center justify-center font-bold text-slate-300" style="aspect-ratio:2/3">Gallery</div>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
      <style>
        @keyframes fadeInUp {
          from { opacity: 0; transform: translateY(16px); }
          to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp {
          animation: fadeInUp 0.4s ease-out both;
        }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
      </style>
      <script>(function(){var el=document.getElementById('memories-scroll');if(!el)return;var down=false,startX=0,scrollLeft=0;el.addEventListener('mousedown',function(e){down=true;startX=e.pageX;scrollLeft=el.scrollLeft;el.style.cursor='grabbing';});window.addEventListener('mousemove',function(e){if(!down)return;e.preventDefault();var walk=e.pageX-startX;el.scrollLeft=scrollLeft-walk;});window.addEventListener('mouseup',function(){down=false;if(el)el.style.cursor='grab';});})();</script>
    </section>

    <section class="space-y-6 text-center">
      <a href="<?= url('outlets') ?>" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold text-base px-8 py-3 rounded-full transition-colors shadow-md"><?= e(\App\Models\Setting::get('site_name', 'Shola Ghar')) ?>'s Outlets</a>
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <?php if (!empty($outlets)): ?>
        <?php foreach ($outlets as $o): $oName = is_array($o) ? ($o['name']??'') : ($o->name??''); $oImg = is_array($o) ? ($o['image']??'') : ($o->image??''); $oSlug = is_array($o) ? ($o['slug']??'') : ($o->slug??''); ?>
        <div class="flex flex-col items-center gap-2">
          <div class="w-full aspect-square rounded-xl overflow-hidden border-4 border-red-600 shadow-md">
            <?php if ($oImg): ?>
            <img src="<?= uploadUrl($oImg, 'outlets') ?>" alt="<?= e($oName) ?>" class="w-full h-full object-cover" loading="lazy">
            <?php else: ?>
            <div class="w-full h-full bg-gradient-to-br from-red-50 to-slate-100 flex items-center justify-center font-bold text-slate-300"><?= e(substr($oName,0,2)) ?></div>
            <?php endif; ?>
          </div>
          <span class="text-sm font-bold text-slate-800"><?= e($oName) ?></span>
          <a href="<?= url('outlets/' . e($oSlug)) ?>" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-4 py-2 rounded transition-colors w-full max-w-[160px] text-center block">View Details &rarr;</a>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <?php for($i=0;$i<5;$i++): ?>
        <div class="flex flex-col items-center gap-2">
          <div class="w-full aspect-square rounded-xl overflow-hidden border-4 border-red-600 shadow-md bg-gradient-to-br from-red-50 to-slate-100 flex items-center justify-center font-bold text-slate-300">Outlet</div>
          <span class="text-sm font-bold text-slate-800">Our Store</span>
          <a href="<?= url('contact') ?>" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-4 py-2 rounded transition-colors w-full max-w-[160px]">Get Direction &rarr;</a>
        </div>
        <?php endfor; ?>
        <?php endif; ?>
      </div>
    </section>


  </main>
</div>
<script>
/* Recent Products slider */
(function(){var t=document.getElementById('recent-track'),v=document.getElementById('recent-viewport'),dc=document.getElementById('recent-dots');if(!t||!v||!dc)return;var c=0,ch=t.children,ni=ch.length;if(!ni)return;
function gpp(){return window.innerWidth<768?2:window.innerWidth<1024?3:6;}
function upd(){var p=gpp(),tp=Math.ceil(ni/p);if(c>=tp)c=tp-1;if(c<0)c=0;dc.innerHTML='';for(var i=0;i<tp;i++){var d=document.createElement('button');d.className='w-2.5 h-2.5 rounded-full '+(i===c?'bg-slate-400':'bg-slate-300');d.onclick=function(p){return function(){go(p);};}(i);dc.appendChild(d);}
var sw=v.offsetWidth;t.style.transform='translateX(-'+(c*sw)+'px)';}
function go(p){c=p;upd();}
window.recentScroll=function(d){go(c+d);};
upd();window.addEventListener('resize',upd);})();

/* Hero right carousel */
var hrIdx=0,hrTrack=document.getElementById('heroRightTrack');
if(hrTrack){var hrSlides=hrTrack.children;
function heroRightSlide(d){if(!hrSlides.length)return;hrIdx=(hrIdx+d+hrSlides.length)%hrSlides.length;hrTrack.style.transform='translateX(-'+(hrIdx*100)+'%)';}
setInterval(function(){heroRightSlide(1);},4000);}

/* Subcategory scroll drag */
(function(){var el=document.getElementById('subcatScrollHome');if(!el)return;var down=false,startX=0,scrollLeft=0,moved=false;el.addEventListener('mousedown',function(e){down=true;moved=false;startX=e.pageX;scrollLeft=el.scrollLeft;el.style.cursor='grabbing';});window.addEventListener('mousemove',function(e){if(!down)return;e.preventDefault();var walk=e.pageX-startX;if(Math.abs(walk)>5)moved=true;el.scrollLeft=scrollLeft-walk;});window.addEventListener('mouseup',function(){down=false;if(el)el.style.cursor='grab';});window.addEventListener('mouseleave',function(){down=false;});el.addEventListener('click',function(e){if(moved){e.stopPropagation();e.preventDefault();}},true);})();
</script>
