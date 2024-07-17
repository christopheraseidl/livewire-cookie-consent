<div id="cookie-policy">
    <livewire:cookie-consent-changer />

    <h1><strong>{{ config('app.name') }}</strong> advises about the use of cookies on its website: <a href="{{ config('app.url') }}">{{ config('app.url') }}.</a></h1>

    <h2>What are cookies?</h2>

    <p>Cookies are files that can be downloaded to your computer by websites. They are tools that play an essential role in the provision of many information society services. Among other things, they allow a website to store and retrieve information about the browsing habits of a user or their computer and, depending on the information obtained, they can be used to recognize the user and improve the service offered.</p>

    <h2>Types of cookies</h2>

    <p>Depending on who is the entity that manages the domain from which cookies are sent and treat the data obtained can distinguish two types:</p>

    <ol>
        <li>First-party cookies: those that are sent to the user's terminal equipment from a computer or domain managed by the editor itself and from which the service requested by the user is provided.</li>
        <li>Third-party cookies: those that are sent to the user's terminal equipment from a computer or domain that is not managed by the editor, but by another entity that processes the data obtained through the cookies.</li>
    </ol>

    <p>In the event that the cookies are installed from a computer or domain managed by the editor itself but the information collected through them is managed by a third party, they cannot be considered first-party cookies.</p>

    <p>There is also a second classification according to the period of time they remain on the website. These may be:</p>

    <ol>
        <li>Session cookies: designed to collect and store data while the user accesses a web page. They are usually used to store information that is only interesting to keep for the provision of the service requested by the user on a single occasion (e.g. a list of products purchased).</li>
        <li>Persistent cookies: the data remains stored in the terminal and can be accessed and processed for a period defined by the cookie manager, which can range from a few minutes to several years.</li>
    </ol>

    <p>Finally, there is another classification according to the purpose for which the data obtained are processed:</p>

    <ol>
        <li>Technical cookies: those that allow the user to navigate through a website, platform or application and the use of the different options or services that exist in it such as, for example, control traffic and data communication, identify the session, access parts of restricted access, remember the elements that make up an order, make the buying process of an order, make the application for registration or participation in an event, use security features during navigation, store content for broadcasting videos or sound or share content through social networks.</li>
        <li>Customization cookies: allow the user to access the service with some general characteristics predefined according to a series of criteria in the user's terminal such as the language, the type of browser through which you access the service, the locale from which you access the service, etc.</li>
        <li>Analysis cookies: allow the responsible for them, monitoring and analyzing the behavior of users of the websites to which they are linked. The information collected through this type of cookies is used to measure the activity of the websites, application or platform and for the elaboration of browsing profiles of the users of these sites, applications and platforms, in order to introduce improvements based on the analysis of the usage data of the users of the service.</li>
        <li>Advertising cookies: allow the management, in the most effective way possible, of advertising spaces.</li>
        <li>Behavioral advertising cookies: store information on the behavior of users obtained through the continuous observation of their browsing habits, which allows the development of a specific profile to display advertising based on the same.</li>
        <li>Cookies external social networks: used so that visitors can interact with the content of different social platforms (facebook, youtube, twitter, linkedIn, etc.) and that are generated only for users of such social networks. The conditions of use of these cookies and the information collected is regulated by the privacy policy of the corresponding social platform.</li>
    </ol>

    <h2>Disabling and deleting cookies</h2>

    <p>You have the option to allow, block or delete cookies installed on your computer by configuring the browser options installed on your computer. By disabling cookies, some of the available services may no longer be operational. The way to disable cookies is different for each browser, but can usually be done from the Tools or Options menu.</p>

    <p>You can also consult the browser's Help menu where you can find instructions. The user may at any time choose which cookies he/she wants to operate on this website. You can allow, block or delete cookies installed on your computer by configuring the options of the browser installed on your computer:</p>

    <ul>
        <li><a href="{{ __('cookie-consent::links.microsoft_cookie_link') }}" target="_blank">Microsoft Internet Explorer or Microsoft Edge</a></li>
        <li><a href="{{ __('cookie-consent::links.firefox_cookie_link') }}" target="_blank">Mozilla Firefox</a></li>
        <li><a href="{{ __('cookie-consent::links.chrome_cookie_link') }}" target="_blank">Chrome</a></li>
        <li><a href="{{ __('cookie-consent::links.safari_cookie_link') }}" target="_blank">Safari</a></li>
        <li><a href="{{ __('cookie-consent::links.opera_cookie_link') }}" target="_blank">Opera</a></li>
    </ul>

    <h2>Statement of cookies used on {{ config('app.url') }}</h2>

    <p>The cookies we use are the following:</p>

    <ul>
        <li>"cas_laravel_cookie_consent," to detect the acceptance or rejection of the cookie policy, with a duration of either one year (in case of positive answer) or one month (in case of negative answer).</li>
        <li>"XSRF-TOKEN," to protect the web page against XSS attacks.</li>
    </ul>

    <h2>Acceptance of cookie policy</h2>

    <p>{{ config('app.name') }} assumes that you accept the use of cookies. However, it displays information about its cookie policy at the bottom or top of any page of the portal with each login in order to make you aware of it.</p>

    <p>In view of this information it is possible to carry out the following actions:</p>

    <ol>
        <li>Accept cookies. This notice will not be displayed again when accessing any page of the portal during the current session.</li>
        <li>Reject or close. The warning is hidden.</li>
        <li>Modify your settings. By visiting the cookie policy of <a href="{{ config('app.url') }}">{{ config('app.url') }}</a>, you may accept or reject the use of cookies.</li>
    </ol>
</div>