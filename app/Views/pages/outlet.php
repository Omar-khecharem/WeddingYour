<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex items-center text-xs sm:text-sm text-gray-500 mb-6 space-x-2">
        <a href="<?= url('') ?>" class="hover:text-red-600">Home</a>
        <span>/</span>
        <span class="text-gray-800 font-medium"><?= e($outlet['name']) ?></span>
    </nav>

    <h1 class="text-3xl font-black text-gray-800 mb-8">Our <?= e($outlet['name']) ?> Outlet</h1>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        <!-- LEFT: Contact Form -->
        <div class="lg:col-span-3 bg-white rounded-xl border border-gray-200 p-6 sm:p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Get in Touch</h2>
            <form method="POST" action="<?= url('contact') ?>">
                <?= \App\Helpers\Security::csrfField() ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">First name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last name <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Your Message <span class="text-red-500">*</span></label>
                    <textarea name="message" rows="5" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none"></textarea>
                </div>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold text-sm px-6 py-3 rounded-lg transition-colors">Send Message</button>
            </form>
        </div>

        <!-- RIGHT: Contact Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Need a Help?</h3>
                <div class="space-y-3 text-sm text-gray-600">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span><?= e($outlet['phone'] ?: '+91 8961686776') ?> (10:00 AM - 8:00 PM)</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Email: <?= e($outlet['email'] ?: 'info@sholaghar.com') ?></span>
                    </div>
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <div>
                            <span><?= e($outlet['address'] ?: 'Chinar Park') ?></span>
                            <?php if (!empty($outlet['city'])): ?><br><span><?= e($outlet['city']) ?></span><?php endif; ?>
                            <?php if (!empty($outlet['state'])): ?>, <span><?= e($outlet['state']) ?></span><?php endif; ?>
                            <?php if (!empty($outlet['google_maps_link'])): ?>
                            <br><a href="<?= e($outlet['google_maps_link']) ?>" target="_blank" class="text-red-600 hover:text-red-700 font-medium text-xs mt-1 inline-block">View on Google Maps &rarr;</a>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>

            <div class="rounded-xl overflow-hidden border border-gray-200">
                <img src="<?= e(uploadUrl($outlet['image'] ?? '', 'outlets') ?: 'https://placehold.co/600x400/EEE/CCC?text=No+Image') ?>" alt="<?= e($outlet['name']) ?>" class="w-full h-48 object-cover">
            </div>
        </div>
    </div>
</div>
