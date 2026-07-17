<div class="max-w-5xl mx-auto px-4 py-12">
  <h1 class="text-3xl font-black text-gray-900 mb-6">Contact Us</h1>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div>
      <p class="text-gray-600 leading-relaxed mb-6">Have a question or need help with your order? We'd love to hear from you.</p>
      <div class="space-y-4">
        <div class="flex items-start gap-3">
          <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-envelope text-red-600"></i></div>
          <div><p class="font-semibold text-gray-900">Email</p><p class="text-sm text-gray-500"><?= e(\App\Models\Setting::get('contact_email', CONTACT_EMAIL)) ?></p></div>
        </div>
        <div class="flex items-start gap-3">
          <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-phone text-red-600"></i></div>
          <div><p class="font-semibold text-gray-900">Phone</p><p class="text-sm text-gray-500"><?= e(\App\Models\Setting::get('contact_phone', CONTACT_PHONE)) ?></p></div>
        </div>
        <div class="flex items-start gap-3">
          <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-location-dot text-red-600"></i></div>
          <div><p class="font-semibold text-gray-900">Address</p><p class="text-sm text-gray-500"><?= e(\App\Models\Setting::get('contact_address', CONTACT_ADDRESS)) ?></p></div>
        </div>
      </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
      <h2 class="text-lg font-bold text-gray-900 mb-4">Send us a message</h2>
      <form method="POST" action="<?= url('contact') ?>" class="space-y-4">
        <?= \App\Helpers\Security::csrfField() ?>
        <div><input type="text" name="name" placeholder="Your Name" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-200 focus:border-red-500 outline-none"></div>
        <div><input type="email" name="email" placeholder="Your Email" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-200 focus:border-red-500 outline-none"></div>
        <div><textarea name="message" rows="4" placeholder="Your Message" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-200 focus:border-red-500 outline-none"></textarea></div>
        <button type="submit" class="bg-red-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-red-700 transition-colors">Send Message</button>
      </form>
    </div>
  </div>
</div>
