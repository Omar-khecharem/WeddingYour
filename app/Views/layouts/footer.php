<?php
$currentYear = $currentYear ?? date('Y');
$footerName = \App\Models\Setting::get('site_name', 'Shola Ghar');
$footerTagline = \App\Models\Setting::get('site_tagline', '');
$siteLogo = \App\Models\Setting::get('site_logo', '');
if (empty($siteLogo) && file_exists(PUBLIC_DIR . DS . 'uploads' . DS . 'site_logo.png')) $siteLogo = 'site_logo.png';
$isAdmin = \App\Helpers\Session::has('user') && (\App\Helpers\Session::get('user')['role'] ?? '') === 'admin';
?>
<!-- ============================================ -->
<!-- FOOTER - RED THEME -->
<!-- ============================================ -->
<footer class="bg-[#B10912] text-white border-t-4 border-white/20">
  <div class="max-w-[1400px] mx-auto px-4 py-10 space-y-8">

    <!-- Logo + Links Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

      <!-- Logo + Brand -->
      <div class="flex flex-col items-start gap-3">
        <a href="<?= url('') ?>" class="flex items-center gap-3 shrink-0">
          <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center border border-white/30 shadow-sm overflow-hidden">
            <?php if ($siteLogo): ?>
            <img src="<?= uploadUrl($siteLogo) ?>" alt="<?= e($footerName) ?>" class="w-full h-full object-contain">
            <?php else: ?>
            <span class="text-white font-black text-2xl tracking-tighter"><?= e(substr($footerName, 0, 2)) ?></span>
            <?php endif; ?>
          </div>
          <div class="flex flex-col justify-center">
            <span class="text-white font-black text-xl tracking-wide leading-none"><?= e($footerName) ?></span>
            <?php if ($footerTagline): ?>
            <span class="text-[10px] text-white/70 font-medium tracking-tight mt-0.5"><?= e($footerTagline) ?></span>
            <?php endif; ?>
          </div>
        </a>
        <p class="text-sm text-white/80 leading-relaxed">The one and only destination of the Bengali wedding Topor Mukut is <?= e($footerName) ?>. All the efficient Karigars of <?= e($footerName) ?> are constantly trying their best to make the best quality and the most...</p>
      </div>

      <!-- Important Links -->
      <div>
        <h4 class="text-sm font-bold text-white mb-4 uppercase tracking-wider">Important Links</h4>
        <ul class="space-y-2.5">
          <li><a href="#" class="text-xs text-white/70 hover:text-white transition-colors">My Orders</a></li>
          <li><a href="<?= url('contact') ?>" class="text-xs text-white/70 hover:text-white transition-colors">Contact Us</a></li>
          <li><a href="#" class="text-xs text-white/70 hover:text-white transition-colors">FAQs</a></li>
          <li><a href="<?= url('products') ?>" class="text-xs text-white/70 hover:text-white transition-colors">Shop</a></li>
          <?php if ($isAdmin): ?>
          <li><a href="<?= url('admin') ?>" class="text-xs text-white/70 hover:text-white transition-colors">Admin Dashboard</a></li>
          <?php else: ?>
          <li><a href="<?= url('account') ?>" class="text-xs text-white/70 hover:text-white transition-colors">My Profile</a></li>
          <?php endif; ?>
        </ul>
      </div>

      <?php if (!$isAdmin): ?>
      <!-- My Account -->
      <div>
        <h4 class="text-sm font-bold text-white mb-4 uppercase tracking-wider">My Account</h4>
        <ul class="space-y-2.5">
          <li><a href="<?= url('account') ?>" class="text-xs text-white/70 hover:text-white transition-colors">My Orders</a></li>
          <li><a href="<?= url('account/addresses') ?>" class="text-xs text-white/70 hover:text-white transition-colors">My Addresses</a></li>
          <li><a href="<?= url('account') ?>" class="text-xs text-white/70 hover:text-white transition-colors">Profile Setting</a></li>
          <li><a href="<?= url('account/wishlist') ?>" class="text-xs text-white/70 hover:text-white transition-colors">Wishlist</a></li>
        </ul>
      </div>
      <?php endif; ?>

      <!-- Quick Links -->
      <div>
        <h4 class="text-sm font-bold text-white mb-4 uppercase tracking-wider">Quick Links</h4>
        <ul class="space-y-2.5">
          <li><a href="<?= url('about') ?>" class="text-xs text-white/70 hover:text-white transition-colors">About Us</a></li>
          <li><a href="#" class="text-xs text-white/70 hover:text-white transition-colors">Privacy Policy</a></li>
          <li><a href="#" class="text-xs text-white/70 hover:text-white transition-colors">Terms of use</a></li>
        </ul>
      </div>

    </div>

    <!-- Bottom Row: Secure Payments (left) + Follow Us (right) -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 border-t border-white/20 pt-6">

      <!-- Secure Payments -->
      <div class="flex items-center gap-4">
        <span class="text-sm font-bold text-white">100% Secure Payments</span>
        <div class="flex items-center gap-2">
          <img src="<?= asset('images/payments.png') ?>" alt="payments" class="h-7">
          
        </div>
      </div>

      <!-- Follow Us -->
      <div class="flex items-center gap-3">
        <span class="text-sm font-bold text-white">Follow us</span>
        <a href="<?= e($facebookUrl ?? '#') ?>" class="w-9 h-9 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors border border-white/30">
          <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1V12h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/></svg>
        </a>
        <a href="<?= e($instagramUrl ?? '#') ?>" class="w-9 h-9 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors border border-white/30">
          <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
        </a>
        <a href="<?= e($youtubeUrl ?? '#') ?>" class="w-9 h-9 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors border border-white/30">
          <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.163a3.003 3.003 0 00-2.11-2.11C19.517 3.545 12 3.545 12 3.545s-7.517 0-9.388.508a3.003 3.003 0 00-2.11 2.11C0 8.033 0 12 0 12s0 3.967.502 5.837a3.003 3.003 0 002.11 2.11c1.871.508 9.388.508 9.388.508s7.517 0 9.388-.508a3.003 3.003 0 002.11-2.11C24 15.967 24 12 24 12s0-3.967-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
        </a>
      </div>

    </div>

    <!-- Security Warning -->
    <div class="bg-white/10 rounded-xl p-5 border border-white/20 max-w-5xl mx-auto text-center">
      <h4 class="text-sm font-bold text-white mb-2">BEWARE OF SPURIOUS PHONE CALLS AND FICTITIOUS/FRAUDULENT OFFERS</h4>
      <p class="text-xs text-white/70 leading-relaxed">Please be advised that <?= e($footerName) ?> does not run any promotions or offers involving electronics or high-value products outside of our business. We will never ask for personal information, payments, or banking details over the phone. Any such messages are not authorized by <?= e($footerName) ?> and should be ignored to protect yourself from potential scams.</p>
    </div>

    <!-- Copyright -->
    <div class="text-center pt-4">
      <p class="text-xs text-white/60">Copyright &copy; <?= $currentYear ?> <?= e($footerName) ?> | Powered by Archtech Design</p>
    </div>

  </div>
