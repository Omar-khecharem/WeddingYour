<?php
$product = $product ?? [];
$images = $product['images'] ?? [];
$reviews = $reviews ?? [];
$ratingStats = $ratingStats ?? [];
$relatedProducts = $relatedProducts ?? [];
$primaryImage = null;
foreach ($images as $img) { if (!empty($img['is_primary'])) { $primaryImage = $img; break; } }
if (!$primaryImage && !empty($images[0])) { $primaryImage = $images[0]; }
$catName = $product['category_name'] ?? '';
$subName = $product['subcategory_name'] ?? '';
?>
<div class="bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
    <!-- Breadcrumb -->
    <nav class="flex items-center text-xs sm:text-sm text-gray-500 mb-4 space-x-2">
      <a href="<?= url('') ?>" class="hover:text-red-600">Home</a>
      <span>/</span>
      <a href="<?= url('products?category=' . urlencode($catName)) ?>" class="hover:text-red-600"><?= e($catName) ?: 'Products' ?></a>
      <?php if ($subName): ?><span>/</span><a href="<?= url('products?subcategory=' . urlencode($subName)) ?>" class="hover:text-red-600"><?= e($subName) ?></a><?php endif; ?>
      <span>/</span>
      <span class="text-gray-800 font-medium"><?= e($product['name']) ?></span>
    </nav>

    <!-- Back link -->
    <a href="<?= url('products') ?>" class="inline-flex items-center text-sm text-gray-500 hover:text-red-600 mb-6">&larr; Back to products</a>

    <!-- ==================== MAIN GRID ==================== -->
    <div class="lg:grid lg:grid-cols-12 lg:gap-8 xl:gap-12">

      <!-- LEFT: Thumbnails (vertical strip) -->
      <div class="hidden lg:flex lg:flex-col lg:col-span-1 space-y-2 order-1">
        <?php if (!empty($images)): ?>
        <?php foreach ($images as $i => $img): ?>
        <button class="thumbnail-btn w-full aspect-square rounded-lg overflow-hidden border-2 <?= ($i === 0) ? 'border-red-500' : 'border-gray-200' ?> hover:border-red-300 transition-colors"
                data-img="<?= uploadUrl($img['image']) ?>">
          <img src="<?= uploadUrl($img['image']) ?>" alt="" class="w-full h-full object-cover">
        </button>
        <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- CENTER: Main Image -->
      <div class="lg:col-span-6 order-2 mt-4 lg:mt-0">
        <div class="relative bg-gray-50 rounded-xl overflow-hidden border border-gray-200">
          <?php if (!empty($product['discount_percent'])): ?>
          <span class="absolute top-3 left-3 bg-red-600 text-white text-xs font-black px-2.5 py-1 rounded-md z-10">-<?= (int)$product['discount_percent'] ?>%</span>
          <?php endif; ?>
          <img id="mainProductImage"
               src="<?= $primaryImage ? uploadUrl($primaryImage['image']) : 'https://placehold.co/600x600?text=No+Image' ?>"
               alt="<?= e($product['name']) ?>"
               class="w-full h-full object-contain" style="aspect-ratio:1/1; max-height:600px">
        </div>
        <!-- Mobile thumbnails (horizontal) -->
        <?php if (count($images) > 1): ?>
        <div class="flex lg:hidden gap-2 mt-3 overflow-x-auto pb-2">
          <?php foreach ($images as $i => $img): ?>
          <button class="thumbnail-btn shrink-0 w-16 h-16 rounded-lg overflow-hidden border-2 <?= ($i === 0) ? 'border-red-500' : 'border-gray-200' ?>"
                  data-img="<?= uploadUrl($img['image']) ?>">
            <img src="<?= uploadUrl($img['image']) ?>" alt="" class="w-full h-full object-cover">
          </button>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <!-- RIGHT: Product Info -->
      <div class="lg:col-span-5 order-3 mt-6 lg:mt-0 space-y-5">

        <div>
          <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900"><?= e($product['name']) ?></h1>
          <?php if ($catName): ?>
          <p class="text-sm text-gray-500 mt-1"><?= e($catName) ?><?= $subName ? ' / ' . e($subName) : '' ?></p>
          <?php endif; ?>
        </div>

        <!-- Rating -->
        <?php if (!empty($ratingStats)): ?>
        <div class="flex items-center gap-2">
          <div class="flex">
            <?php $avg = round($ratingStats['average'] ?? 0); for ($s = 1; $s <= 5; $s++): ?>
            <svg class="w-4 h-4 <?= $s <= $avg ? 'text-yellow-400' : 'text-gray-300' ?>" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            <?php endfor; ?>
          </div>
          <span class="text-sm text-gray-500"><?= number_format($ratingStats['average'] ?? 0, 1) ?> (<?= (int)($ratingStats['total'] ?? 0) ?> reviews)</span>
        </div>
        <?php endif; ?>

        <!-- Price -->
        <div class="flex items-baseline gap-3">
          <?php if (!empty($product['sale_price']) && $product['sale_price'] < $product['regular_price']): ?>
          <span class="text-3xl font-black text-red-600"><?= formatPrice($product['sale_price']) ?></span>
          <span class="text-xl text-gray-400 line-through"><?= formatPrice($product['regular_price']) ?></span>
          <?php if (!empty($product['discount_percent'])): ?>
          <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-700"><?= (int)$product['discount_percent'] ?>% OFF</span>
          <?php endif; ?>
          <?php else: ?>
          <span class="text-3xl font-black text-gray-900"><?= formatPrice($product['regular_price']) ?></span>
          <?php endif; ?>
        </div>

        <!-- Stock -->
        <div class="flex items-center gap-2 text-sm">
          <?php if ($product['stock_status'] === 'in_stock'): ?>
          <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
          <span class="text-green-700 font-medium"><?= (int)$product['stock_quantity'] ?> in stock</span>
          <?php elseif ($product['stock_status'] === 'out_of_stock'): ?>
          <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
          <span class="text-red-600 font-medium">Out of stock</span>
          <?php else: ?>
          <span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span>
          <span class="text-yellow-700 font-medium">On backorder</span>
          <?php endif; ?>
        </div>

        <!-- Specifications Table -->
        <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
          <tbody class="divide-y divide-gray-200">
            <?php $specs = []; if ($product['sku'] ?? null) $specs[] = ['SKU', e($product['sku'])]; if ($catName) $specs[] = ['Category', e($catName)]; if ($subName) $specs[] = ['Subcategory', e($subName)]; if ($product['weight'] ?? null) $specs[] = ['Weight', e($product['weight'])]; if ($product['stock_quantity'] ?? null) $specs[] = ['In Box', e($product['stock_quantity'])]; ?>
            <?php foreach ($specs as $i => $spec): ?>
            <tr class="<?= $i % 2 === 0 ? 'bg-gray-50' : 'bg-white' ?>">
              <td class="px-4 py-2.5 font-medium text-gray-700 w-1/3"><?= $spec[0] ?></td>
              <td class="px-4 py-2.5 text-gray-600"><?= $spec[1] ?></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($specs)): ?>
            <tr><td class="px-4 py-3 text-gray-400 text-center" colspan="2">No specifications available</td></tr>
            <?php endif; ?>
          </tbody>
        </table>

        <!-- Quantity + Add to Cart -->
        <div class="flex flex-col sm:flex-row gap-3">
          <div class="flex items-center border border-gray-300 rounded-lg">
            <button type="button" id="qtyMinus" class="px-3 py-2.5 text-gray-500 hover:text-gray-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg></button>
            <input type="number" id="qtyInput" value="1" min="1" max="999" class="w-14 text-center border-0 focus:ring-0 text-gray-900 font-medium text-sm">
            <button type="button" id="qtyPlus" class="px-3 py-2.5 text-gray-500 hover:text-gray-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg></button>
          </div>
          <button onclick="addToCart(<?= $product['id'] ?>, parseInt(document.getElementById('qtyInput').value))"
                  class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold text-sm px-6 py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2" <?= $product['stock_status'] !== 'in_stock' ? 'disabled' : '' ?>>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg> Add to cart
          </button>
        </div>

        <button onclick="buyNow(<?= $product['id'] ?>)" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm px-6 py-2.5 rounded-lg transition-colors" <?= $product['stock_status'] !== 'in_stock' ? 'disabled' : '' ?>>Buy now</button>

        <!-- Pincode Checker -->
        <div class="border border-gray-200 rounded-lg p-4 space-y-2">
          <label class="text-sm font-medium text-gray-700">Check Availability At</label>
          <div class="flex gap-2">
            <input type="text" id="pincodeInput" placeholder="Enter Delivery Pincode" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-200 focus:border-red-400 outline-none">
            <button onclick="checkPincode()" class="bg-gray-800 hover:bg-gray-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">Check</button>
          </div>
          <p id="pincodeMsg" class="text-xs text-gray-500 hidden"></p>
        </div>

        <!-- Action links -->
        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
          <button onclick="addToCompare(<?= $product['id'] ?>)" class="hover:text-red-600 flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg> Add to compare</button>
          <button onclick="addToWishlist(<?= $product['id'] ?>)" class="hover:text-red-600 flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg> Add to wishlist</button>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg> Share</span>
        </div>

        <!-- People watching -->
        <div class="bg-green-50 border border-green-200 rounded-lg px-4 py-2.5 flex items-center gap-2 text-sm text-green-800">
          <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
          <span class="font-medium"><span id="watcherCount">15</span> People watching this product now!</span>
        </div>

      </div>
    </div>

    <!-- ==================== TABS ==================== -->
    <div class="mt-12 border-t border-gray-200">
      <nav class="flex gap-6 -mb-px">
        <button class="tab-btn text-red-600 border-red-600 border-b-2 py-4 text-sm font-bold" data-tab="description">Description</button>
        <button class="tab-btn text-gray-500 border-transparent border-b-2 py-4 text-sm font-medium hover:text-gray-700" data-tab="specification">Specification</button>
        <button class="tab-btn text-gray-500 border-transparent border-b-2 py-4 text-sm font-medium hover:text-gray-700" data-tab="reviews">Customer Reviews (<?= (int)($ratingStats['total'] ?? 0) ?>)</button>
      </nav>

      <!-- Description Tab -->
      <div id="tab-description" class="tab-content py-6">
        <div class="prose max-w-none text-gray-700 text-sm leading-relaxed">
          <?= $product['description'] ? nl2br(e($product['description'])) : '<p class="text-gray-400">No description available.</p>' ?>
        </div>
        <?php if ($product['meta_keywords'] ?? null): ?>
        <div class="mt-6 flex flex-wrap gap-2">
          <?php foreach (explode(',', $product['meta_keywords']) as $kw): $kw = trim($kw); if ($kw): ?>
          <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full"><?= e($kw) ?></span>
          <?php endif; endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <!-- Specification Tab -->
      <div id="tab-specification" class="tab-content hidden py-6">
        <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
          <tbody class="divide-y divide-gray-200">
            <?php $allSpecs = array_merge($specs, []); if (!empty($allSpecs)): ?>
            <?php foreach ($allSpecs as $i => $s): ?>
            <tr class="<?= $i % 2 === 0 ? 'bg-gray-50' : 'bg-white' ?>">
              <td class="px-4 py-2.5 font-medium text-gray-700 w-1/3"><?= $s[0] ?></td>
              <td class="px-4 py-2.5 text-gray-600"><?= $s[1] ?></td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr><td class="px-4 py-6 text-gray-400 text-center" colspan="2">General product specification details would be shown here.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Reviews Tab -->
      <div id="tab-reviews" class="tab-content hidden py-6">
        <?php if (!empty($ratingStats)): ?>
        <div class="bg-gray-50 rounded-xl p-6 mb-8">
          <div class="sm:flex sm:items-center sm:gap-8">
            <div class="text-center sm:text-left sm:shrink-0">
              <p class="text-4xl font-black text-gray-900"><?= number_format($ratingStats['average'] ?? 0, 1) ?></p>
              <div class="flex items-center justify-center sm:justify-start mt-1">
                <?php $a = round($ratingStats['average'] ?? 0); for ($s = 1; $s <= 5; $s++): ?>
                <svg class="w-4 h-4 <?= $s <= $a ? 'text-yellow-400' : 'text-gray-300' ?>" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <?php endfor; ?>
              </div>
              <p class="text-sm text-gray-500 mt-1">Based on <?= (int)($ratingStats['total'] ?? 0) ?> reviews</p>
            </div>
            <?php if (!empty($ratingStats['distribution'])): ?>
            <div class="flex-1 mt-4 sm:mt-0 space-y-1.5">
              <?php for ($star = 5; $star >= 1; $star--): ?>
              <?php $cnt = $ratingStats['distribution'][$star] ?? 0; $total = $ratingStats['total'] ?? 1; $pct = $total > 0 ? round(($cnt / $total) * 100) : 0; ?>
              <div class="flex items-center text-sm gap-2">
                <span class="w-10 text-right text-gray-600"><?= $star ?></span>
                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden"><div class="h-full bg-yellow-400 rounded-full" style="width:<?= $pct ?>%"></div></div>
                <span class="w-6 text-gray-500"><?= $cnt ?></span>
              </div>
              <?php endfor; ?>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($reviews)): ?>
        <div class="space-y-6">
          <?php foreach ($reviews as $review): ?>
          <div class="border-b border-gray-200 pb-6">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-sm font-bold text-red-600"><?= strtoupper(substr($review['name'] ?? 'A', 0, 1)) ?></div>
                <div>
                  <p class="text-sm font-semibold text-gray-900"><?= e($review['name'] ?? 'Anonymous') ?></p>
                  <div class="flex items-center gap-1">
                    <?php for ($s = 1; $s <= 5; $s++): ?>
                    <svg class="w-3.5 h-3.5 <?= $s <= ($review['rating'] ?? 5) ? 'text-yellow-400' : 'text-gray-300' ?>" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <?php endfor; ?>
                  </div>
                </div>
              </div>
              <time class="text-xs text-gray-400"><?= date('d M Y', strtotime($review['created_at'] ?? 'now')) ?></time>
            </div>
            <p class="mt-2 text-sm text-gray-700"><?= nl2br(e($review['comment'] ?? '')) ?></p>
          </div>
          <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-8 text-gray-400">
          <p class="font-medium">There are no reviews yet.</p>
          <p class="text-sm mt-1">Be the first to review "<?= e($product['name']) ?>"</p>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- ==================== RELATED PRODUCTS ==================== -->
    <?php if (!empty($relatedProducts)): ?>
    <div class="mt-12">
      <h2 class="text-xl font-black text-gray-800 mb-6">Related Products</h2>
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
        <?php foreach ($relatedProducts as $p): ?>
        <?php $pImg = $p['image'] ?? ''; $pName = $p['name'] ?? ''; $pSlug = $p['slug'] ?? '#'; $pReg = $p['regular_price'] ?? 0; $pSale = $p['sale_price'] ?? null; $pDisc = $p['discount_percent'] ?? 0; $pId = $p['id'] ?? 0; ?>
        <div class="group bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
          <a href="<?= url('product/' . e($pSlug)) ?>" class="block aspect-square bg-gray-50 relative overflow-hidden">
            <?php if ($pDisc): ?><span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-black px-2 py-0.5 rounded-md z-10">-<?= (int)$pDisc ?>%</span><?php endif; ?>
            <img src="<?= e($pImg ?: 'https://placehold.co/300x300?text=No+Image') ?>" alt="<?= e($pName) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
          </a>
          <div class="p-3 space-y-1">
            <a href="<?= url('product/' . e($pSlug)) ?>" class="text-xs font-bold text-gray-800 uppercase tracking-wide block truncate"><?= e($pName) ?></a>
            <div class="flex items-center gap-2">
              <?php if ($pSale && $pSale < $pReg): ?><span class="text-sm font-black text-red-600"><?= formatPrice($pSale) ?></span><span class="text-xs text-gray-400 line-through"><?= formatPrice($pReg) ?></span>
              <?php else: ?><span class="text-sm font-black text-gray-800"><?= formatPrice($pReg) ?></span><?php endif; ?>
            </div>
            <button onclick="addToCart(<?= $pId ?>, 1)" class="w-full bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-1.5 rounded transition-colors">Add to cart</button>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- Recently Viewed -->
    <div class="mt-8 text-center">
      <a href="<?= url('products') ?>" class="inline-block bg-gray-800 hover:bg-gray-700 text-white font-bold text-sm px-8 py-3 rounded-full transition-colors">Load more products</a>
    </div>

  </div>
