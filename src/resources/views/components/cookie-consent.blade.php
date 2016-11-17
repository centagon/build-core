@if (!$cookie_exists)

    <div id="build-cookie-consent">
        <span class="cookie-consent__message">
            {{ trans('build.core::cookie-consent.message') }}
        </span>

        <button class="cookie-consent__agree">
            {{ trans('build.core::cookie-consent.agree') }}
        </button>
    </div>

    <script>

        window.cookieConsent = (function () {
            function consent() {
                set('{{ $cookie_name }}', 1, 365 * 20);
                hide();
            }

            function exists(name) {
                return (document.cookie.split('; ').indexOf(name + '=1') !== -1);
            }

            function hide() {
                var dialog = document.getElementById('build-cookie-consent');

                if (dialog) {
                    dialog.style.display = 'none';
                }
            }

            function set(name, value, expiration) {
                var date = new Date();

                date.setTime(date.getTime() + (expiration * 24 * 60 * 60 * 1000));

                document.cookie = name + '=' + value + '; expires=' + date.toUTCString() + ';path=/';
            }

            if (exists('{{ $cookie_name }}')) {
                hide();
            }

            var buttons = document.getElementsByClassName('cookie-consent__agree');

            for (var i = 0; i < buttons.length; i++) {
                buttons[i].addEventListener('click', consent);
            }

            return {
                consent: consent,
                hide: hide
            }
        })();

    </script>
@endif