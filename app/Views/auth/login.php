<?php
/**
 * Login Page
 */
?>
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-full bg-premium-burgundy text-white text-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fa-regular fa-user"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Welcome Back</h1>
            <p class="text-gray-500 text-sm mt-1">Sign in to your account</p>
        </div>

        <form method="POST" action="<?= url('login') ?>" class="space-y-4">
            <?= \App\Helpers\Security::csrfField() ?>
            
            <?= error() ?>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                <input type="email" name="email" value="<?= old('email') ?>" required class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-premium-burgundy focus:ring-1 focus:ring-premium-burgundy transition-all">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                <input type="password" name="password" required class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-premium-burgundy focus:ring-1 focus:ring-premium-burgundy transition-all">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-premium-burgundy focus:ring-premium-burgundy">
                    <span class="text-sm text-gray-600">Remember me</span>
                </label>
                <a href="<?= url('forgot-password') ?>" class="text-sm text-premium-burgundy hover:underline font-medium">Forgot Password?</a>
            </div>

            <button type="submit" class="w-full bg-premium-burgundy text-white font-bold py-3.5 rounded-xl hover:opacity-90 transition-all shadow-lg shadow-premium-burgundy/20">
                Sign In <i class="fa-solid fa-arrow-right ml-1.5"></i>
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">Don't have an account? <a href="<?= url('register') ?>" class="text-premium-burgundy font-semibold hover:underline">Create one</a></p>
        </div>
    </div>
</div>
