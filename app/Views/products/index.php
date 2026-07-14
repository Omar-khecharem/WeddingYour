<?php
$products = $products ?? [];
$productList = $products['products'] ?? [];
$total = $products['total'] ?? 0;
$page = $products['page'] ?? 1;
$perPage = $products['perPage'] ?? 12;
$totalPages = $products['totalPages'] ?? 1;

$filterOptions = $filterOptions ?? [];
$categories = $categories ?? $filterOptions['categories'] ?? [];
$brands = $filterOptions['brands'] ?? [];
$priceRange = $filterOptions['priceRange'] ?? ['min_price' => 0, 'max_price' => 99999];

$filters = $filters ?? [];
$currentCategory = $currentCategory ?? null;
$searchQuery = $searchQuery ?? '';
$sortBy = $sortBy ?? 'newest';

$start = $total > 0 ? (($page - 1) * $perPage) + 1 : 0;
$end = min($page * $perPage, $total);

?>

<!-- Breadcrumb -->
<div class="bg-slate-50 border-b border-slate-200">
  <div class="max-w-[1400px] mx-auto px-4 py-3 flex items-center gap-2 text-xs font-medium text-slate-500">
    <a href="<?= url('') ?>" class="hover:text-red-600 transition-colors">Home</a>
    <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-800 font-semibold"><?= $currentCategory ? e($currentCategory) : 'All Products' ?></span>
  </div>
</div>