</div>

<script>
(function(){
  // Thumbnail switching
  const mainImg = document.getElementById('mainProductImage');
  document.querySelectorAll('.thumbnail-btn').forEach(btn => {
    btn.addEventListener('click', function(){
      document.querySelectorAll('.thumbnail-btn').forEach(b => b.classList.replace('border-red-500','border-gray-200'));
      this.classList.replace('border-gray-200','border-red-500');
      mainImg.src = this.dataset.img;
    });
  });

  // Quantity
  const qty = document.getElementById('qtyInput');
  document.getElementById('qtyMinus')?.addEventListener('click', function(){ const v = parseInt(qty.value)||1; if(v>1) qty.value = v-1; });
  document.getElementById('qtyPlus')?.addEventListener('click', function(){ const v = parseInt(qty.value)||1; if(v<999) qty.value = v+1; });

  // Tabs
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function(){
      document.querySelectorAll('.tab-btn').forEach(b => { b.classList.replace('text-red-600','text-gray-500'); b.classList.replace('border-red-600','border-transparent'); b.classList.remove('font-bold'); b.classList.add('font-medium'); });
      this.classList.replace('text-gray-500','text-red-600'); this.classList.replace('border-transparent','border-red-600'); this.classList.remove('font-medium'); this.classList.add('font-bold');
      document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
      document.getElementById('tab-' + this.dataset.tab)?.classList.remove('hidden');
    });
  });

  // People watching randomizer
  setInterval(function(){
    var el = document.getElementById('watcherCount');
    if(el) el.textContent = Math.floor(Math.random() * 10) + 12;
  }, 8000);
})();

function buyNow(id){
  addToCart(id, parseInt(document.getElementById('qtyInput').value));
  setTimeout(function(){ window.location.href='<?= url('checkout') ?>'; }, 500);
}
function checkPincode(){
  var input = document.getElementById('pincodeInput'), msg = document.getElementById('pincodeMsg');
  var pincode = input.value.trim();
  if(!pincode){ msg.textContent='Please enter a pincode.'; msg.classList.remove('hidden','text-green-600'); msg.classList.add('text-red-600'); return; }
  msg.textContent='Checking...'; msg.classList.remove('hidden','text-red-600','text-green-600'); msg.classList.add('text-gray-500');
  fetch('<?= url('api/check-pincode') ?>?product_id=<?= $product['id'] ?>&pincode='+encodeURIComponent(pincode))
    .then(function(r){ return r.json(); })
    .then(function(d){
      msg.textContent=d.message;
      msg.classList.remove('hidden','text-gray-500');
      msg.classList.add(d.available ? 'text-green-600' : 'text-red-600');
    })
    .catch(function(){
      msg.textContent='Error checking availability. Try again.';
      msg.classList.remove('hidden','text-gray-500','text-green-600');
      msg.classList.add('text-red-600');
    });
}
</script>