<div id="cookie-consent-changer">
    @if ($consentGiven)
        <div class="italic">
            <p>{{ __('cookie-consent::text.consent_given') }}</p>

            <div class="mt-8">
                <div
                        wire:click="refuseConsent"
                        class="px-2 md:px-5 py-2.5 focus:ring-gray-500 dark:focus:ring-gray-50 border border-gray-500 dark:border-gray-50 hover:border-transparent dark:hover:border-transparent text-gray-50 hover:text-white hover:bg-blue-600 text-xs">
                    <span wire:loading.remove class="transition">{{ __('cookie-consent::text.no') }}</span>
                    <span wire:loading class="animate-pulse transition">{{ __('cookie-consent::text.thinking') }}</span>
                </div>
            </div>
        </div>
    @elseif ($consentRefused)
        <div class="italic">
            <p>{{ __('cookie-consent::text.consent_refused') }}</p>

            <div class="mt-8">
                <div
                        wire:click="giveConsent"
                        class="px-2 md:px-5 py-2.5 focus:ring-gray-500 dark:focus:ring-gray-50 border border-gray-500 dark:border-gray-50 hover:border-transparent dark:hover:border-transparent text-gray-50 hover:text-white hover:bg-blue-600 text-xs">
                    <span wire:loading.remove class="transition">{{ __('cookie-consent::text.yes') }}</span>
                    <span wire:loading class="animate-pulse transition">{{ __('cookie-consent::text.thinking') }}</span>
                </div>
            </div>
        </div>
    @endif
</div>