@props([
    'link' => 'px-2 md:px-5 py-2.5 rounded-md font-semibold focus:ring-gray-500 dark:focus:ring-gray-50 border border-gray-500 dark:border-gray-50 hover:border-transparent dark:hover:border-transparent text-gray-50 hover:text-white hover:bg-blue-600 uppercase font-semibold text-xs tracking-widest cursor-pointer transition duration-500',
])

<div id="cookie-consent-modal" class="overflow-y-auto">
    @if($seekingConsent)
        <!-- Consent modal -->
        <template x-teleport="body">
            <div id="cookie-consent-modal-body"
                 x-data="{ open: @entangle('openConsentModal') }"
                 x-show="open"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-x-full"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 -translate-x-full"
                 class="fixed bottom-0 left-0 w-full">
                    <div class="flex z-[51] w-full h-20 items-center bg-yellow-900">
                        <div class="flex px-4 space-x-4 items-center">
                            <p class="inline text-xs text-gray-50">{{ __('cookie-consent::text.accept_cookies') }}</p>
                            <div
                                wire:click="giveConsent"
                                class="{{ $link }}">
                                <span wire:loading.remove class="transition">{{ __('cookie-consent::text.yes') }}</span>
                                <span wire:loading class="animate-pulse transition">{{ __('cookie-consent::text.thinking') }}</span>
                            </div>
                            <div
                                wire:click="refuseConsent"
                                class="{{ $link }}">
                                <span wire:loading.remove class="transition">{{ __('cookie-consent::text.no') }}</span>
                                <span wire:loading class="animate-pulse transition">{{ __('cookie-consent::text.thinking') }}</span>
                            </div>
                            <div
                                    wire:click="toggleCookieModal"
                                    @click="$dispatch('hideScroll')"
                                    class="{{ $link }}">
                                <span wire:loading.remove class="transition">{{ __('cookie-consent::text.learn_more') }}</span>
                                <span wire:loading class="animate-pulse transition">{{ __('cookie-consent::text.thinking') }}</span>
                            </div>
                        </div>
                        <div class="absolute left-2 -top-7 md:-top-5 w-10 h-10">
                            <x-cookie />
                        </div>
                    </div>
            </div>
        </template>

        <!-- Cookie policy modal -->
        <div x-data="{ open: @entangle('openCookieModal') }"
             x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             x-on:hidescroll.window="document.body.style.overflow = 'hidden';"
             x-on:showscroll.window="document.body.style.overflow = 'auto';"
             class="fixed z-[51] w-full h-full top-0 left-0 flex items-center justify-center overflow-y-auto"
             style="display:none;">

            <div
                @click.outside="$wire.toggleCookieModal();$dispatch('hideScroll')"
                @keydown.escape.window="$wire.toggleCookieModal();$dispatch('hideScroll')"
                class="relative absolute m-auto w-full md:w-1/2 h-full md:h-4/5 sm:mx-0 p-8 z-50 overflow-y-auto md:rounded-lg border md:border-gray-600 dark:md:border-gray-200 bg-white dark:bg-slate-800 border-slate-400 text-gray-800 dark:text-gray-50">
                <!-- Close button -->
                <div
                    wire:click="toggleCookieModal"
                    @click="$dispatch('hideScroll')"
                    class="absolute top-8 right-8 mb-14 w-8 h-8 z-40 transition cursor-pointer text-gray-600 dark:text-gray-50 hover:text-blue-600 dark:hover:text-orange-400"
                >
                    <x-close />
                </div>
                <!-- Cookie image -->
                <div class="mx-auto flex items-center justify-center w-10 h-10">
                    <x-cookie />
                </div>

                <!-- Body -->
                <div class="mt-5 leading-snug">
                    <h1 class="mb-4 text-3xl md:text-4xl">{{ __('cookie-consent::text.cookie_policy') }}</h1>

                    <x-cookie-policy />
                </div>

                <!-- Footer -->
                <div class="mt-5 flex justify-center">
                    <div class="mx-auto">
                        <div
                                wire:click="toggleCookieModal"
                                @click="$dispatch('hideScroll')"
                                class="{{ $link }}">
                            <span wire:loading.remove class="transition">{{ __('cookie-consent::text.close') }}</span>
                            <span wire:loading class="animate-pulse transition">{{ __('cookie-consent::text.thinking') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
