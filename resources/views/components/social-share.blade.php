@props(['url', 'title', 'description' => '', 'image' => ''])

@php
    $enabled = \App\Models\Setting::get('social_share_enabled', '1') === '1';

    $platforms = $enabled
        ? \App\Models\SocialPlatform::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
        : collect();
@endphp

@if($platforms->isNotEmpty())
    <div {{ $attributes->merge(['class' => 'social-share-buttons d-flex align-items-center justify-content-center flex-wrap']) }}>
        
        {{-- Native Share Button (Hidden by default, shown via JS if supported) --}}
        <button class="btn btn-outline-light btn-sm rounded-circle me-1 mb-2 social-share-link d-none js-native-share"
            data-color="#64a19d" 
            data-title="{{ $title }}"
            data-text="{{ $description }}"
            data-url="{{ $url }}"
            title="Share via device">
            <i class="fas fa-share-nodes"></i>
        </button>

        @foreach($platforms as $platform)
            @php
                $shareUrl = $platform->base_share_url . urlencode($url);
                if ($platform->slug === 'email') {
                    $shareUrl = 'mailto:?subject=' . urlencode($title) . '&body=' . urlencode($description . "\n\n" . $url);
                } elseif ($platform->slug === 'whatsapp') {
                    $shareUrl = 'https://api.whatsapp.com/send?text=' . urlencode($title . ' ' . $url);
                } elseif ($platform->slug === 'pinterest' && $image) {
                    $shareUrl .= '&media=' . urlencode($image) . '&description=' . urlencode($title);
                } elseif ($platform->slug === 'twitter') {
                    $shareUrl .= '&text=' . urlencode($title);
                } elseif ($platform->slug === 'instagram') {
                    $shareUrl = 'https://www.instagram.com/';
                }
            @endphp

            <a href="{{ $shareUrl }}" target="_blank" 
               class="btn btn-outline-light btn-sm rounded-circle me-1 mb-2 social-share-link"
               data-color="{{ $platform->color }}"
               data-slug="{{ $platform->slug }}"
               title="Share on {{ $platform->name }}"
               onclick="window.socialShare.track('{{ $platform->slug }}', '{{ $url }}'); if('{{ $platform->slug }}' !== 'email' && '{{ $platform->slug }}' !== 'instagram') { window.open(this.href, 'share-{{ $platform->slug }}', 'width=600,height=400'); return false; }">
                <i class="{{ $platform->icon_class }}"></i>
            </a>
        @endforeach

        {{-- Copy to Clipboard Button --}}
        <button class="btn btn-outline-light btn-sm rounded-circle me-1 mb-2 social-share-link position-relative js-copy-link"
            data-color="#888"
            data-url="{{ $url }}"
            title="Copy link">
            <i class="fas fa-link"></i>
            <span class="copy-tooltip d-none">Copied!</span>
        </button>
    </div>

    @once
        @push('styles')
            <style>
                .social-share-link {
                    width: 32px;
                    height: 32px;
                    line-height: 20px;
                    padding: 5px;
                    border-color: transparent !important;
                    color: white !important;
                    background-color: transparent !important;
                    opacity: 0.2;
                    transition: all 0.4s ease-in-out !important;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                }
                .social-share-link:hover {
                    opacity: 1;
                    background-color: var(--hover-color, #64a19d) !important;
                    border-color: var(--hover-color, #64a19d) !important;
                    color: white !important;
                }
                .social-share-link i {
                    font-size: 0.85rem;
                }
                .copy-tooltip {
                    position: absolute;
                    bottom: 120%;
                    left: 50%;
                    transform: translateX(-50%);
                    background: #64a19d;
                    color: white;
                    padding: 4px 8px;
                    border-radius: 4px;
                    font-size: 10px;
                    white-space: nowrap;
                    z-index: 10;
                }
                .copy-tooltip::after {
                    content: '';
                    position: absolute;
                    top: 100%;
                    left: 50%;
                    margin-left: -4px;
                    border-width: 4px;
                    border-style: solid;
                    border-color: #64a19d transparent transparent transparent;
                }
            </style>
        @endpush
        @push('scripts')
            <script>
                // Global sharing analytics object
                window.socialShare = {
                    track: function(platform, url) {
                        if (typeof gtag === 'function') {
                            gtag('event', 'share', {
                                'method': platform,
                                'content_type': 'article',
                                'item_id': url
                            });
                        }

                        fetch('{{ route('log.event') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                type: 'share_' + platform,
                                message: 'User shared ' + url + ' via ' + platform
                            })
                        });
                    }
                };

                document.addEventListener('DOMContentLoaded', function () {
                    const setupButtons = () => {
                        // Hover effects
                        document.querySelectorAll('.social-share-link').forEach(btn => {
                            if (btn.dataset.initialized) return;
                            btn.dataset.initialized = "true";

                            btn.addEventListener('mouseenter', function() {
                                this.style.setProperty('--hover-color', this.getAttribute('data-color'));
                            });
                            btn.addEventListener('mouseleave', function() {
                                this.style.removeProperty('--hover-color');
                            });
                        });

                        // Native Share API support
                        document.querySelectorAll('.js-native-share').forEach(btn => {
                            if (navigator.share) {
                                btn.classList.remove('d-none');
                                btn.addEventListener('click', function() {
                                    navigator.share({
                                        title: this.getAttribute('data-title'),
                                        text: this.getAttribute('data-text'),
                                        url: this.getAttribute('data-url')
                                    }).then(() => {
                                        window.socialShare.track('native', this.getAttribute('data-url'));
                                    }).catch(err => console.log('Share failed:', err));
                                });
                            }
                        });

                        // Copy to Clipboard logic
                        document.querySelectorAll('.js-copy-link').forEach(btn => {
                            btn.addEventListener('click', function() {
                                const url = this.getAttribute('data-url');
                                const showSuccess = () => {
                                    const tooltip = this.querySelector('.copy-tooltip');
                                    if (tooltip) {
                                        tooltip.classList.remove('d-none');
                                        setTimeout(() => tooltip.classList.add('d-none'), 2000);
                                    }
                                    window.socialShare.track('copy_link', url);
                                };

                                if (navigator.clipboard && navigator.clipboard.writeText) {
                                    navigator.clipboard.writeText(url).then(showSuccess).catch(() => {
                                        // Fallback if clipboard API fails
                                        copyFallback(url, showSuccess);
                                    });
                                } else {
                                    copyFallback(url, showSuccess);
                                }
                            });
                        });

                        function copyFallback(text, callback) {
                            const textArea = document.createElement("textarea");
                            textArea.value = text;
                            textArea.style.position = "fixed";
                            textArea.style.left = "-9999px";
                            textArea.style.top = "0";
                            document.body.appendChild(textArea);
                            textArea.focus();
                            textArea.select();
                            try {
                                if (document.execCommand('copy')) {
                                    callback();
                                }
                            } catch (err) {
                                console.error('Fallback copy failed', err);
                            }
                            document.body.removeChild(textArea);
                        }
                    };

                    setupButtons();
                });
            </script>
        @endpush
    @endonce
@endif