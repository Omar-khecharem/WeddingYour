<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 sm:py-16">
  <div class="text-center mb-10 sm:mb-14">
    <h1 class="text-3xl sm:text-4xl font-black text-gray-900 mb-3">Our Outlets</h1>
    <p class="text-gray-500 text-sm sm:text-base max-w-xl mx-auto">Visit our stores across the city for a hands-on experience of our finest wedding collections.</p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
    <?php if (!empty($outlets)): ?>
    <?php foreach ($outlets as $o): ?>
    <a href="<?= url('outlets/' . e($o['slug'] ?? '')) ?>" class="group bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
      <div class="aspect-[4/3] overflow-hidden bg-gray-100">
        <?php if (!empty($o['image'])): ?>
        <img src="<?= uploadUrl($o['image'], 'outlets') ?>" alt="<?= e($o['name'] ?? '') ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        <?php else: ?>
        <div class="w-full h-full flex items-center justify-center text-gray-300 font-bold text-4xl"><?= e(substr($o['name'] ?? 'O', 0, 2)) ?></div>
        <?php endif; ?>
      </div>
      <div class="p-5 sm:p-6">
        <h3 class="text-lg sm:text-xl font-bold text-gray-900 group-hover:text-primary-red transition-colors"><?= e($o['name'] ?? '') ?></h3>
        <?php if (!empty($o['address'])): ?>
        <p class="text-sm text-gray-500 mt-1.5 line-clamp-2"><?= e($o['address']) ?></p>
        <?php endif; ?>
        <div class="flex items-center gap-4 mt-4 text-xs text-gray-400">
          <?php if (!empty($o['phone'])): ?>
          <span class="flex items-center gap-1"><i class="fa-solid fa-phone"></i> <?= e($o['phone']) ?></span>
          <?php endif; ?>
          <?php if (!empty($o['email'])): ?>
          <span class="flex items-center gap-1"><i class="fa-solid fa-envelope"></i> <?= e($o['email']) ?></span>
          <?php endif; ?>
        </div>
        <div class="mt-4 flex items-center text-sm font-semibold text-primary-red group-hover:gap-2 transition-all">
          <span>Explore Store</span>
          <i class="fa-solid fa-arrow-right ml-1.5 text-xs"></i>
        </div>
      </div>
    </a>
    <?php endforeach; ?>
    <?php else: ?>
    <div class="col-span-full text-center py-16">
      <div class="text-5xl text-gray-300 mb-4"><i class="fa-solid fa-store"></i></div>
      <p class="text-gray-500">No outlets available at the moment.</p>
    </div>
    <?php endif; ?>
  </div>
</div>
