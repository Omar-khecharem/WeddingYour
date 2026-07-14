<style>
@keyframes marqueeTop {
  from { transform: translateX(0); }
  to   { transform: translateX(-33.333%); }
}
.marquee-top {
  animation: marqueeTop 18s linear infinite;
  display: flex;
  width: max-content;
}
</style>
<?php
$couponCode = \App\Models\Setting::get('header_coupon_code', 'SGTM20');
$couponText = \App\Models\Setting::get('header_coupon_text', 'Get FLAT 20% OFF On Topor Mukut set. To Redeem This Offer Use The Code -');
$cartCount = $cartCount ?? 0;
$wishlistCount = $wishlistCount ?? 0;
$compareCount = $compareCount ?? 0;
$isLoggedIn = $isLoggedIn ?? false;
$authUser = $authUser ?? null;
$appName = $appName ?? APP_NAME;
$appTagline = $appTagline ?? APP_TAGLINE;
$facebookUrl = $facebookUrl ?? SOCIAL_FACEBOOK;
$instagramUrl = $instagramUrl ?? SOCIAL_INSTAGRAM;
$youtubeUrl = $youtubeUrl ?? SOCIAL_YOUTUBE;
$cartTotal = \App\Helpers\Session::get('cart_total', 0.00);
?>
<div class="w-full font-sans text-slate-800 antialiased">

  <!-- TOP BANNER - Scrolling marquee -->
  <div class="bg-[#FF99B2] text-slate-900 text-xs md:text-sm font-semibold py-2 border-b border-pink-300 overflow-hidden">
    <div class="whitespace-nowrap marquee-top">
      <span class="inline-block px-4"><?= e($couponText) ?> <span class="bg-white/40 px-2 py-0.5 rounded font-mono font-bold text-red-700"><?= e($couponCode) ?></span></span>
      <span class="inline-block px-4"><?= e($couponText) ?> <span class="bg-white/40 px-2 py-0.5 rounded font-mono font-bold text-red-700"><?= e($couponCode) ?></span></span>
      <span class="inline-block px-4"><?= e($couponText) ?> <span class="bg-white/40 px-2 py-0.5 rounded font-mono font-bold text-red-700"><?= e($couponCode) ?></span></span>
    </div>
  </div>

  <!-- HEADER -->
  <header class="w-full bg-[#EAEAEA] py-4 px-6 md:px-12 lg:px-20 border-b border-gray-300">
    <div class="max-w-[1600px] mx-auto flex flex-col lg:flex-row items-center justify-between gap-6">

      <!-- Mobile top row: Logo + Social (hidden on desktop) -->
      <div class="flex items-center justify-between w-full lg:hidden">
        <a href="<?= url('') ?>" class="flex items-center gap-3 shrink-0">
          <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center border border-gray-300 shadow-sm overflow-hidden">
            <span class="text-red-600 font-black text-2xl tracking-tighter">SG</span>
          </div>
          <div class="flex flex-col justify-center">
            <h1 class="text-[#D32F2F] font-black text-2xl tracking-wide leading-none"><?= e($appName) ?></h1>
            <p class="text-[10px] text-gray-600 font-medium tracking-tight mt-1"><?= e($appTagline) ?></p>
          </div>
        </a>
        <div class="flex items-center gap-2.5 shrink-0">
          <?php $mapsSocial = [['url' => url('contact'), 'title' => 'Google Maps', 'bg' => '#EAEAEA', 'icon' => '<svg class="w-full h-full" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 36c9.941 0 18-8.059 18-18S27.941 0 18 0 0 8.059 0 18s8.059 18 18 18z" fill="#727272"/><path d="M18 0C11.4 0 5.6 3.5 2.4 8.7L18 21.6 33.6 8.7C30.4 3.5 24.6 0 18 0z" fill="#34A853"/><path d="M2.4 8.7C1 11.4.1 14.6.1 18c0 3.8 1.1 7.3 3.1 10.3l14.8-16.7L2.4 8.7z" fill="#FBBC05"/><path d="M18 21.6L3.2 28.3c3.2 4.8 8.8 7.7 14.8 7.7 6.1 0 11.6-3 14.8-7.7L18 21.6z" fill="#4285F4"/><path d="M32.8 28.3c2-3 3.1-6.5 3.1-10.3 0-3.4-.9-6.6-2.3-9.3L18 21.6l14.8 6.7z" fill="#757575"/><path d="M18 33.5c-4.4 0-8.2-2.3-10.4-5.8l10.4-8.8 10.4 8.8c-2.2 3.5-6 5.8-10.4 5.8z" fill="#EFEFEF"/><path d="M10 13.5c0-1.4 1.1-2.5 2.5-2.5h2v1.5h-2c-.6 0-1 .4-1 1s.4 1 1 1h2v1.5h-2c-1.4 0-2.5-1.1-2.5-2.5z" fill="white"/><path d="M22.5 7.5c-2.5 0-4.5 2-4.5 4.5 0 3.5 4.5 8.5 4.5 8.5s4.5-5 4.5-8.5c0-2.5-2-4.5-4.5-4.5zm0 6c-.8 0-1.5-.7-1.5-1.5s.7-1.5 1.5-1.5 1.5.7 1.5 1.5-.7 1.5-1.5 1.5z" fill="#EA4335"/></svg>']]; foreach ($mapsSocial as $s): ?>
          <a href="<?= $s['url'] ?>" class="relative w-9 h-9 rounded-full overflow-hidden flex items-center justify-center bg-[#EAEAEA]"><?= $s['icon'] ?></a>
          <?php endforeach; ?>
          <a href="<?= e($facebookUrl) ?>" class="w-9 h-9 rounded-full bg-[#3B5998] text-white flex items-center justify-center"><svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1V12h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/></svg></a>
          <a href="<?= e($instagramUrl) ?>" class="w-9 h-9 rounded-full bg-[#653E2A] text-white flex items-center justify-center"><svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
          <a href="<?= e($youtubeUrl) ?>" class="w-9 h-9 rounded-full bg-[#CD201F] text-white flex items-center justify-center"><svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.163a3.003 3.003 0 00-2.11-2.11C19.517 3.545 12 3.545 12 3.545s-7.517 0-9.388.508a3.003 3.003 0 00-2.11 2.11C0 8.033 0 12 0 12s0 3.967.502 5.837a3.003 3.003 0 002.11 2.11c1.871.508 9.388.508 9.388.508s7.517 0 9.388-.508a3.003 3.003 0 002.11-2.11C24 15.967 24 12 24 12s0-3.967-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
        </div>
      </div>

      <!-- Desktop Logo (hidden on mobile) -->
      <div class="hidden lg:flex items-center gap-3 shrink-0">
        <a href="<?= url('') ?>" class="flex items-center gap-3 shrink-0">
          <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center border border-gray-300 shadow-sm overflow-hidden">
            <span class="text-red-600 font-black text-2xl tracking-tighter">SG</span>
          </div>
          <div class="flex flex-col justify-center">
            <h1 class="text-[#D32F2F] font-black text-2xl tracking-wide leading-none"><?= e($appName) ?></h1>
            <p class="text-[10px] text-gray-600 font-medium tracking-tight mt-1"><?= e($appTagline) ?></p>
          </div>
        </a>
      </div>

      <!-- Search + Hamburger (mobile: burger left, search fills) -->
      <div class="w-full lg:flex-1 max-w-3xl px-2 flex items-center gap-2">
        <button class="p-2 hover:bg-gray-300 rounded-lg transition-colors lg:hidden shrink-0" aria-label="Menu" onclick="document.querySelector('.mobile-menu').classList.toggle('is-open')">
          <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <form action="<?= url('products') ?>" method="GET" class="relative w-full rounded-full border border-[#800080] bg-white p-0.5 shadow-sm focus-within:ring-1 focus-within:ring-[#800080]">
          <input type="text" name="q" placeholder="Search for products" value="<?= e($_GET['q'] ?? '') ?>" class="w-full pl-6 pr-14 py-2.5 bg-transparent text-sm text-gray-700 rounded-full outline-none placeholder-gray-400 font-normal" id="search-input" autocomplete="off">
          <button type="submit" class="absolute right-1 top-1 bottom-1 w-9 h-9 bg-[#A60A10] hover:bg-red-800 text-white rounded-full flex items-center justify-center transition-colors shadow-inner" aria-label="Search">
            <svg class="w-4 h-4 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
          </button>
          <div id="search-results" class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-2xl border border-slate-100 hidden z-50 overflow-hidden"></div>
        </form>
      </div>

      <!-- Desktop Social Icons (hidden on mobile) -->
      <div class="hidden lg:flex items-center gap-2.5 shrink-0">
        <a href="<?= url('contact') ?>" target="_blank" rel="noopener noreferrer" class="relative w-9 h-9 rounded-full overflow-hidden hover:scale-105 transition-transform flex items-center justify-center bg-[#EAEAEA]" title="Google Maps">
          <svg class="w-full h-full" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 36c9.941 0 18-8.059 18-18S27.941 0 18 0 0 8.059 0 18s8.059 18 18 18z" fill="#727272"/><path d="M18 0C11.4 0 5.6 3.5 2.4 8.7L18 21.6 33.6 8.7C30.4 3.5 24.6 0 18 0z" fill="#34A853"/><path d="M2.4 8.7C1 11.4.1 14.6.1 18c0 3.8 1.1 7.3 3.1 10.3l14.8-16.7L2.4 8.7z" fill="#FBBC05"/><path d="M18 21.6L3.2 28.3c3.2 4.8 8.8 7.7 14.8 7.7 6.1 0 11.6-3 14.8-7.7L18 21.6z" fill="#4285F4"/><path d="M32.8 28.3c2-3 3.1-6.5 3.1-10.3 0-3.4-.9-6.6-2.3-9.3L18 21.6l14.8 6.7z" fill="#757575"/><path d="M18 33.5c-4.4 0-8.2-2.3-10.4-5.8l10.4-8.8 10.4 8.8c-2.2 3.5-6 5.8-10.4 5.8z" fill="#EFEFEF"/><path d="M10 13.5c0-1.4 1.1-2.5 2.5-2.5h2v1.5h-2c-.6 0-1 .4-1 1s.4 1 1 1h2v1.5h-2c-1.4 0-2.5-1.1-2.5-2.5z" fill="white"/><path d="M22.5 7.5c-2.5 0-4.5 2-4.5 4.5 0 3.5 4.5 8.5 4.5 8.5s4.5-5 4.5-8.5c0-2.5-2-4.5-4.5-4.5zm0 6c-.8 0-1.5-.7-1.5-1.5s.7-1.5 1.5-1.5 1.5.7 1.5 1.5-.7 1.5-1.5 1.5z" fill="#EA4335"/>
          </svg>
        </a>
        <a href="<?= e($facebookUrl) ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-[#3B5998] hover:bg-[#2d4373] text-white flex items-center justify-center hover:scale-105 transition-transform shadow-sm" title="Facebook">
          <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1V12h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/></svg>
        </a>
        <a href="<?= e($instagramUrl) ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-[#653E2A] hover:bg-[#523221] text-white flex items-center justify-center hover:scale-105 transition-transform shadow-sm" title="Instagram">
          <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
        </a>
        <a href="<?= e($youtubeUrl) ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-[#CD201F] hover:bg-[#b01a19] text-white flex items-center justify-center hover:scale-105 transition-transform shadow-sm" title="YouTube">
          <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.163a3.003 3.003 0 00-2.11-2.11C19.517 3.545 12 3.545 12 3.545s-7.517 0-9.388.508a3.003 3.003 0 00-2.11 2.11C0 8.033 0 12 0 12s0 3.967.502 5.837a3.003 3.003 0 002.11 2.11c1.871.508 9.388.508 9.388.508s7.517 0 9.388-.508a3.003 3.003 0 002.11-2.11C24 15.967 24 12 24 12s0-3.967-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
        </a>
      </div>
    </div>
  </header>

  <!-- DESKTOP NAVIGATION -->
  <nav class="w-full bg-[#666666] text-white hidden lg:block">
    <div class="max-w-[1400px] mx-auto flex items-center justify-between">

      <!-- Browse Categories Dropdown -->
      <div class="relative group z-50 shrink-0">
        <button class="flex items-center justify-between w-56 xl:w-72 px-4 xl:px-5 py-4 bg-[#B10912] hover:bg-[#90070e] text-white font-bold transition-colors duration-150 focus:outline-none">
          <div class="flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <span class="tracking-wide uppercase text-sm font-extrabold">Browse Categories</span>
          </div>
          <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>

        <div class="absolute left-0 w-56 xl:w-72 bg-white text-slate-800 border-r border-b border-l border-gray-200 shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
          <ul class="py-1">
            <!-- BRIDE -->
            <li class="relative group/sub">
              <a href="<?= url('products?category=bride-mukut') ?>" class="flex items-center justify-between px-5 py-3 text-sm font-semibold hover:bg-red-50 hover:text-[#B10912] transition-colors border-b border-gray-100">
                <span>BRIDE</span>
                <svg class="w-3.5 h-3.5 text-gray-400 group-hover/sub:text-[#B10912]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
              </a>
              <div class="absolute left-full top-0 w-56 xl:w-72 bg-white border border-gray-200 shadow-2xl py-2 opacity-0 invisible group-hover/sub:opacity-100 group-hover/sub:visible transition-all duration-200">
                <ul>
                  <li><a href="<?= url('products?category=bride-mukut&subcategory=bridal-patashi') ?>" class="block px-6 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-[#B10912]">Bridal Patashi / Mukut</a></li>
                  <li><a href="<?= url('products?category=bride-mukut&subcategory=bridal-sithi') ?>" class="block px-6 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-[#B10912]">Bridal Sithi / Small Mukut</a></li>
                  <li><a href="<?= url('products?category=bride-mukut&subcategory=crown') ?>" class="block px-6 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-[#B10912]">Crown & 3 Pieces Set</a></li>
                  <li><a href="<?= url('products?category=bride-mukut&subcategory=boron') ?>" class="block px-6 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-[#B10912]">Boron / Khoidan Kulo</a></li>
                  <li><a href="<?= url('products?category=gachhkouto-dorpon') ?>" class="block px-6 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-[#B10912]">Gach kouto</a></li>
                  <li><a href="<?= url('products?category=bride-mukut&subcategory=panpata') ?>" class="block px-6 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-[#B10912]">Panpata</a></li>
                  <li><a href="<?= url('products?category=bride-mukut&subcategory=piri') ?>" class="block px-6 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-[#B10912]">Piri</a></li>
                </ul>
              </div>
            </li>

            <!-- GROOM -->
            <li class="relative group/sub">
              <a href="<?= url('products?category=groom-topor') ?>" class="flex items-center justify-between px-5 py-3 text-sm font-semibold hover:bg-red-50 hover:text-[#B10912] transition-colors border-b border-gray-100">
                <span>GROOM</span>
                <svg class="w-3.5 h-3.5 text-gray-400 group-hover/sub:text-[#B10912]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
              </a>
              <div class="absolute left-full top-0 w-56 xl:w-72 bg-white border border-gray-200 shadow-2xl py-2 opacity-0 invisible group-hover/sub:opacity-100 group-hover/sub:visible transition-all duration-200">
                <ul>
                  <li><a href="<?= url('products?category=groom-topor&subcategory=topor-simple') ?>" class="block px-6 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-[#B10912]">Traditional Topor</a></li>
                  <li><a href="<?= url('products?category=groom-topor&subcategory=topor-royal') ?>" class="block px-6 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-[#B10912]">Royal Topor Set</a></li>
                </ul>
              </div>
            </li>

            <!-- BABY -->
            <li class="relative group/sub">
              <a href="<?= url('products?category=baby-mukut') ?>" class="flex items-center justify-between px-5 py-3 text-sm font-semibold hover:bg-red-50 hover:text-[#B10912] transition-colors border-b border-gray-100">
                <span>BABY</span>
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
              </a>
            </li>

            <!-- WEDDING ITEMS -->
            <li class="relative group/sub">
              <a href="<?= url('products?category=wedding-items') ?>" class="flex items-center justify-between px-5 py-3 text-sm font-semibold hover:bg-red-50 hover:text-[#B10912] transition-colors border-b border-gray-100">
                <span>WEDDING ITEMS</span>
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
              </a>
            </li>

            <!-- SHOLA'S JEWELLERY -->
            <li class="relative group/sub">
              <a href="<?= url('products?category=exclusive-collection') ?>" class="flex items-center justify-between px-5 py-3 text-sm font-semibold hover:bg-red-50 hover:text-[#B10912] transition-colors border-b border-gray-100">
                <span>SHOLA'S JEWELLERY</span>
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
              </a>
            </li>

            <!-- BEST SELLER -->
            <li>
              <a href="<?= url('products?sort=popular') ?>" class="block px-5 py-3 text-sm font-semibold hover:bg-red-50 hover:text-[#B10912] transition-colors border-b border-gray-100">
                Best Seller
              </a>
            </li>

            <!-- EXCLUSIVE -->
            <li>
              <a href="<?= url('products?featured=1') ?>" class="block px-5 py-3 text-sm font-semibold hover:bg-red-50 hover:text-[#B10912] transition-colors">
                Exclusive
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Page Links -->
      <div class="hidden lg:flex items-center gap-6 xl:gap-8 font-extrabold text-xs xl:text-sm tracking-wider">
        <a href="<?= url('') ?>" class="flex items-center gap-1.5 py-4 px-2 hover:text-red-400 transition-colors border-b-2 border-red-500 text-white">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
          </svg>
          HOME
        </a>
        <a href="<?= url('outlets') ?>" class="flex items-center gap-1.5 py-4 px-2 text-gray-300 hover:text-white transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
          </svg>
          OUR OUTLETS
        </a>
        <a href="<?= url('about') ?>" class="flex items-center gap-1.5 py-4 px-2 text-gray-300 hover:text-white transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
          </svg>
          ABOUT US
        </a>
        <a href="<?= url('contact') ?>" class="flex items-center gap-1.5 py-4 px-2 text-gray-300 hover:text-white transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
          </svg>
          CONTACT US
        </a>
        <a href="<?= url('blog') ?>" class="flex items-center gap-1.5 py-4 px-2 text-gray-300 hover:text-white transition-colors">BLOGS</a>
      </div>

      <!-- Action Buttons -->
      <div class="flex items-center gap-3 pr-4 py-2 shrink-0">
        <!-- Profile -->
        <a href="<?= $isLoggedIn ? url('account') : url('login') ?>" class="w-9 h-9 rounded-full bg-white text-slate-700 hover:bg-slate-100 flex items-center justify-center transition-colors shadow-sm" aria-label="Profil">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
        </a>

        <!-- Compare -->
        <a href="<?= url('compare') ?>" class="relative w-9 h-9 rounded-full bg-white text-slate-700 hover:bg-slate-100 flex items-center justify-center transition-colors shadow-sm" aria-label="Comparer">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
          </svg>
          <span class="absolute -top-1.5 -right-1.5 bg-[#B10912] text-white text-[9px] font-black w-4.5 h-4.5 px-1 rounded-full flex items-center justify-center border border-white compare-count"><?= $compareCount ?></span>
        </a>

        <!-- Wishlist -->
        <a href="<?= url('account/wishlist') ?>" class="relative w-9 h-9 rounded-full bg-white text-slate-700 hover:bg-slate-100 flex items-center justify-center transition-colors shadow-sm" aria-label="Favoris">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
          </svg>
          <span class="absolute -top-1.5 -right-1.5 bg-[#B10912] text-white text-[9px] font-black w-4.5 h-4.5 px-1 rounded-full flex items-center justify-center border border-white wishlist-count"><?= $wishlistCount ?></span>
        </a>

        <!-- Cart Pill -->
        <a href="<?= url('cart') ?>" class="flex items-center gap-2 bg-[#B10912] hover:bg-[#90070e] px-3.5 py-2 rounded-full cursor-pointer transition-colors shadow-md">
          <div class="relative">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <span class="absolute -top-1.5 -right-1.5 bg-white text-[#B10912] text-[9px] font-black w-4 h-4 rounded-full flex items-center justify-center cart-count"><?= $cartCount ?></span>
          </div>
          <span class="text-xs font-black text-white select-none"><?= APP_CURRENCY ?> <?= number_format($cartTotal, 2) ?></span>
        </a>
      </div>

    </div>
  </nav>

  <!-- MOBILE BOTTOM BAR -->
  <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 flex items-center justify-around py-2 lg:hidden shadow-lg">
    <a href="<?= url('') ?>" class="flex flex-col items-center gap-0.5 text-gray-600 hover:text-red-600 transition-colors">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
      <span class="text-[10px] font-semibold">Home</span>
    </a>
    <a href="<?= url('products') ?>" class="flex flex-col items-center gap-0.5 text-gray-600 hover:text-red-600 transition-colors">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
      <span class="text-[10px] font-semibold">Categories</span>
    </a>
    <a href="<?= url('compare') ?>" class="relative flex flex-col items-center gap-0.5 text-gray-600 hover:text-red-600 transition-colors">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
      <span class="absolute -top-1 -right-2 bg-[#B10912] text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center compare-count"><?= $compareCount ?></span>
      <span class="text-[10px] font-semibold">Compare</span>
    </a>
    <a href="<?= url('account/wishlist') ?>" class="relative flex flex-col items-center gap-0.5 text-gray-600 hover:text-red-600 transition-colors">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
      <span class="absolute -top-1 -right-2 bg-[#B10912] text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center wishlist-count"><?= $wishlistCount ?></span>
      <span class="text-[10px] font-semibold">Wishlist</span>
    </a>
    <a href="<?= url('cart') ?>" class="relative flex flex-col items-center gap-0.5 text-gray-600 hover:text-red-600 transition-colors">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
      <span class="cart-count absolute -top-1 -right-2 bg-[#B10912] text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center"><?= $cartCount ?></span>
      <span class="text-[10px] font-semibold">Cart</span>
    </a>
    <a href="<?= $isLoggedIn ? url('account') : url('login') ?>" class="flex flex-col items-center gap-0.5 text-gray-600 hover:text-red-600 transition-colors">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
      <span class="text-[10px] font-semibold">Account</span>
    </a>
  </div>
</div>