</footer>

<!-- ============================================ -->
<!-- FLOATING WHATSAPP BUTTON -->
<!-- ============================================ -->
<a href="<?= e($whatsappLink ?? WHATSAPP_LINK) ?>" class="whatsapp-float" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp">
    <i class="fa-brands fa-whatsapp"></i>
</a>

<!-- ============================================ -->
<!-- GLOBAL JAVASCRIPT -->
<!-- ============================================ -->
<script>
<?php
$wishlistProductIds = [];
if (\App\Helpers\Session::has('user')) {
    $uid = \App\Helpers\Session::get('user')['id'] ?? 0;
    if ($uid) {
        $pdo = \App\Core\Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT product_id FROM sg_wishlists WHERE user_id = :uid");
        $stmt->execute([':uid' => $uid]);
        $wishlistProductIds = $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
}
?>
window._wishlistIds = <?= json_encode(array_map('intval', $wishlistProductIds)) ?>;
function toggleMobileMenu() {
    document.querySelector('.nav-links .flex.items-center.gap-6').classList.toggle('hidden');
}
function addToCart(productId, quantity, variantId) {
    quantity = quantity || 1;
    var params = 'action=add_to_cart&product_id=' + productId + '&quantity=' + quantity + '&_csrf_token=<?= \App\Helpers\Session::csrfToken() ?>';
    if (variantId) params += '&variant_id=' + variantId;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '<?= url('cart/add') ?>', true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        console.log('addToCart response:', xhr.status, xhr.responseText.substring(0, 500));
        try {
            var d = JSON.parse(xhr.responseText);
            if (d.success) { showToast(d.message, 'success'); updateCartCount(d.cart_count); updateCartTotal(d.cart_total); }
            else { showToast(d.message || 'Error', 'error'); }
        } catch(e) {
            console.error('addToCart JSON parse error:', e.message, 'Status:', xhr.status);
            console.error('Raw response:', xhr.responseText.substring(0, 1000));
            showToast('Failed to add to cart.', 'error');
        }
    };
    xhr.onerror = function() { console.error('addToCart network error'); showToast('Failed to add to cart.', 'error'); };
    xhr.send(params);
}
function addToWishlist(productId) {
    var formData = new FormData();
    formData.append('action', 'add_to_wishlist');
    formData.append('product_id', productId);
    formData.append('_csrf_token', '<?= \App\Helpers\Session::csrfToken() ?>');
    fetch('<?= url('wishlist/add') ?>', {
        method: 'POST', body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function(r) { return r.json(); })
    .then(function(d) {
        showToast(d.message, d.success ? 'success' : 'error');
        if (d.wishlist_count !== undefined) updateWishlistCount(d.wishlist_count);
    })
    .catch(function() { showToast('Failed to add to wishlist.', 'error'); });
}
function addToCompare(productId) {
    var btn = document.querySelector('[data-compare="' + productId + '"]');
    var formData = new FormData();
    formData.append('product_id', productId);
    formData.append('_csrf_token', '<?= \App\Helpers\Session::csrfToken() ?>');
    fetch('<?= url('compare/toggle') ?>', {
        method: 'POST', body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function(r) { return r.json(); })
    .then(function(d) {
        if (d.success) {
            var compare = JSON.parse(localStorage.getItem('compare') || '[]');
            if (d.action === 'added') {
                if (compare.indexOf(productId) === -1) compare.push(productId);
            } else {
                compare = compare.filter(function(id) { return id !== productId; });
            }
            localStorage.setItem('compare', JSON.stringify(compare));
            if (btn) {
                btn.classList.toggle('is-active', d.action === 'added');
                btn.classList.toggle('is-inactive', d.action === 'removed');
            }
            if (typeof d.count === 'number') updateCompareCount(d.count);
            showToast(d.action === 'added' ? 'Added to compare' : 'Removed from compare', 'success');
        } else {
            showToast(d.message || 'Error', 'error');
        }
    })
    .catch(function() { showToast('Failed to update compare.', 'error'); });
}
function updateCompareCount(count) {
    var badges = document.querySelectorAll('.compare-count');
    badges.forEach(function(b) { b.textContent = count; b.style.display = count > 0 ? 'flex' : 'none'; });
}
function updateCartCount(count) {
    var badges = document.querySelectorAll('.cart-count, .cart-count-mobile');
    badges.forEach(function(b) { b.textContent = count; b.style.display = count > 0 ? 'flex' : 'none'; });
}
function updateCartTotal(total) {
    if (total === undefined) return;
    var currency = window.APP_CURRENCY || '<?= APP_CURRENCY ?>';
    var pills = document.querySelectorAll('.cart-total');
    pills.forEach(function(el) { el.textContent = currency + ' ' + Number(total).toFixed(2); });
}
function toggleWishlist(productId) {
    var btn = document.querySelector('[data-wishlist="' + productId + '"]');
    var formData = new FormData();
    formData.append('product_id', productId);
    formData.append('_csrf_token', '<?= \App\Helpers\Session::csrfToken() ?>');
    fetch('<?= url('account/wishlist/add') ?>', {
        method: 'POST', body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function(r) {
        return r.json().catch(function(e) {
            return r.text().then(function(t) { console.error('Response text:', t.substring(0, 500)); throw e; });
        });
    })
    .then(function(data) {
        if (data.success) {
            var wishlist = window._wishlistIds || [];
            if (data.action === 'added') {
                if (wishlist.indexOf(productId) === -1) wishlist.push(productId);
            } else {
                wishlist = wishlist.filter(function(id) { return id !== productId; });
            }
            window._wishlistIds = wishlist;
            if (btn) {
                btn.classList.toggle('is-active', data.action === 'added');
                btn.classList.toggle('is-inactive', data.action === 'removed');
            }
            if (typeof data.count === 'number') updateWishlistCount(data.count);
            showToast(data.action === 'added' ? 'Added to wishlist' : 'Removed from wishlist', 'success');
        } else {
            showToast(data.message || 'Error', 'error');
        }
    })
    .catch(function(e) { console.error('toggleWishlist caught:', e); showToast('Network error', 'error'); });
}
document.addEventListener('DOMContentLoaded', function() {
    var wishlist = window._wishlistIds || [];
    wishlist.forEach(function(id) {
        var btn = document.querySelector('[data-wishlist="' + id + '"]');
        if (btn) {
            btn.classList.add('is-active');
            btn.classList.remove('is-inactive');
        }
    });
    var compare = JSON.parse(localStorage.getItem('compare') || '[]');
    compare.forEach(function(id) {
        var btn = document.querySelector('[data-compare="' + id + '"]');
        if (btn) {
            btn.classList.add('is-active');
            btn.classList.remove('is-inactive');
        }
    });
});
function updateWishlistCount(count) {
    var badges = document.querySelectorAll('.wishlist-count');
    badges.forEach(function(b) { b.textContent = count; b.style.display = count > 0 ? 'flex' : 'none'; });
}
function showToast(message, type) {
    type = type || 'info';
    var colors = { success: 'bg-green-500', error: 'bg-red-500', warning: 'bg-yellow-500', info: 'bg-blue-500' };
    var toast = document.createElement('div');
    toast.className = 'fixed top-24 right-5 z-[9999] ' + (colors[type] || colors.info) + ' text-white px-5 py-3 rounded-lg shadow-lg animate-slideInRight';
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(function() {
        toast.style.opacity = '0'; toast.style.transition = 'opacity 0.3s';
        setTimeout(function() { toast.remove(); }, 300);
    }, 3000);
}
document.addEventListener('click', function(e) {
    if (e.target.closest('[onclick*="remove"]')) e.target.closest('.fixed.top-24').remove();
});
</script>

</body>
</html>