<?php $catList = $categories;
$chunks = array_chunk($catList, 8); ?>
<?php if (!empty($chunks)): ?>
<!-- CATEGORIES STEP CAROUSEL (8 per slide) -->
<section class="bg-white border-b border-slate-200 overflow-hidden">
  <div class="max-w-[1400px] mx-auto px-4 py-5">
    <h2 class="text-lg font-black text-slate-800 tracking-tight mb-4">Catégories</h2>
    <div class="relative overflow-hidden">
      <div id="catTrackProd" class="flex transition-transform duration-500 ease-in-out" style="width:<?= count($chunks) * 100 ?>%">
        <?php foreach ($chunks as $chunk): ?>
        <div class="flex gap-5 px-2" style="width:<?= 100 / count($chunks) ?>%">
          <?php foreach ($chunk as $cat): ?>
          <?php $catSlug = is_array($cat) ? $cat['slug'] : $cat; ?>
          <?php $catName = is_array($cat) ? $cat['name'] : $cat; ?>
          <?php $catImg = is_array($cat) ? ($cat['image'] ?? 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=200') : 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=200'; ?>
          <a href="<?= url('category/' . e($catSlug)) ?>" class="flex flex-col items-center text-center space-y-2 w-[130px] shrink-0 group">
            <div class="w-full aspect-square rounded-2xl overflow-hidden border-2 border-slate-100 group-hover:border-red-600 group-hover:scale-105 transition-all duration-300 shadow-sm group-hover:shadow-md">
              <img src="<?= e($catImg) ?>" alt="<?= e($catName) ?>" class="w-full h-full object-cover" loading="lazy">
            </div>
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-700 group-hover:text-red-600 transition-colors"><?= e($catName) ?></span>
          </a>
          <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<div class="max-w-[1400px] mx-auto px-4 py-6">
  <div class="flex gap-8">

    <!-- ============ SIDEBAR FILTERS ============ -->
    <aside id="filter-sidebar" class="w-[280px] shrink-0 hidden lg:block">
      <form method="GET" action="<?= url('products') ?>" id="filter-form">

        <!-- Price filter - range slider -->
        <div class="mb-6">
          <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-3">Filter by price</h3>
          <?php $minP = (int)($priceRange['min_price'] ?? 0); $maxP = (int)($priceRange['max_price'] ?? 5000); ?>
          <?php $curMin = (int)($filters['min_price'] ?? $minP); $curMax = (int)($filters['max_price'] ?? $maxP); ?>
          <input type="hidden" name="min_price" id="priceMin" value="<?= $curMin ?>">
          <input type="hidden" name="max_price" id="priceMax" value="<?= $curMax ?>">
          <div class="relative h-2 bg-slate-200 rounded-full mt-6 mb-4">
            <div id="priceTrack" class="absolute h-full bg-red-500 rounded-full" style="left:<?= max(0,($curMin-$minP)/($maxP-$minP?:1)*100) ?>%;width:<?= max(1,($curMax-$curMin)/($maxP-$minP?:1)*100) ?>%"></div>
            <input type="range" id="rangeMin" min="<?= $minP ?>" max="<?= $maxP ?>" value="<?= $curMin ?>" step="10" class="absolute inset-0 w-full h-full appearance-none bg-transparent pointer-events-none z-10 [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:bg-red-600 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:cursor-grab [&::-webkit-slider-thumb]:shadow-md [&::-moz-range-thumb]:pointer-events-auto [&::-moz-range-thumb]:appearance-none [&::-moz-range-thumb]:w-4 [&::-moz-range-thumb]:h-4 [&::-moz-range-thumb]:bg-red-600 [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:cursor-grab [&::-moz-range-thumb]:shadow-md">
            <input type="range" id="rangeMax" min="<?= $minP ?>" max="<?= $maxP ?>" value="<?= $curMax ?>" step="10" class="absolute inset-0 w-full h-full appearance-none bg-transparent pointer-events-none z-10 [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:bg-red-600 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:cursor-grab [&::-webkit-slider-thumb]:shadow-md [&::-moz-range-thumb]:pointer-events-auto [&::-moz-range-thumb]:appearance-none [&::-moz-range-thumb]:w-4 [&::-moz-range-thumb]:h-4 [&::-moz-range-thumb]:bg-red-600 [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:cursor-grab [&::-moz-range-thumb]:shadow-md">
          </div>
          <div class="flex items-center justify-between text-xs text-slate-500 mb-4">
            <span id="priceLabelMin">₹<?= number_format($curMin) ?></span>
            <span id="priceLabelMax">₹<?= number_format($curMax) ?></span>
          </div>
          <button type="submit" class="w-full text-xs font-bold text-white bg-red-600 hover:bg-red-700 rounded-lg py-2 transition-colors">Filter</button>
        </div>

        <!-- Categories - navbar style -->
        <div class="mb-6">
          <h3 class="text-sm font-bold text-emerald-600 uppercase tracking-wider mb-3">CATEGORIES</h3>
          <ul class="space-y-1">
            <?php $menuCats = [
              'bride-mukut' => ['label' => 'BRIDE', 'sub' => [
                ['label' => 'Bridal Patashi / Mukut', 'slug' => 'bridal-patashi'],
                ['label' => 'Bridal Sithi / Small Mukut', 'slug' => 'bridal-sithi'],
                ['label' => 'Crown & 3 Pieces Set', 'slug' => 'crown'],
                ['label' => 'Boron / Khoidan Kulo', 'slug' => 'boron'],
                ['label' => 'Gach kouto', 'slug' => 'gachhkouto-dorpon'],
                ['label' => 'Panpata', 'slug' => 'panpata'],
                ['label' => 'Piri', 'slug' => 'piri'],
              ]],
              'groom-topor' => ['label' => 'GROOM', 'sub' => [
                ['label' => 'Traditional Topor', 'slug' => 'topor-simple'],
                ['label' => 'Royal Topor Set', 'slug' => 'topor-royal'],
              ]],
              'baby-mukut' => ['label' => 'BABY', 'sub' => [
                ['label' => 'Baby Topor (Boy)', 'slug' => 'baby-topor-boy'],
                ['label' => 'Baby Mukut (Girl)', 'slug' => 'baby-mukut-girl'],
              ]],
              'wedding-items' => ['label' => 'WEDDING ITEMS', 'sub' => []],
              'exclusive-collection' => ['label' => "SHOLA'S JEWELLERY", 'sub' => []],
            ]; ?>
            <?php foreach ($menuCats as $slug => $mc): $active = ($filters['category'] ?? '') === $slug; ?>
            <li class="relative group">
              <a href="<?= url('products?' . http_build_query(array_merge($_GET, ['category' => $active ? '' : $slug, 'page' => '']))) ?>" class="flex items-center justify-between text-sm py-2 px-3 rounded transition-colors <?= $active ? 'text-red-600 font-bold bg-red-50' : 'text-slate-600 hover:text-red-600 hover:bg-slate-50' ?>">
                <span><?= $mc['label'] ?></span>
                <?php if (!empty($mc['sub'])): ?>
                <svg class="w-3 h-3 text-slate-400 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <?php endif; ?>
              </a>
              <?php if (!empty($mc['sub'])): ?>
              <div class="absolute left-full top-0 w-48 bg-white border border-slate-200 rounded-xl shadow-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-20 ml-2">
                <ul>
                  <?php foreach ($mc['sub'] as $sub): $subActive = ($filters['subcategory'] ?? '') === $sub['slug']; ?>
                  <li><a href="<?= url('products?' . http_build_query(array_merge($_GET, ['category' => $slug, 'subcategory' => $subActive ? '' : $sub['slug'], 'page' => '']))) ?>" class="block px-4 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-red-600 transition-colors <?= $subActive ? 'text-red-600 font-bold bg-red-50' : '' ?>"><?= $sub['label'] ?></a></li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <?php endif; ?>
            </li>
            <?php endforeach; ?>
            <li class="border-t border-slate-100 pt-1 mt-1">
              <a href="<?= url('products?sort=popular') ?>" class="block text-sm py-2 px-3 text-slate-600 hover:text-red-600 hover:bg-slate-50 rounded transition-colors">Best Seller</a>
            </li>
            <li>
              <a href="<?= url('products?featured=1') ?>" class="block text-sm py-2 px-3 text-slate-600 hover:text-red-600 hover:bg-slate-50 rounded transition-colors">Exclusive</a>
            </li>
          </ul>
        </div>

      </form>
    </aside>

    <!-- ============ MAIN CONTENT ============ -->
    <div class="flex-1 min-w-0">

      <!-- Results bar -->
      <div class="flex flex-wrap items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-200">
        <p class="text-sm text-slate-500">
          Showing <?= $start ?>–<?= $end ?> of <?= $total ?> results
        </p>
        <div class="flex items-center gap-3">
          <!-- Per page -->
          <div class="flex items-center gap-1.5">
            <span class="text-xs text-slate-500">Show</span>
            <select name="per_page" onchange="var p=new URLSearchParams(location.search);p.set('per_page',this.value);p.delete('page');location.search=p.toString()" class="text-xs border border-slate-200 rounded px-2 py-1.5 bg-white">
              <?php foreach ([9,12,18,24] as $pp): ?>
              <option value="<?= $pp ?>" <?= $perPage == $pp ? 'selected' : '' ?>><?= $pp ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <!-- Sort -->
          <select name="sort" onchange="var p=new URLSearchParams(location.search);p.set('sort',this.value);p.delete('page');location.search=p.toString()" class="text-xs border border-slate-200 rounded px-2 py-1.5 bg-white">
            <option value="newest" <?= $sortBy === 'newest' ? 'selected' : '' ?>>Default sorting</option>
            <option value="price_asc" <?= $sortBy === 'price_asc' ? 'selected' : '' ?>>Price low to high</option>
            <option value="price_desc" <?= $sortBy === 'price_desc' ? 'selected' : '' ?>>Price high to low</option>
            <option value="name" <?= $sortBy === 'name' ? 'selected' : '' ?>>Name</option>
            <option value="popular" <?= $sortBy === 'popular' ? 'selected' : '' ?>>Popular</option>
            <option value="discount" <?= $sortBy === 'discount' ? 'selected' : '' ?>>Discount</option>
          </select>
        </div>
      </div>

      <!-- Products grid -->
      <?php if (!empty($productList)): ?>
      <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4" id="product-grid">
        <?php foreach ($productList as $product):
          $pName = $product['name'] ?? '';
          $pSlug = $product['slug'] ?? '';
          $pImg = $product['image'] ?? $product['images'][0] ?? 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=300';
          $pCategory = $product['category_name'] ?? $product['category'] ?? 'BRIDE';
          $pSubcategory = $product['subcategory_name'] ?? $product['subcategory'] ?? 'Bridal Patashi / Mukut';
          $pTags = $product['tags'] ?? ($product['tag'] ?? '');
          $pRegular = $product['regular_price'] ?? $product['price'] ?? 0;
          $pSale = $product['sale_price'] ?? $pRegular;
          $pDiscount = $product['discount_percent'] ?? ($pRegular > 0 ? round((1 - $pSale / $pRegular) * 100) : 0);
          $pStock = $product['stock_status'] ?? 'in_stock';
          $pId = $product['id'] ?? 0;
        ?>
        <div class="bg-white border border-slate-100 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow flex flex-col group/card">
          <div class="relative overflow-hidden bg-slate-50">
            <?php if ($pDiscount > 0): ?>
            <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-black px-2 py-0.5 rounded-md z-10">-<?= $pDiscount ?>%</span>
            <?php endif; ?>
            <a href="<?= url('products/' . e($pSlug)) ?>" class="block aspect-square">
              <img src="<?= e($pImg) ?>" alt="<?= e($pName) ?>" class="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-500" loading="lazy">
            </a>
            <!-- Hover overlay buttons -->
            <div class="absolute bottom-0 left-0 right-0 flex items-center justify-center gap-1.5 p-2 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity duration-300">
              <button class="w-7 h-7 bg-white rounded-full flex items-center justify-center text-slate-600 hover:bg-red-600 hover:text-white transition-colors shadow" title="Cart">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
              </button>
              <button class="w-7 h-7 bg-white rounded-full flex items-center justify-center text-slate-600 hover:bg-red-600 hover:text-white transition-colors shadow hidden sm:flex" title="Quick view">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              </button>
              <button class="w-7 h-7 bg-white rounded-full flex items-center justify-center text-slate-600 hover:bg-red-600 hover:text-white transition-colors shadow hidden sm:flex" title="Compare">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
              </button>
              <button class="w-7 h-7 bg-white rounded-full flex items-center justify-center text-slate-600 hover:bg-red-600 hover:text-white transition-colors shadow" title="Wishlist">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
              </button>
            </div>
          </div>
          <div class="p-3 flex flex-col gap-1.5 flex-1">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wide leading-tight"><?= e($pName) ?></h3>
            <p class="text-[10px] text-slate-400 font-medium flex flex-wrap gap-x-1">
              <span><?= e($pCategory) ?></span><span class="text-slate-200">,</span>
              <span><?= e($pSubcategory) ?></span>
              <?php if ($pTags): ?><span class="text-slate-200">,</span><span><?= e(is_array($pTags) ? implode(', ', $pTags) : $pTags) ?></span><?php endif; ?>
            </p>
            <span class="text-[10px] text-emerald-600 font-bold flex items-center gap-1">
              <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> In stock
            </span>
            <div class="flex items-center gap-2 mt-auto">
              <span class="text-sm font-black text-red-600">₹<?= number_format($pSale, 2) ?></span>
              <?php if ($pDiscount > 0): ?>
              <span class="text-[10px] text-slate-300 line-through">₹<?= number_format($pRegular, 2) ?></span>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- Load More -->
      <?php if ($page < $totalPages): ?>
      <div class="text-center mt-8">
        <a href="<?= url('products?' . http_build_query(array_merge($_GET, ['page' => $page + 1]))) ?>" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold text-sm px-8 py-3 rounded-full transition-colors shadow-md">
          Load more products
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </a>
      </div>
      <?php endif; ?>

      <?php else: ?>
      <div class="text-center py-20">
        <div class="text-5xl text-slate-200 mb-4">
          <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <h2 class="text-lg font-bold text-slate-600 mb-2">No products found</h2>
        <p class="text-sm text-slate-400 mb-6">Try adjusting your search or filter criteria.</p>
        <a href="<?= url('products') ?>" class="inline-block bg-red-600 hover:bg-red-700 text-white text-sm font-bold px-6 py-2.5 rounded-full transition-colors">View All Products</a>
      </div>
      <?php endif; ?>
    </div>

  </div>
</div>

<!-- Mobile filter button -->
<button id="mobile-filter-toggle" class="fixed bottom-20 right-4 z-40 lg:hidden w-12 h-12 bg-red-600 text-white rounded-full shadow-lg flex items-center justify-center">
  <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
</button>

<script>
(function(){
  var toggleBtn = document.getElementById('mobile-filter-toggle');
  var sidebar = document.getElementById('filter-sidebar');
  if (!toggleBtn || !sidebar) return;
  var overlay = document.createElement('div');
  overlay.className = 'fixed inset-0 bg-black/50 z-40 hidden';
  document.body.appendChild(overlay);
  function open() {
    sidebar.classList.remove('hidden');
    sidebar.classList.add('fixed', 'inset-0', 'z-50', 'p-6', 'bg-white', 'overflow-y-auto');
    overlay.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }
  function close() {
    sidebar.classList.add('hidden');
    sidebar.classList.remove('fixed', 'inset-0', 'z-50', 'p-6', 'bg-white', 'overflow-y-auto');
    overlay.classList.add('hidden');
    document.body.style.overflow = '';
  }
  toggleBtn.addEventListener('click', open);
  overlay.addEventListener('click', close);
  document.addEventListener('keydown', function(e) { if (e.key === 'Escape') close(); });
})();

/* Category step carousel (8 per slide) */
(function() {
  var track = document.getElementById('catTrackProd');
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

/* Price range slider sync */
(function() {
  var minR = document.getElementById('rangeMin');
  var maxR = document.getElementById('rangeMax');
  var minH = document.getElementById('priceMin');
  var maxH = document.getElementById('priceMax');
  var track = document.getElementById('priceTrack');
  var labelMin = document.getElementById('priceLabelMin');
  var labelMax = document.getElementById('priceLabelMax');
  if (!minR || !maxR || !minH || !maxH || !track || !labelMin || !labelMax) return;
  function update() {
    var v1 = parseInt(minR.value), v2 = parseInt(maxR.value);
    if (v1 > v2) { if (this === minR) { minR.value = v2; v1 = v2; } else { maxR.value = v1; v2 = v1; } }
    minH.value = v1; maxH.value = v2;
    var min = parseInt(minR.min), max = parseInt(minR.max), range = (max - min) || 1;
    var l = (v1 - min) / range * 100, w = (v2 - v1) / range * 100;
    track.style.left = l + '%'; track.style.width = w + '%';
    labelMin.textContent = '₹' + v1.toLocaleString('en-IN');
    labelMax.textContent = '₹' + v2.toLocaleString('en-IN');
  }
  minR.addEventListener('input', update);
  maxR.addEventListener('input', update);
  update();
})();
</script>